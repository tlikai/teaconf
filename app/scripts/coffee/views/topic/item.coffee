define [
    'views/base/view'
    'text!views/templates/topic/item.html'
], (View, template) ->
    'use strict'

    class TopicItemView extends View

        tagName: 'tr'

        template: template
