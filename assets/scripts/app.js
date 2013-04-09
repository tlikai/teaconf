define([
    'jquery',
    'bootstrap',
    'underscore',
    'backbone',
    'router'
], function($, Bootstrap, _, Backbone, Router){
    return {
        run: function(){
            Router.initialize();
        }
    };
});
