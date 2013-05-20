define [
    'views/base/view'    
], (View, template) ->
    'use strict'

    class AlertView extends View
        rendered: no

        container: '.alert-area'
        className: 'alert fade in'
        autoRender: no

        
        initialize: ->
            @$el.show()

        show: (options) ->
            if typeof options == 'string'
                message = options
                options = message: message

            @$el.html options.message
            if !@rendered
                @render()
                @rendered = yes

            @$el.attr 'class', "#{@className} #{options.class}" if options.class?

        render: ->
            if !@rendered
                super
            no

        success: (message) ->
            @show message: message, class: 'alert-success'

        error: (message) ->
            @show message: message, class: 'alert-error'

        info: (message) ->
            @show message: message, class: 'alert-info'
