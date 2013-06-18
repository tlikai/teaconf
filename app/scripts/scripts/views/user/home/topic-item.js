// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['views/base/view', 'text!views/templates/user/home/topic-item.html'], function(View, template) {
  'use strict';
  var TopicItemView, _ref;
  return TopicItemView = (function(_super) {
    __extends(TopicItemView, _super);

    function TopicItemView() {
      _ref = TopicItemView.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    TopicItemView.prototype.tagName = 'tr';

    TopicItemView.prototype.template = template;

    return TopicItemView;

  })(View);
});
