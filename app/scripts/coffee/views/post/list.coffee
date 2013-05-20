define [
    'chaplin'
    'views/base/collection-view'
    'views/post/item'
    'views/alert'
    'models/post'
    'models/posts'
    'text!views/templates/post/list.html'
], (Chaplin, CollectionView, PostItemView, AlertView, Post, Posts, template) ->
    'use strict'
    
    class PostListView extends CollectionView
        itemView: PostItemView
        template: template

        events:
            'submit #post-form': (e) ->
                e.preventDefault()
                post = new Post
                post.save @$('#post-form').serializeJSON(),
                    success: (resp) =>
                        @collection.add post
                    error: (resp, xhr) =>
                        @alert.error xhr.responseText

        render: ->
            super
            @alert = new AlertView

        getTemplateData: ->
            data = super
            _.extend data, 
                topic: @model
            data
