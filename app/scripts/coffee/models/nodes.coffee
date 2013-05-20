define [
    'models/base/collection'
    'models/node'
], (Collection, Node) ->
    'use strict'

    class Nodes extends Collection

        model: Node

        urlPath: -> 
            '/nodes'
