define [
    'views/base/collection-view'
    'views/user/home/topic-item'
    'text!views/templates/user/home/topic.html'
], (CollectionView, TopicItemView, template) ->
    'use strict'

    class HomeTopicView extends CollectionView

        listSelector: '.topic-item-region'

        fallbackSelector: '.empty-region'

        itemView: TopicItemView

        template: template
