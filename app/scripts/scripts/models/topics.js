// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['models/base/pageable-collection', 'models/topic'], function(PageableCollection, Topic) {
  'use strict';
  var Topics;
  return Topics = (function(_super) {
    __extends(Topics, _super);

    function Topics(options) {
      if ((options != null ? options.user : void 0) != null) {
        this.user = options.user;
      }
      Topics.__super__.constructor.apply(this, arguments);
    }

    Topics.prototype.model = Topic;

    Topics.prototype.urlPath = function() {
      var id;
      if (this.user != null) {
        id = this.user.get('id');
        return this.user.urlPath() + ("/" + id + "/topics");
      } else {
        return '/topics';
      }
    };

    return Topics;

  })(PageableCollection);
});
