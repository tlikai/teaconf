require.config({
    shim: {
        underscore: {
            exports: '_'
        },
        backbone: {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        bootstrap: {
            deps: ['jquery']
        }
    },
    paths: {
        jquery: 'libs/jquery/jquery-1.9.1.min',
        underscore: 'libs/underscore/underscore-min',
        backbone: 'libs/backbone/backbone-min',
        'backbone-relational': 'libs/backbone-relational/backbone-relational',
        'bootstrap-modal': 'libs/backbone.bootstrap-modal/backbone.bootstrap-modal',
        handlebars: 'libs/handlebars/handlebars',
        bootstrap: 'libs/bootstrap/js/bootstrap.min'
    }
});

require([
    'app'
], function(app){
    window.App = app;
    window.App.run();
});
