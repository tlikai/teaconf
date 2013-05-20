// Generated by CoffeeScript 1.6.2
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['models/base/model', 'models/posts'], function(Model, Posts) {
  'use strict';
  var Topic, _ref;

  return Topic = (function(_super) {
    __extends(Topic, _super);

    function Topic() {
      _ref = Topic.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    Topic.prototype.urlPath = function() {
      if (this.isNew()) {
        return '/topics';
      } else {
        return '/topic';
      }
    };

    Topic.prototype.like = function(options) {
      var id;

      id = this.get('id');
      _.extend(options, {
        url: "" + API_URL + "/topic/" + id + "/like",
        method: 'POST'
      });
      return $.ajax(options);
    };

    Topic.prototype.watch = function(options) {
      var id;

      id = this.get('id');
      _.extend(options, {
        url: "" + API_URL + "/topic/" + id + "/watch",
        method: 'POST'
      });
      return $.ajax(options);
    };

    Topic.prototype.fetchPosts = function() {
      this.posts = new Posts;
      this.posts.topic = this;
      this.posts.fetch();
      return this.posts;
    };

    return Topic;

  })(Model);
});
