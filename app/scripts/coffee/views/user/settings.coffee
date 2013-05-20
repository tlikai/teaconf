define [
    'views/base/page-view'
    'text!views/templates/user/settings.html'
], (PageView, template) ->
    'use strict'

    class UserSettingsView extends PageView
        template: template

        events: 
            'click .sidenav a': (e) ->
                viewName = $(e.currentTarget).attr('href').substring(1)
                @setSubView(viewName)

        setSubView: (viewName) ->
            if viewName == @currentSubView
                return no
            @currentSubView = viewName
            if @currentSubView not in ['profile', 'avatar', 'password']
                @currentSubView = 'profile'
            require [
                'views/user/settings/' + @currentSubView
            ], (SettingsView) =>
                typeof @subview == 'object' and @subview.remove()
                @subview = new SettingsView model: @model, container: @$ '#page-area'
                @$('.sidenav li').removeClass('active')
                @$('.sidenav li.nav-' + @currentSubView).addClass('active')

        render: ->
            super
            view = window.location.hash.substring(1)
            @setSubView(view)
