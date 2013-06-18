define [
    'models/base/pageable-collection'
    'models/topic'
], (PageableCollection, Topic) ->
    'use strict'

    class Topics extends PageableCollection

        constructor: (options) ->
            @user = options.user if options?.user?
            super

        model: Topic

        urlPath: -> 
            if @user?
                id = @user.get 'id'
                @user.urlPath() + "/#{id}/topics"
            else
                '/topics'
