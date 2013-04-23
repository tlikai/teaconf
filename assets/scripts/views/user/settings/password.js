define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/user/settings/password.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        initialize: function(){
            this.listenTo(this.model, 'change', this.render);
        },
        events: {
            'click .submit': 'updatePassword'
        },
        render: function(){
            console.log('render: user/settings/password');
            var ctemplate = Handlebars.compile(template);
            var data = {
                user: this.model.toJSON(),
            };
            this.$el.html(ctemplate(data));
        },

        // 修改密码
        updatePassword: function(e){
            e.preventDefault();
            var self = this;
            var $alert = this.$('.password-form .alert');
            var attrs = {
                id: App.user.get('id'),
                password: this.$('#currentPassword').val(),
                newPassword: this.$('#newPassword').val(),
                confirmPassword: this.$('#confirmPassword').val(),
            }

            $alert.fadeOut('fast');
            $.ajax({
                url: API_URL + '/user/changePassword',
                data: attrs,
                method: 'PUT',
                success: function(data){
                    $alert.html('修改成功').addClass('alert-success').fadeIn('fast');
                    self.$('#currentPassword,#newPassword,#confirmPassword').val('');
                },
                error: function(xhr){
                    $alert.html(xhr.responseText).fadeIn('fast');
                }
            });
        }
    });
});
