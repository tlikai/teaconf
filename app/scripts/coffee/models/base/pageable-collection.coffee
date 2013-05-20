define [
    'models/base/collection'
], (Collection) ->
    'use strict'

    class PageableCollection extends Collection

        constructor: () ->
            @pagination.currentPage = 0
            super

        pagination:
            pageSize: 15
            totalPages: 0
            totalItems: 0
            currentPage: 0

        fetch: (options) ->
            options ?= {}
            options.data =
                _.extend
                    page: @pagination.currentPage
                    perpage: @pagination.pageSize
                , options.data ? {}

            return super options

        parse: (data) ->
            #@pagination.pageSize = data.perpage
            @pagination.totalItems = data.total
            @pagination.totalPages = Math.ceil @pagination.totalItems / @pagination.pageSize
            return data.data

        prevPage: ->
            if @pagination.currentPage <= 0
                return false
            @pagination.currentPage--
            @fetch add: true, remove: false

        nextPage: ->
            if @pagination.currentPage >= @pagination.totalPages
                return false
            @pagination.currentPage++
            @fetch add: true, remove: false
