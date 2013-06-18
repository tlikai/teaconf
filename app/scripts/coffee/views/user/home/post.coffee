define [
    'views/base/collection-view'
    'views/user/home/post-item'
    'text!views/templates/user/home/post.html'
], (CollectionView, PostItemView, template) ->
    'use strict'

    class HomePostView extends CollectionView

        listSelector: '.post-item-region'

        fallbackSelector: '.empty-region'

        itemView: PostItemView

        template: template
