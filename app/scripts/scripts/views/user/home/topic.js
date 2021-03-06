// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['views/base/collection-view', 'views/user/home/topic-item', 'text!views/templates/user/home/topic.html'], function(CollectionView, TopicItemView, template) {
  'use strict';
  var HomeTopicView, _ref;
  return HomeTopicView = (function(_super) {
    __extends(HomeTopicView, _super);

    function HomeTopicView() {
      _ref = HomeTopicView.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    HomeTopicView.prototype.listSelector = '.topic-item-region';

    HomeTopicView.prototype.fallbackSelector = '.empty-region';

    HomeTopicView.prototype.itemView = TopicItemView;

    HomeTopicView.prototype.template = template;

    return HomeTopicView;

  })(CollectionView);
});
