// Generated by CoffeeScript 1.6.2
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin', 'routers', 'views/layout'], function(Chaplin, routers, Layout) {
  'use strict';
  var Application, _ref;

  return Application = (function(_super) {
    __extends(Application, _super);

    function Application() {
      _ref = Application.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    Application.prototype.initialize = function() {
      Application.__super__.initialize.apply(this, arguments);
      this.initDispatcher({
        controllerSuffix: ''
      });
      this.initRouter(routers, {
        root: '/',
        pushState: true
      });
      this.initComposer();
      this.initLayout();
      this.initMediator();
      this.initComponent();
      this.initUser();
      this.startRouting();
      return typeof Object.freeze === "function" ? Object.freeze(this) : void 0;
    };

    Application.prototype.initLayout = function() {
      Application.__super__.initLayout.apply(this, arguments);
      return this.layout = new Layout(this.title);
    };

    Application.prototype.initMediator = function() {
      Chaplin.mediator.user = null;
      return Chaplin.mediator.seal();
    };

    Application.prototype.initComponent = function() {
      require(['jquery'], function($) {
        return $.ajaxSetup({
          global: true,
          dataType: 'json',
          statusCode: {
            401: function(xhr) {
              return console.debug('401', xhr);
            },
            404: function(xhr) {
              return console.debug('404', xhr);
            }
          }
        });
      });
      return $.fn.extend({
        serializeJSON: function() {
          var data;

          data = {};
          $.each(this.serializeArray(), function(i, item) {
            return data[item.name] = item.value;
          });
          console.debug(data);
          return data;
        }
      });
    };

    Application.prototype.initUser = function() {
      return require(['models/user'], function(User) {
        return User.authenticate();
      });
    };

    return Application;

  })(Chaplin.Application);
});