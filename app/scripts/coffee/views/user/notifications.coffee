define [
    'chaplin'
    'views/base/collection-view'
    'views/user/notifications/item'
    'text!views/templates/user/notifications.html'
], (Chaplin, CollectionView, NotificationItemView, template) ->
    'use strict'

    class UserNotificationsView extends CollectionView

        constructor: (options) ->
            if options.unread?
                @unread = options.unread
            super

        events:
            'click .all-read': (e) ->
                e.preventDefault()
                $('.unread').each (i, o) ->
                    $(o).trigger 'click'

        template: template

        itemView: NotificationItemView

        listSelector: '.notifications'

        render: ->
            super
            @setActive()

        setActive: ->
            className = if @unread then 'unread' else 'all'
            $(".nav-#{className}").addClass('active')

        getTemplateData: ->
            data = super
            data.unread = @unread
            data

