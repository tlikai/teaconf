// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin', 'views/base/page-view', 'views/alert', 'views/node/selector', 'models/topic', 'models/nodes', 'text!views/templates/topic/create.html'], function(Chaplin, PageView, AlertView, NodeSelectorView, Topic, Nodes, template) {
  'use strict';
  var TopicCreateView, _ref;
  return TopicCreateView = (function(_super) {
    __extends(TopicCreateView, _super);

    function TopicCreateView() {
      _ref = TopicCreateView.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    TopicCreateView.prototype.autoRender = true;

    TopicCreateView.prototype.template = template;

    TopicCreateView.prototype.events = {
      'submit #create-form': function(e) {
        var topic,
          _this = this;
        e.preventDefault();
        topic = new Topic;
        return topic.save(this.$('#create-form').serializeJSON(), {
          success: function(resp) {
            return Chaplin.mediator.publish('!router:routeByName', 'topic#show', {
              id: resp.id
            });
          },
          error: function(resp, xhr) {
            return _this.alert.error(xhr.responseText);
          }
        });
      }
    };

    TopicCreateView.prototype.render = function() {
      TopicCreateView.__super__.render.apply(this, arguments);
      this.alert = new AlertView;
      this.nodes = new Nodes;
      this.nodeSelectorView = new NodeSelectorView({
        container: this.$('#selector-placeholder'),
        collection: this.nodes
      });
      this.subview('nodeSelectorView', this.nodeSelectorView);
      return this.nodes.fetch();
    };

    return TopicCreateView;

  })(PageView);
});
