// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin', 'models/base/model'], function(Chaplin, Model) {
  'use strict';
  var Notification, _ref;
  return Notification = (function(_super) {
    __extends(Notification, _super);

    function Notification() {
      _ref = Notification.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    Notification.prototype.urlPath = function() {
      return '/notification';
    };

    Notification.prototype.read = function(options) {
      var baseUrl, id;
      id = this.get('id');
      baseUrl = this.urlRoot();
      _.extend(options, {
        url: "" + baseUrl + "/read/" + id,
        method: 'POST'
      });
      return $.ajax(options);
    };

    return Notification;

  })(Model);
});