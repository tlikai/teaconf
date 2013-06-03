define [
    'views/base/view'
    'text!views/templates/user/notifications/item.html'
], (View, template) ->
    'use strict'

    class TopicItemView extends View

        template: template

        events:
            'click .unread': (e) ->
                e.preventDefault()
                @model.read
                    success: (resp) ->
                        console.debug '123'
                    error: (resp) ->
                        console.debug resp.responseText
