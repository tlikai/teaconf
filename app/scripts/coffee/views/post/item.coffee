define [
    'views/base/view'
    'text!views/templates/post/item.html'
], (View, template) ->
    'use strict'
    
    class PostItemView extends View

        template: template

        events:
            'click .post .action-like': (e) ->
                e.preventDefault()
                $o = $ e.currentTarget
                @model.like
                    success: (resp) ->
                        $o.tooltip
                            trigger: 'hover'
                            title: '已标记为喜欢'
                        $o.tooltip 'show'
                    error: (xhr) ->
                        $o.tooltip
                            trigger: 'hover'
                            title: xhr.responseText 
                        $o.tooltip 'show'

            'click .post .action-reply': (e) ->
                e.preventDefault()
                console.debug 'reply'
