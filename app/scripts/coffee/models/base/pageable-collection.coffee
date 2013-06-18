define [
    'chaplin'
    'models/base/collection'
], (Chaplin, Collection) ->
    'use strict'

    class PageableCollection extends Collection

        constructor: () ->
            @pagination.currentPage = 0
            super

        pagination:
            pageSize: 20
            totalPages: 0
            totalItems: 0
            currentPage: 0

        fetch: (options) ->
            Chaplin.mediator.publish 'before:fetch'
            options ?= {}
            options.data =
                _.extend
                    page: @pagination.currentPage
                    perpage: @pagination.pageSize
                , options.data ? {}

            success = options.success
            options.success = (resp) ->
                Chaplin.mediator.publish 'after:fetch'
                if success
                    success resp, options
            super options

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

        hasNextPage: ->
            @pagination.currentPage + 1 < @pagination.totalPages
