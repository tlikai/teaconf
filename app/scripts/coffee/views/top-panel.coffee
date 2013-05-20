define [
    'chaplin'
    'views/base/view'
    'text!views/templates/top-panel.html'
], (Chaplin, View, template) ->
    'use strict'

    class TopPanelView extends View
        el: '.top-panel'
        autoRender: yes
        region: 'top-panel'
        template: template

        initialize: ->
            @subscribeEvent '!user:refresh', @render
