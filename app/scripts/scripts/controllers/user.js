// Generated by CoffeeScript 1.6.2
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin', 'controllers/base/controller', 'models/user', 'views/user/settings'], function(Chaplin, Controller, User, UserSettingsView) {
  'use strict';
  var UserController, _ref;

  return UserController = (function(_super) {
    __extends(UserController, _super);

    function UserController() {
      _ref = UserController.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    UserController.prototype.loginRequire = function() {
      return Chaplin.mediator.user || Chaplin.mediator.publish('!router:routeByName', 'login');
    };

    UserController.prototype.settings = function() {
      this.loginRequire();
      this.model = new User({
        id: Chaplin.mediator.user.id
      });
      this.view = new UserSettingsView({
        model: this.model
      });
      return this.model.fetch();
    };

    return UserController;

  })(Controller);
});