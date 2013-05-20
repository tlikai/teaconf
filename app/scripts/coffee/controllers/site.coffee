define [
    'chaplin'
    'controllers/base/controller'
], (Chaplin, Controller) ->
    'use strict'

    class SiteController extends Controller
        
        login: ->
            require [
                'views/site/login'
            ], (SiteLoginView) =>
                @view = new SiteLoginView

        logout: ->
            require [
                'models/user'
            ], (User) ->
                User.logout
                    success: (resp) ->
                        Chaplin.mediator.user = null
                        Chaplin.mediator.publish '!user:refresh'
                        Chaplin.mediator.publish '!router:routeByName', 'index'
                    error: (xhr) ->
                        Chaplin.mediator.publish '!router:routeByName', 'index'

        register: ->
            require [
                'views/site/register'
            ], (SiteRegisterView) =>
                @view = new SiteRegisterView
