// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['views/base/view'], function(View, template) {
  'use strict';
  var LoadingView;
  return LoadingView = (function(_super) {
    __extends(LoadingView, _super);

    LoadingView.prototype.autoRender = true;

    LoadingView.prototype.className = 'loading';

    function LoadingView(options) {
      if (options.message != null) {
        this.template = options.message;
      }
      LoadingView.__super__.constructor.apply(this, arguments);
    }

    return LoadingView;

  })(View);
});
