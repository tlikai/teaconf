define [
  'chaplin',
  'views/base/view'
], (Chaplin, View) ->
  'use strict'

  class CollectionView extends Chaplin.CollectionView

      region: 'main'

      useCssAnimation: true


      getTemplateData: ->
          data = super
          _.extend data, 
              Chaplin: Chaplin
          data


      getTemplateFunction: View::getTemplateFunction
