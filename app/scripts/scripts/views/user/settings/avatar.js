// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['views/base/view', 'views/alert', 'text!views/templates/user/settings/avatar.html'], function(View, AlertView, template) {
  'use strict';
  var SettingsAvatarView, _ref;
  return SettingsAvatarView = (function(_super) {
    __extends(SettingsAvatarView, _super);

    function SettingsAvatarView() {
      _ref = SettingsAvatarView.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    SettingsAvatarView.prototype.autoRender = true;

    SettingsAvatarView.prototype.template = template;

    SettingsAvatarView.prototype.events = {
      'submit #profile-form': function(e) {
        var _this = this;
        e.preventDefault();
        return this.model.save(this.$('#profile-form').serializeJSON(), {
          success: function(resp) {
            return _this.alert.success('修改成功');
          },
          error: function(resp, xhr) {
            return _this.alert.error(xhr.responseText);
          }
        });
      }
    };

    SettingsAvatarView.prototype.render = function() {
      SettingsAvatarView.__super__.render.apply(this, arguments);
      return this.alert = new AlertView;
    };

    return SettingsAvatarView;

  })(View);
});
