define [
    'models/base/model'
    'models/posts'
], (Model, Posts) ->
    'use strict'

    class Topic extends Model

        urlPath: ->
            if @isNew() then '/topics' else '/topic'

        like: (options) ->
            id = @get 'id'
            _.extend options,
                url: "#{API_URL}/topic/#{id}/like"
                method: 'POST'
            $.ajax options

        watch: (options) ->
            id = @get 'id'
            _.extend options,
                url: "#{API_URL}/topic/#{id}/watch"
                method: 'POST'
            $.ajax options

        fetchPosts: ->
            @posts = new Posts
            @posts.topic = @
            @posts.fetch()
            @posts
