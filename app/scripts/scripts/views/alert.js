// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['views/base/view'], function(View, template) {
  'use strict';
  var AlertView, _ref;
  return AlertView = (function(_super) {
    __extends(AlertView, _super);

    function AlertView() {
      _ref = AlertView.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    AlertView.prototype.rendered = false;

    AlertView.prototype.container = '.alert-area';

    AlertView.prototype.className = 'alert fade in';

    AlertView.prototype.autoRender = false;

    AlertView.prototype.initialize = function() {
      return this.$el.show();
    };

    AlertView.prototype.show = function(options) {
      var message;
      if (typeof options === 'string') {
        message = options;
        options = {
          message: message
        };
      }
      this.$el.html(options.message);
      if (!this.rendered) {
        this.render();
        this.rendered = true;
      }
      if (options["class"] != null) {
        return this.$el.attr('class', "" + this.className + " " + options["class"]);
      }
    };

    AlertView.prototype.render = function() {
      if (!this.rendered) {
        AlertView.__super__.render.apply(this, arguments);
      }
      return false;
    };

    AlertView.prototype.success = function(message) {
      return this.show({
        message: message,
        "class": 'alert-success'
      });
    };

    AlertView.prototype.error = function(message) {
      return this.show({
        message: message,
        "class": 'alert-error'
      });
    };

    AlertView.prototype.info = function(message) {
      return this.show({
        message: message,
        "class": 'alert-info'
      });
    };

    return AlertView;

  })(View);
});
