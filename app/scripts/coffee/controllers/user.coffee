define [
    'chaplin'
    'controllers/base/controller'
    'models/user'
    'models/notifications'
    'views/user/settings'
    'views/user/notifications'
], (Chaplin, Controller, User, Notifications, UserSettingsView, UserNotificationsView) ->
    'use strict'

    class UserController extends Controller
        
        loginRequire: ->
            Chaplin.mediator.user or Chaplin.mediator.publish '!router:routeByName', 'login'

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
