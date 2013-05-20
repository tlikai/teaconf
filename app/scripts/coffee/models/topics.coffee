define [
    'models/base/pageable-collection'
    'models/topic'
], (PageableCollection, Topic) ->
    'use strict'

    class Topics extends PageableCollection

        model: Topic

        urlPath: -> 
            '/topics'
