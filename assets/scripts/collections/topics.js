define([
   'underscore',
   'backbone',
   'models/topic'
], function(_, Backbone, Topic){
    return Backbone.Collection.extend({
        url: API_URL + '/topics',
        model: Topic,
        page: 0,
        node: null,
        filter: 'popular',
        limit: null,
        fetch: function(options){
            options || (options = {});
            options.data || (options.data = {});
            _.extend(options.data, {
                page: this.page,
                limit: this.limit,
                node: this.node,
                filter: this.filter
            });

            return Backbone.Collection.prototype.fetch.call(this, options);
        },
        parse: function(data){
            this.limit = data.limit;
            this.total = data.total;
            this.totalPages = Math.ceil(this.total / this.limit);
            return data.data;
        },
        prevPage: function(){
            if(this.page <= 0)
                return false;
            this.page--;
            this.trigger('change');
        },
        nextPage: function(){
            if(this.page >= this.totalPages)
                return false;
            var self = this;
            this.page++;
            this.trigger('change');
        }
    });
});
