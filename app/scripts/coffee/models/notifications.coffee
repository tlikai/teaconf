define [
    'models/base/collection'
    'models/notification'
], (Collection, Notification) ->
    'use strict'

    class Nodes extends Collection

        model: Notification

        urlPath: -> 
            '/notifications'
