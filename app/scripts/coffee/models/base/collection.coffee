define [
    'chaplin'    
    'models/base/model'
    'backbone-pageable'
], (Chaplin, Model, PageableCollection) ->
    'use strict'

    class Collection extends Chaplin.Collection

        url: ->
            API_URL + @urlPath()

        model: Model

        parse: (data) ->
            return data.data
