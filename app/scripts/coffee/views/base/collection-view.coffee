define [
  'chaplin',
  'views/base/view'
], (Chaplin, View) ->
  'use strict'

  class CollectionView extends Chaplin.CollectionView

      region: 'main'

      useCssAnimation: true

      getTemplateData: View::getTemplateData

      getTemplateFunction: View::getTemplateFunction
