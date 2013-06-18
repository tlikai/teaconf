define [
    'models/base/pageable-collection'
    'models/post'
], (PageableCollection, Post) ->
    'use strict'

    class Posts extends PageableCollection

        constructor: (options) ->
            @user = options.user if options?.user?
            @topic = options.topic if options?.topic?
            super

        user: null

        topic: null

        model: Post

        urlPath: -> 
            if @user?
                id = @user.get 'id'
                @user.urlPath() + "/#{id}/posts"
            else
                @topic.urlPath() + '/' + @topic.id + '/posts'
