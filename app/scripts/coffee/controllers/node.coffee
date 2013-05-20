define [
    'controllers/base/controller'
    'models/nodes'
    'views/node/list'
], (Controller, Nodes, NodeListView) ->
    'use strict'

    class NodeController extends Controller
        
        list: ->
            @collection = new Nodes
            @view = new NodeListView {@collection}
            @collection.fetch()
