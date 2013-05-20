requirejs.config({
    shim: {
        jquery: {
            deps: ['bootstrap']
        },
        underscore: {
            exports: '_'
        },
        backbone: {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        }
    },
    paths: {
        jquery: 'components/jquery/jquery',
        bootstrap: '../../styles/bootstrap/js/bootstrap',
        underscore: 'components/underscore-amd/underscore',
        backbone: 'components/backbone-amd/backbone',
        chaplin: 'components/chaplin/amd/chaplin',
        handlebars: 'components/handlebars.js/dist/handlebars',
        'backbone-pageable': 'components/backbone-pageable/lib/backbone-pageable',

        // requirejs plugins
        text: 'components/requirejs-text/text',
        css: 'components/RequireCSS/css'
    }
});

require([
    'app'
], function(Application){
    app = new Application();
    app.initialize();
});
