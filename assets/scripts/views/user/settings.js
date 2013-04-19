define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/user/settings.html',
    'libs/jquery-html5-upload/jquery.html5_upload'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#container'),
        initialize: function(){
            this.listenTo(this.model, 'change', this.render);
        },
        events: {
            'click .profile-form .submit': 'updateProfile',
            'click .avatar-form .choose': 'chooseAvatar',
            'click .password-form .submit': 'updatePassword'
        },
        render: function(){
            console.log('render: user/settings');
            var ctemplate = Handlebars.compile(template);
            var data = {
                user: this.model.toJSON(),
            };
            this.$el.html(ctemplate(data));
        },

        // 修改资料
        updateProfile: function(e){
            e.preventDefault();
            var $alert = this.$('.profile-form .alert');
            var attrs = {
                weibo: this.$('#weibo').val(),
                wechat: this.$('#wechat').val(),
                signature: this.$('#signature').val()
            };

            $alert.fadeOut('fast');
            App.user.save(attrs, {
                error: function(model, xhr){
                    $alert.html(xhr.responseText).fadeIn('fast');
                }
            });
        },

        // 选择头像
        chooseAvatar: function(e){
            var self = this;
            var $file = this.$('#avatar');
            var $alert = this.$('.avatar-form .alert');
            $file.click();

            $alert.fadeOut('fast');
            $file.html5_upload({
                url: API_URL + '/user/updateAvatar',
                sendBoundary: window.FormData || $.browser.mozilla,
                onFinishOne: function(event, data, name, number, total) {
                    var json = $.parseJSON(data);
                    for (var i in json) {
                        App.user.set(i, json[i]);
                    };
                },
                onError: function(event, name, error){
                    $alert.html(error.target.responseText).fadeIn('fast');
                }
            });
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
