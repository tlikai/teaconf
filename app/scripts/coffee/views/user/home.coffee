define [
    'views/base/collection-view'
    'text!views/templates/user/home.html'
], (CollectionView, template) ->
    'use strict'

    class UserHomeView extends CollectionView

        template: template

        listSelector: '.homeListView'

        getTemplateData: ->
            data = super
            console.debug data
            data
