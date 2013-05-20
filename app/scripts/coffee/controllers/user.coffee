define [
    'chaplin'
    'controllers/base/controller'
    'models/user'
    'views/user/settings'
], (Chaplin, Controller, User, UserSettingsView) ->
    'use strict'

    class UserController extends Controller
        
        loginRequire: ->
            Chaplin.mediator.user or Chaplin.mediator.publish '!router:routeByName', 'login'

        settings: ->
            @loginRequire()

            
            @model = new User id: Chaplin.mediator.user.id
            @view = new UserSettingsView {@model}
            @model.fetch()
