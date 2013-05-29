define [
    'views/base/view'    
], (View, template) ->
    'use strict'

    class LoadingView extends View
        autoRender: yes
        className: 'loading'

        constructor: (options) ->
            if options.message?
                @template = options.message
            super
