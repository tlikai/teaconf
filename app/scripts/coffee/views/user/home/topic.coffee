define [
    'views/base/view'
    'text!views/templates/user/home/topic.html'
], (View, template) ->
    'use strict'

    class UserTopicView extends View

        tagName: 'tr'

        template: template
