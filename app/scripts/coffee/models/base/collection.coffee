define [
    'chaplin'    
    'models/base/model'
    'backbone-pageable'
], (Chaplin, Model, PageableCollection) ->
    'use strict'

    class Collection extends Chaplin.Collection

        #class Collection extends PageableCollection

        url: ->
            API_URL + @urlPath()

        model: Model

        parse: (data) ->
            @state.pageSize = data.perpage
            @state.totalRecords = data.total
            @state.totalPages = Math.ceil @state.totalRecords / @state.pageSize
            @state.lastPage = @state.totalPages - 1
            return data.data

        state:
            firstPage: 0
            currentPage: 0
            pageSize: 15 

        queryParams:
            pageSize: 'perpage'
            currentPage: 'page'
