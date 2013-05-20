define [
    'chaplin'
    'controllers/base/controller'
    'models/topic'
    'models/topics'
    'views/topic/list'
    'views/topic/show'
    'views/topic/create'
], (Chaplin, Controller, Topic, Topics, TopicListView, TopicShowView, TopicCreateView) ->
    'use strict'

    class TopicController extends Controller
        
        list: (params) ->
            _.defaults params, 
                tab: 'popular'
                node: null

            if !Chaplin.mediator.user and params.tab == 'watch'
                Chaplin.mediator.publish '!router:routeByName', 'login'

            @collection = new Topics
            @view = new TopicListView {@collection}
            @collection.fetch data: params
            @view.setActiveTab params.tab

        show: (params) ->
            @model = new Topic id: params.id
            @view = new TopicShowView {@model}
            @model.fetch()


        create: ->
            Chaplin.mediator.user or Chaplin.mediator.publish '!router:routeByName', 'login'

            @view = new TopicCreateView
