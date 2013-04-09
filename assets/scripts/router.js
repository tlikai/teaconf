define([
    'app',
    'jquery',
    'underscore',
    'backbone',
    'routers/site',
    'routers/topic'
], function(app, $, _, Backbone, SiteRouter, TopicRouter){
    return {
        initialize: function() {
            var siteRouter = new SiteRouter();
            var topicRouter = new TopicRouter();
            Backbone.history.start({pushState: true, root: URL_ROOT});
            $(document).on("click", "a[href]:not([data-bypass])", function(evt) {
                var href = { prop: $(this).prop("href"), attr: $(this).attr("href") };
                var root = location.protocol + "//" + location.host + URL_ROOT;
                if (href.prop.slice(0, root.length) === root) {
                    evt.preventDefault();
                    Backbone.history.navigate(href.attr, true);
                }
            });
        }
    };
});
