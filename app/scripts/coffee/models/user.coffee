define [
    'chaplin'
    'models/base/model'
], (Chaplin, Model) ->
    'use strict'

    class User extends Model

        urlPath: ->
            '/user'

        @login: (options) ->
            _.extend options, 
                url: API_URL + '/login'
                method: 'POST'
            $.ajax options

        @register: (options) ->
            _.extend options, 
                url: API_URL + '/register'
                method: 'POST'
            $.ajax options
        
        @logout: (options) ->
            _.extend options, 
                url: API_URL + '/logout'
                method: 'DELETE'
            $.ajax options

        @authenticate: (options) ->
            options ?= {}
            $.ajax
                url: API_URL + '/authenticate'
                method: 'GET'
                async: false
                success: (resp) ->
                    Chaplin.mediator.user = resp
                    options.success.apply(this, arguments) if options.success

                error: (xhr) ->
                    Chaplin.mediator.user = null
                    options.error.apply(this, arguments) if options.error

                statusCode: 
                    401: (xhr) ->
                        options.error.apply(this, arguments) if options.unAuthenticate


        changePassword: (options) ->
            _.extend options, 
                url: API_URL + '/user/changePassword'
                method: 'PUT'
            $.ajax options

        topics: (options) ->
            user_id = @get('id')

            _.extend options, 
                url: "#{API_URL}/user/#{user_id}/topics"
                method: 'GET'

            $.ajax options
