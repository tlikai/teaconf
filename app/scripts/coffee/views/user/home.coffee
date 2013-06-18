define [
    'views/base/page-view'
    'models/topics'
    'views/user/home/topic'
    'text!views/templates/user/home.html'
], (PageView, Topics, HomeTopicView, template) ->
    'use strict'

    class UserHomeView extends PageView

        regions:
            '.home-list-region': 'home-list-region'

        template: template
