// Generated by CoffeeScript 1.6.2
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin', 'controllers/base/controller'], function(Chaplin, Controller) {
  'use strict';
  var SiteController, _ref;

  return SiteController = (function(_super) {
    __extends(SiteController, _super);

    function SiteController() {
      _ref = SiteController.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    SiteController.prototype.login = function() {
      var _this = this;

      return require(['views/site/login'], function(SiteLoginView) {
        return _this.view = new SiteLoginView;
      });
    };

    SiteController.prototype.logout = function() {
      return require(['models/user'], function(User) {
        return User.logout({
          success: function(resp) {
            Chaplin.mediator.user = null;
            Chaplin.mediator.publish('!user:refresh');
            return Chaplin.mediator.publish('!router:routeByName', 'index');
          },
          error: function(xhr) {
            return Chaplin.mediator.publish('!router:routeByName', 'index');
          }
        });
      });
    };

    SiteController.prototype.register = function() {
      var _this = this;

      return require(['views/site/register'], function(SiteRegisterView) {
        return _this.view = new SiteRegisterView;
      });
    };

    return SiteController;

  })(Controller);
});