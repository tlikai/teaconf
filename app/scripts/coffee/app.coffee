define [
    'chaplin'
    'routers'
    'views/layout'
], (Chaplin, routers, Layout) ->
    'use strict'

    class Application extends Chaplin.Application

        initialize: ->
            super

            @initDispatcher controllerSuffix: ''
            @initRouter routers, root: '/', pushState: yes
            @initComposer()
            @initLayout()
            @initMediator()

            @initComponent()
            @initUser()

            @startRouting()

            Object.freeze? @

        initLayout: ->
            super
            @layout = new Layout @title


        initMediator: ->
            Chaplin.mediator.user = null
            Chaplin.mediator.seal()

        initComponent: ->
            require [
                'jquery'
            ], ($) ->
                
                $.ajaxSetup 
                    global: yes
                    dataType: 'json'
                    statusCode: 
                        401: (xhr) -> 
                            console.debug('401', xhr)
                        404: (xhr) -> 
                            console.debug('404', xhr)

            $.fn.extend
                serializeJSON: ->
                    data = {}
                    $.each @serializeArray(), (i, item) ->
                        data[item.name] = item.value

                    console.debug data
                    data

        initUser: ->
            require [
                'models/user'
            ], (User) ->
                User.authenticate()
