define [
    'chaplin'
    'models/user'
    'views/base/page-view'
    'views/alert'
    'text!views/templates/site/login.html'
], (Chaplin, User, PageView, AlertView, template) ->
    'use strict'

    class SiteLoginView extends PageView
        autoRender: yes
        template: template

        initialize: ->
            super
            if Chaplin.mediator.user?
                Chaplin.mediator.publish '!router:routeByName', 'index'

            @alert = new AlertView

        events: 
            'submit #login-form': (e) ->
                e.preventDefault()

                User.login
                    data: @$('#login-form').serializeJSON()
                    success: (resp) =>
                        @alert.success '登录成功'
                        Chaplin.mediator.user = resp
                        Chaplin.mediator.publish '!user:refresh'
                        setTimeout -> 
                            Chaplin.mediator.publish '!router:routeByName', 'index'
                        , 500
                    error: (xhr) =>
                        @alert.error xhr.responseText
