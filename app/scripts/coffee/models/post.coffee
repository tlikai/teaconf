define [
    'models/base/model'    
], (Model) ->
    'use strict'

    class Post extends Model

        urlPath: ->
            if @isNew() then '/posts' else '/post';

        like: (options) ->
            id = @get 'id'
            _.extend options,
                url: "#{API_URL}/post/#{id}/like"
                method: 'POST'
            $.ajax options

        watch: (options) ->
            id = @get 'id'
            _.extend options,
                url: "#{API_URL}/post/#{id}/watch"
                method: 'POST'
            $.ajax options
