define [
    'chaplin'
    'models/base/model'
], (Chaplin, Model) ->
    'use strict'

    class Notification extends Model

        urlPath: ->
            '/notification'
        
        read: (options) ->
            id = @get 'id'
            baseUrl = @urlRoot()
            _.extend options,
                url: "#{baseUrl}/read/#{id}"
                method: 'POST'
            $.ajax options
