define [
    'views/base/view'
    'views/alert'
    'text!views/templates/user/settings/password.html'
], (View, AlertView, template) ->
    'use strict'

    class SettingsPasswordView extends View

        autoRender: yes

        template: template

        events: 
            'submit #password-form': (e) ->
                e.preventDefault()

                @model.changePassword 
                    data: @$('#password-form').serializeJSON()
                    success: (resp) =>
                        @alert.success '修改成功'
                        setTimeout =>
                            @render()
                        , 500
                    error: (xhr) =>
                        @alert.error xhr.responseText

        render: ->
            super
            @alert = new AlertView
