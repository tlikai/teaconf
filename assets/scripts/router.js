define([
    'jquery',
    'underscore',
    'backbone',
    'routers/site',
    'routers/user',
    'routers/topic'
], function($, _, Backbone, SiteRouter, UserRouter, TopicRouter){
    return {
        start: function() {
            var siteRouter = new SiteRouter();
            var userRouter = new UserRouter();
            var topicRouter = new TopicRouter();
            Backbone.history.start({pushState: true, root: URL_ROOT});

            $(document).on("click", "a[href]:not([data-bypass])", function(evt) {
                var href = { prop: $(this).prop("href"), attr: $(this).attr("href") };
                if(href.attr.substring(0, 4) == 'http') {
                    return true;
                }
                var root = location.protocol + "//" + location.host + URL_ROOT;
                if (href.prop.slice(0, root.length) === root) {
                    evt.preventDefault();
                    Backbone.history.navigate(href.attr, true);
                }
            });
        }
    };
});
