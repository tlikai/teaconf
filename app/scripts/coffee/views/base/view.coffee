define [
    'chaplin'    
    'handlebars'
    'lib/view-helper'
], (Chaplin, Handlebars) ->
    'use strict'

    class View extends Chaplin.View

        initialize: ->
            super
            @listenTo @model, 'change', @render if @model
            @listenTo @collection, 'sync', @render if @collection

        render: ->
            console.debug 'rendered:', @
            super

        getTemplateData: ->
            data = super
            _.extend data, 
                Chaplin: Chaplin
            data

        getTemplateFunction: ->
            template = @template

            if typeof template is 'string'
                templateFunc = Handlebars.compile template
                @constructor::template = templateFunc
            else
                templateFunc = template

            templateFunc
