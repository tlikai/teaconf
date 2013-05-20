define [
    'views/base/view'
    'handlebars'
    'text!views/templates/topic/item.html'
], (View, Handlebars, template) ->
    'use strict'

    class TopicItemView extends View
        tagName: 'tr'
        template: template
