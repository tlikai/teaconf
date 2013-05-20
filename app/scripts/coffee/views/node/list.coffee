define [
    'views/base/page-view'
    'text!views/templates/node/list.html'
], (PageView, template) ->
    'use strict'

    class NodeListView extends PageView

        template: template
