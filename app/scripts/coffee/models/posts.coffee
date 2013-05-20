define [
    'models/base/pageable-collection'
    'models/post'
], (PageableCollection, Post) ->
    'use strict'

    class Posts extends PageableCollection

        topic: null

        model: Post

        urlPath: -> 
            @topic.urlPath() + '/' + @topic.id + '/posts'
