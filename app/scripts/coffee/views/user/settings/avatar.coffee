define [
    'views/base/view'
    'views/alert'
    'text!views/templates/user/settings/avatar.html'
], (View, AlertView, template) ->
    'use strict'

    class SettingsAvatarView extends View

        autoRender: yes

        template: template

        events: 
            'submit #profile-form': (e) ->
                e.preventDefault()

                @model.save @$('#profile-form').serializeJSON(),
                    success: (resp) =>
                        @alert.success '修改成功'
                    error: (resp, xhr) =>
                        @alert.error xhr.responseText

        render: ->
            super
            @alert = new AlertView
