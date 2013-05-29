// Generated by CoffeeScript 1.6.2
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['views/base/view', 'views/alert', 'text!views/templates/user/settings/password.html'], function(View, AlertView, template) {
  'use strict';
  var SettingsPasswordView, _ref;

  return SettingsPasswordView = (function(_super) {
    __extends(SettingsPasswordView, _super);

    function SettingsPasswordView() {
      _ref = SettingsPasswordView.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    SettingsPasswordView.prototype.autoRender = true;

    SettingsPasswordView.prototype.template = template;

    SettingsPasswordView.prototype.events = {
      'submit #password-form': function(e) {
        var _this = this;

        e.preventDefault();
        return this.model.changePassword({
          data: this.$('#password-form').serializeJSON(),
          success: function(resp) {
            _this.alert.success('修改成功');
            return setTimeout(function() {
              return _this.render();
            }, 500);
          },
          error: function(xhr) {
            return _this.alert.error(xhr.responseText);
          }
        });
      }
    };

    SettingsPasswordView.prototype.render = function() {
      SettingsPasswordView.__super__.render.apply(this, arguments);
      return this.alert = new AlertView;
    };

    return SettingsPasswordView;

  })(View);
});