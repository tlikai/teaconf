define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/user/settings/avatar.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        initialize: function(){
            this.listenTo(this.model, 'change', this.render);
        },
        events: {
            'click .choose': 'chooseAvatar'
        },
        render: function(){
            console.log('render: user/settings/avatar');
            var ctemplate = Handlebars.compile(template);
            var data = {
                user: this.model.toJSON(),
            };
            this.$el.html(ctemplate(data));
        },

        // 选择头像
        chooseAvatar: function(e){
            var self = this;
            var $file = this.$('#avatar');
            var $alert = this.$('.alert');
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
        }
    });
});
