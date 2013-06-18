define [
    'chaplin'
    'controllers/base/controller'
    'models/user'
    'models/notifications'
    'views/user/home'
    'views/user/settings'
    'views/user/notifications'
], (Chaplin, Controller, User, Notifications, UserHomeView, UserSettingsView, UserNotificationsView) ->
    'use strict'

    class UserController extends Controller
        
        loginRequire: ->
            Chaplin.mediator.user or Chaplin.mediator.publish '!router:routeByName', 'login'

        home: (params) ->
            @model = new User id: params.id
            @view = new UserHomeView {@model}

            @model.fetch
                success: =>
                    if params.topic?
                        require [
                            'models/topics'
                            'views/user/home/topic'
                        ], (Topics, HomeTopicView) =>
                            @collection = new Topics user: @model
                            @view.subView = new HomeTopicView collection: @collection, region: 'home-list-region'
                            @collection.fetch()

                    if params.post?
                        require [
                            'models/posts'
                            'views/user/home/post'
                        ], (Posts, HomePostView) =>
                            @collection = new Posts user: @model
                            @view.subView = new HomePostView collection: @collection, region: 'home-list-region'
                            @collection.fetch
                                success: (resp) ->
                                    console.debug respkj

        settings: ->
            @loginRequire()

            @model = new User id: Chaplin.mediator.user.id
            @view = new UserSettingsView {@model}
            @model.fetch()

        notifications: (params) ->
            @loginRequire()

            @collection = new Notifications
            @view = new UserNotificationsView
                collection: @collection
                unread: params.unread
            @collection.fetch
                data:
                    unread: if params.unread then 1 else 0
                success: =>
                    @view.setActive()
