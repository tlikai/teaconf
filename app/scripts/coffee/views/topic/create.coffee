define [
    'chaplin'
    'views/base/page-view'
    'views/alert'
    'views/node/selector'
    'models/topic'
    'models/nodes'
    'text!views/templates/topic/create.html'
], (Chaplin, PageView, AlertView, NodeSelectorView, Topic, Nodes, template) ->
    'use strict'

    class TopicCreateView extends PageView
        autoRender: yes
        template: template

        events: 
            'submit #create-form': (e) ->
                e.preventDefault()

                topic = new Topic
                topic.save @$('#create-form').serializeJSON(),
                    success: (resp) =>
                        Chaplin.mediator.publish '!router:routeByName', 'topic#show', id: resp.id
                    error: (resp, xhr) =>
                        @alert.error xhr.responseText

        render: ->
            super

            @alert = new AlertView

            @nodes = new Nodes
            @nodeSelectorView = new NodeSelectorView container: @$('#selector-placeholder'), collection: @nodes
            @subview 'nodeSelectorView', @nodeSelectorView
            @nodes.fetch()
