define([
    'jquery',
    'underscore',
    'backbone',
], function($, _, Backbone){
    return Backbone.Router.extend({
        routes: {
            '*action': 'default'
        },
        default: function(action) {
            console.log('route: Unknow', action);
        }
    });
});
