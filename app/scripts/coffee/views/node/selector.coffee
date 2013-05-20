define [
    'views/base/view'
    'text!views/templates/node/selector.html'
    'css!components/chosen/chosen/chosen.css'
    'components/chosen/chosen/chosen.jquery'
], (View, template) ->
    'use strict'

    class NodeSelectorView extends View

        template: template

        render: ->
            super
            @$('.chzn-select').chosen
                no_results_text: '节点不存在'
