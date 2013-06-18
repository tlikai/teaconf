define [
    'views/base/view'
    'text!views/templates/user/home/post-item.html'
], (View, template) ->
    'use strict'

    class PostItemView extends View

        tagName: 'tr'

        template: template
