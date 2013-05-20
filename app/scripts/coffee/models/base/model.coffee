define [
    'chaplin'    
], (Chaplin) ->
    'use strict'

    class Model extends Chaplin.Model

        urlRoot: ->
             API_URL + @urlPath()
