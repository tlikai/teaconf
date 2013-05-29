// Generated by CoffeeScript 1.6.2
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin', 'controllers/base/controller', 'models/topic', 'models/topics', 'views/topic/list', 'views/topic/show', 'views/topic/create'], function(Chaplin, Controller, Topic, Topics, TopicListView, TopicShowView, TopicCreateView) {
  'use strict';
  var TopicController, _ref;

  return TopicController = (function(_super) {
    __extends(TopicController, _super);

    function TopicController() {
      _ref = TopicController.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    TopicController.prototype.list = function(params) {
      _.defaults(params, {
        tab: 'popular',
        node: null
      });
      if (!Chaplin.mediator.user && params.tab === 'watch') {
        Chaplin.mediator.publish('!router:routeByName', 'login');
      }
      this.collection = new Topics;
      this.view = new TopicListView({
        collection: this.collection
      });
      this.collection.fetch({
        data: params
      });
      return this.view.setActiveTab(params.tab);
    };

    TopicController.prototype.show = function(params) {
      this.model = new Topic({
        id: params.id
      });
      this.view = new TopicShowView({
        model: this.model
      });
      return this.model.fetch();
    };

    TopicController.prototype.create = function() {
      Chaplin.mediator.user || Chaplin.mediator.publish('!router:routeByName', 'login');
      return this.view = new TopicCreateView;
    };

    return TopicController;

  })(Controller);
});