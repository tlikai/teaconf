define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/site/resetPassword.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        data: {},
        el: $('#container'),
        events: {
            'click .sendmail': 'sendMail',
            'click .resetPassword': 'resetPassword'
        },
        render: function(){
            if(location.search)
            {
                var query = decodeURI(location.search.substring(1)).split(/&/g);
                for (var i in query) {
                    var kv = query[i].split('=')
                    if(kv.length > 1)
                        this.data[kv[0]] = kv[1];
                }
            }

            console.log('render: site/resetPassword');
            var ctemplate = Handlebars.compile(template);
            this.$el.html(ctemplate(this.data));
            this.$alert = this.$('.alert');
            return this;
        },
        sendMail: function(){
            var self = this;
            var email = this.$('input[name=email]').val();

            this.$alert.fadeOut('fast');
            $.ajax({
                url: API_URL + '/resetPassword',
                method: 'POST',
                data: {
                    email: email
                },
                success: function(data){
                    self.$alert.html('确认邮件已发送，请注意查收').fadeIn('fast');
                },
                error: function(xhr){
                    self.$alert.html(xhr.responseText).fadeIn('fast');
                }
            });
        },
        resetPassword: function(){
            var self = this;
            this.data['newPassword'] = this.$('input[name=newPassword]').val();
            this.data['confirmPassword'] = this.$('input[name=confirmPassword]').val();
            
            this.$alert.fadeOut();
            $.ajax({
                url: API_URL + '/resetPassword',
                method: 'PUT',
                data: this.data,
                success: function(data){
                    self.$alert.html('密码已重置').fadeIn('fast');
                    App.redirect('/');
                },
                error: function(xhr){
                    self.$alert.html(xhr.responseText).fadeIn('fast');
                }
            });
        }
    });
});
