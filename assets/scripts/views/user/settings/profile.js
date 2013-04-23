define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/user/settings/profile.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        initialize: function(){
            this.listenTo(this.model, 'change', this.render);
        },
        events: {
            'click .submit': 'updateProfile'
        },
        render: function(){
            console.log('render: user/settings/profile');
            var ctemplate = Handlebars.compile(template);
            var data = {
                user: this.model.toJSON(),
            };
            this.$el.html(ctemplate(data));
        },

        // 修改资料
        updateProfile: function(e){
            e.preventDefault();
            var $alert = this.$('.alert');
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
        }
    });
});
