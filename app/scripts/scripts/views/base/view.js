// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin', 'handlebars', 'lib/view-helper'], function(Chaplin, Handlebars) {
  'use strict';
  var View, _ref;
  return View = (function(_super) {
    __extends(View, _super);

    function View() {
      _ref = View.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    View.prototype.initialize = function() {
      View.__super__.initialize.apply(this, arguments);
      if (this.model) {
        this.listenTo(this.model, 'change', this.render);
      }
      if (this.collection) {
        return this.listenTo(this.collection, 'sync', this.render);
      }
    };

    View.prototype.render = function() {
      console.debug('rendered:', this);
      return View.__super__.render.apply(this, arguments);
    };

    View.prototype.getTemplateData = function() {
      var data;
      data = View.__super__.getTemplateData.apply(this, arguments);
      _.extend(data, {
        Chaplin: Chaplin
      });
      return data;
    };

    View.prototype.getTemplateFunction = function() {
      var template, templateFunc;
      template = this.template;
      if (typeof template === 'string') {
        templateFunc = Handlebars.compile(template);
        this.constructor.prototype.template = templateFunc;
      } else {
        templateFunc = template;
      }
      return templateFunc;
    };

    return View;

  })(Chaplin.View);
});
