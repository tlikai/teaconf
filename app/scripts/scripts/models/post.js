// Generated by CoffeeScript 1.6.2
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['models/base/model'], function(Model) {
  'use strict';
  var Post, _ref;

  return Post = (function(_super) {
    __extends(Post, _super);

    function Post() {
      _ref = Post.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    Post.prototype.urlPath = function() {
      if (this.isNew()) {
        return '/posts';
      } else {
        return '/post';
      }
    };

    Post.prototype.like = function(options) {
      var id;

      id = this.get('id');
      _.extend(options, {
        url: "" + API_URL + "/post/" + id + "/like",
        method: 'POST'
      });
      return $.ajax(options);
    };

    Post.prototype.watch = function(options) {
      var id;

      id = this.get('id');
      _.extend(options, {
        url: "" + API_URL + "/post/" + id + "/watch",
        method: 'POST'
      });
      return $.ajax(options);
    };

    return Post;

  })(Model);
});