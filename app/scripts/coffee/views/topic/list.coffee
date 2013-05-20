define [
    'views/base/collection-view'
    'views/topic/item'
    'text!views/templates/topic/list.html'
], (CollectionView, TopicItemView, template) ->
    'use strict'

    class TopicListView extends CollectionView

        events:
            'click .next': (e) ->
                console.debug @collection.state
                console.debug @collection.hasNext()
                @collection.getNextPage silent: false if @collection.hasNext()
            'click .prev': (e) ->
                console.debug @collection
                @collection.getPreviousPage silent: false if @collection.hasPrevious()

        itemView: TopicItemView

        listSelector: '.topic-list'

        template: template

        render: ->
            super

            $(window).scroll () =>
                if $(window).height() + $(window).scrollTop() >= $(document.body).height()
                    @collection and @collection.nextPage()

        setActiveTab: (tab) ->
            @$(".tabs li.#{tab}").addClass 'active'
