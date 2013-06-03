// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin', 'models/user', 'views/base/page-view', 'views/alert', 'text!views/templates/site/register.html'], function(Chaplin, User, PageView, AlertView, template) {
  'use strict';
  var SiteRegisterView, _ref;
  return SiteRegisterView = (function(_super) {
    __extends(SiteRegisterView, _super);

    function SiteRegisterView() {
      _ref = SiteRegisterView.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    SiteRegisterView.prototype.autoRender = true;

    SiteRegisterView.prototype.template = template;

    SiteRegisterView.prototype.initialize = function() {
      SiteRegisterView.__super__.initialize.apply(this, arguments);
      if (Chaplin.mediator.user != null) {
        Chaplin.mediator.publish('!router:routeByName', 'index');
      }
      return this.alert = new AlertView;
    };

    SiteRegisterView.prototype.events = {
      'submit #register-form': function(e) {
        var _this = this;
        e.preventDefault();
        return User.register({
          data: this.$('#register-form').serializeJSON(),
          success: function(resp) {
            _this.alert.success('注册成功');
            Chaplin.mediator.user = resp;
            Chaplin.mediator.publish('!user:refresh');
            return setTimeout(function() {
              return Chaplin.mediator.publish('!router:routeByName', 'index');
            }, 500);
          },
          error: function(xhr) {
            return _this.alert.error(xhr.responseText);
          }
        });
      }
    };

    return SiteRegisterView;

  })(PageView);
});
