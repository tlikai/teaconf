define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'models/user',
    'text!templates/site/register.html'
], function($, _, Backbone, Handlebars, User, template){
    return Backbone.View.extend({
        id: '#registerModal',
        events: {
            'click .submit': function(e){
                e.preventDefault();
                var self = this;
                var $this = $(e.currentTarget);
                var $alert = this.$el.find('.alert');
                App.user.set({
                    name: this.$('input[name=name]').val(),
                    password: this.$('input[name=password]').val(),
                    email: this.$('input[name=email]').val()
                });
                $alert.fadeOut('fast');
                $this.attr('disabled', true);
                App.user.register(function(data, error){
                    if(error) {
                        $alert.html(data).addClass('alert-error').fadeIn('fast');
                        $this.removeAttr('disabled');
                    } else {
                        $alert.hide();
                        self.$('.modal').modal('hide');
                        history.back();
                    }
                });
            }
        },
        render: function(){
            console.log('render: site/login');
            var ctemplate = Handlebars.compile(template);
            var data = {};
            this.$el.append(ctemplate(data));
            $(document.body).append(this.$el);
            var self = this;
            this.$el.find('.modal').modal().on('hidden', function(){
                self.$el.remove();
            });
            return this;
        }
    });
});
