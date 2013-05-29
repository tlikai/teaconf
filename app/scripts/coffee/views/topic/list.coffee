define [
    'chaplin'
    'views/base/collection-view'
    'views/topic/item'
    'views/loading'
    'text!views/templates/topic/list.html'
], (Chaplin, CollectionView, TopicItemView, LoadingView, template) ->
    'use strict'

    class TopicListView extends CollectionView

        itemView: TopicItemView

        listSelector: '.topic-list'

        template: template

        addCollectionListeners: ->
            super
            @subscribeEvent 'before:fetch', ->
                @loadingView = new LoadingView message: '主题加载中...', container: $('.list')
            @subscribeEvent 'after:fetch', ->
                @loadingView.dispose() if @loadingView?
                @loadingView = null
                @loading = no

        render: ->
            super

            @loading = no
            $(window).scroll () =>
                if $(window).scrollTop()  >= $(document).height() - $(window).height() and !@loading
                    @loading = yes
                    @collection.hasNextPage() and @collection.nextPage()

        setActiveTab: (tab) ->
            @$(".tabs li.#{tab}").addClass 'active'
