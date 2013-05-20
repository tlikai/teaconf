define [
    'chaplin'
    'views/site'
    'views/top-panel'
], (Chaplin, SiteView, TopPanelView) ->
    'use strict'

    class Controller extends Chaplin.Controller

        beforeAction: 
            '.*': (params, route) ->
                @compose 'site', SiteView
                @compose 'top-panel', TopPanelView
                #@compose 'session', ->
                #    require [
                #        'controllers/session'
                #    ], (SessionController) =>
                #        @controller = new SessionController

                console.debug 'Run', route.controller + '#' + route.action
