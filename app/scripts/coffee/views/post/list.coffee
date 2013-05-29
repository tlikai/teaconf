define [
    'chaplin'
    'views/base/collection-view'
    'views/post/item'
    'views/alert'
    'views/loading'
    'models/post'
    'models/posts'
    'text!views/templates/post/list.html'
], (Chaplin, CollectionView, PostItemView, AlertView, LoadingView, Post, Posts, template) ->
    'use strict'
    
    class PostListView extends CollectionView

        itemView: PostItemView

        template: template

        addCollectionListeners: ->
            super
            @subscribeEvent 'before:fetch', ->
                @loadingView = new LoadingView message: '回复加载中...', container: $('.post:last').prev()
            @subscribeEvent 'after:fetch', ->
                @loadingView.dispose() if @loadingView?
                @loadingView = null
                @loading = no

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

            @loading = no
            $(window).scroll () =>
                if $(window).scrollTop()  >= $(document).height() - $(window).height() and !@loading
                    @loading = yes
                    @collection.hasNextPage() and @collection.nextPage()

        getTemplateData: ->
            data = super
            _.extend data, 
                topic: @model
            data
