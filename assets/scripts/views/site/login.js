define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/site/login.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#container'),
        events: {
            'click .submit': function(e){
                e.preventDefault();
                var self = this;
                var $this = $(e.currentTarget);
                var $alert = this.$el.find('.alert');
                var id = this.$('input[name=id]').val();
                var password = this.$('input[name=password]').val();
                $alert.fadeOut('fast');
                $this.attr('disabled', true);
                App.user.login(id, password, function(data, error){
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
            this.$el.html(ctemplate());
            return this;
        },
    });
});
