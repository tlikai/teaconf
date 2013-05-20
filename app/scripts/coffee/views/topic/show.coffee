define [
    'views/base/page-view'
    'views/post/list'
    'text!views/templates/topic/show.html'
], (PageView, PostListView, template) ->
    'use strict'

    class TopicShowView extends PageView

        template: template

        regions: 
            '.post-list-view': 'posts'

        events:
            'click .topic .action-like': (e) ->
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

            'click .topic .action-watch': (e) ->
                e.preventDefault()
                $o = $ e.currentTarget
                @model.watch
                    success: (resp) ->
                        $o.tooltip
                            trigger: 'hover'
                            title: '已关注'
                        $o.tooltip 'show'
                    error: (xhr) ->
                        $o.tooltip
                            trigger: 'hover'
                            title: xhr.responseText
                        $o.tooltip 'show'

            'click .topic .action-reply': (e) ->
                e.preventDefault()
                $o = $ e.currentTarget

        render: ->
            super
            @postListView = new PostListView model: @model, collection: @model.fetchPosts(), region: 'posts'
            @postListView.topic = @model
            @subview 'postListView', @postListView
