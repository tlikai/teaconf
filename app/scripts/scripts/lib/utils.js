// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __slice = [].slice;

define(['underscore', 'chaplin'], function(_, Chaplin) {
  'use strict';
  var mediator, utils;
  mediator = Chaplin.mediator;
  utils = Chaplin.utils.beget(Chaplin.utils);
  _(utils).extend({
    camelize: (function() {
      var camelizer, regexp;
      regexp = /[-_]([a-z])/g;
      camelizer = function(match, c) {
        return c.toUpperCase();
      };
      return function(string) {
        return string.replace(regexp, camelizer);
      };
    })(),
    dasherize: function(string) {
      return string.replace(/[A-Z]/g, function(char, index) {
        return (index !== 0 ? '-' : '') + char.toLowerCase();
      });
    },
    sessionStorage: (function() {
      if (window.sessionStorage && sessionStorage.getItem && sessionStorage.setItem && sessionStorage.removeItem) {
        return function(key, value) {
          if (typeof value === 'undefined') {
            value = sessionStorage.getItem(key);
            if ((value != null) && value.toString) {
              return value.toString();
            } else {
              return value;
            }
          } else {
            sessionStorage.setItem(key, value);
            return value;
          }
        };
      } else {
        return function(key, value) {
          if (typeof value === 'undefined') {
            return utils.getCookie(key);
          } else {
            utils.setCookie(key, value);
            return value;
          }
        };
      }
    })(),
    sessionStorageRemove: (function() {
      if (window.sessionStorage && sessionStorage.getItem && sessionStorage.setItem && sessionStorage.removeItem) {
        return function(key) {
          return sessionStorage.removeItem(key);
        };
      } else {
        return function(key) {
          return utils.expireCookie(key);
        };
      }
    })(),
    getCookie: function(key) {
      var pair, pairs, val, _i, _len;
      pairs = document.cookie.split('; ');
      for (_i = 0, _len = pairs.length; _i < _len; _i++) {
        pair = pairs[_i];
        val = pair.split('=');
        if (decodeURIComponent(val[0]) === key) {
          return decodeURIComponent(val[1] || '');
        }
      }
      return null;
    },
    setCookie: function(key, value, options) {
      var expires, getOption, payload;
      if (options == null) {
        options = {};
      }
      payload = "" + (encodeURIComponent(key)) + "=" + (encodeURIComponent(value));
      getOption = function(name) {
        if (options[name]) {
          return "; " + name + "=" + options[name];
        } else {
          return '';
        }
      };
      expires = options.expires ? "; expires=" + (options.expires.toUTCString()) : '';
      return document.cookie = [payload, expires, getOption('path'), getOption('domain'), getOption('secure')].join('');
    },
    expireCookie: function(key) {
      return document.cookie = "" + key + "=nil; expires=" + ((new Date).toGMTString());
    },
    loadLib: function(url, success, error, timeout) {
      var head, onload, script, timeoutHandle;
      if (timeout == null) {
        timeout = 7500;
      }
      head = document.head || document.getElementsByTagName('head')[0] || document.documentElement;
      script = document.createElement('script');
      script.async = 'async';
      script.src = url;
      onload = function(_, aborted) {
        if (aborted == null) {
          aborted = false;
        }
        if (!(aborted || !script.readyState || script.readyState === 'complete')) {
          return;
        }
        clearTimeout(timeoutHandle);
        script.onload = script.onreadystatechange = script.onerror = null;
        if (head && script.parentNode) {
          head.removeChild(script);
        }
        script = void 0;
        if (success && !aborted) {
          return success();
        }
      };
      script.onload = script.onreadystatechange = onload;
      script.onerror = function() {
        onload(null, true);
        if (error) {
          return error();
        }
      };
      timeoutHandle = setTimeout(script.onerror, timeout);
      return head.insertBefore(script, head.firstChild);
    },
    deferMethods: function(options) {
      var deferred, func, host, methods, methodsHash, name, onDeferral, target, _i, _len, _results;
      deferred = options.deferred;
      methods = options.methods;
      host = options.host || deferred;
      target = options.target || host;
      onDeferral = options.onDeferral;
      methodsHash = {};
      if (typeof methods === 'string') {
        methodsHash[methods] = host[methods];
      } else if (methods.length && methods[0]) {
        for (_i = 0, _len = methods.length; _i < _len; _i++) {
          name = methods[_i];
          func = host[name];
          if (typeof func !== 'function') {
            throw new TypeError("utils.deferMethods: method " + name + " notfound on host " + host);
          }
          methodsHash[name] = func;
        }
      } else {
        methodsHash = methods;
      }
      _results = [];
      for (name in methodsHash) {
        if (!__hasProp.call(methodsHash, name)) continue;
        func = methodsHash[name];
        if (typeof func !== 'function') {
          continue;
        }
        _results.push(target[name] = utils.createDeferredFunction(deferred, func, target, onDeferral));
      }
      return _results;
    },
    createDeferredFunction: function(deferred, func, context, onDeferral) {
      if (context == null) {
        context = deferred;
      }
      return function() {
        var args;
        args = arguments;
        if (deferred.state() === 'resolved') {
          return func.apply(context, args);
        } else {
          deferred.done(function() {
            return func.apply(context, args);
          });
          if (typeof onDeferral === 'function') {
            return onDeferral.apply(context);
          }
        }
      };
    },
    accumulator: {
      collectedData: {},
      handles: {},
      handlers: {},
      successHandlers: {},
      errorHandlers: {},
      interval: 2000
    },
    wrapAccumulators: function(obj, methods) {
      var func, name, _i, _len,
        _this = this;
      for (_i = 0, _len = methods.length; _i < _len; _i++) {
        name = methods[_i];
        func = obj[name];
        if (typeof func !== 'function') {
          throw new TypeError("utils.wrapAccumulators: method " + name + " not found");
        }
        obj[name] = utils.createAccumulator(name, obj[name], obj);
      }
      return $(window).unload(function() {
        var handler, _ref, _results;
        _ref = utils.accumulator.handlers;
        _results = [];
        for (name in _ref) {
          handler = _ref[name];
          _results.push(handler({
            async: false
          }));
        }
        return _results;
      });
    },
    createAccumulator: function(name, func, context) {
      var acc, accumulatedError, accumulatedSuccess, cleanup, id;
      if (!(id = func.__uniqueID)) {
        id = func.__uniqueID = name + String(Math.random()).replace('.', '');
      }
      acc = utils.accumulator;
      cleanup = function() {
        delete acc.collectedData[id];
        delete acc.successHandlers[id];
        return delete acc.errorHandlers[id];
      };
      accumulatedSuccess = function() {
        var handler, handlers, _i, _len;
        handlers = acc.successHandlers[id];
        if (handlers) {
          for (_i = 0, _len = handlers.length; _i < _len; _i++) {
            handler = handlers[_i];
            handler.apply(this, arguments);
          }
        }
        return cleanup();
      };
      accumulatedError = function() {
        var handler, handlers, _i, _len;
        handlers = acc.errorHandlers[id];
        if (handlers) {
          for (_i = 0, _len = handlers.length; _i < _len; _i++) {
            handler = handlers[_i];
            handler.apply(this, arguments);
          }
        }
        return cleanup();
      };
      return function() {
        var data, error, handler, rest, success;
        data = arguments[0], success = arguments[1], error = arguments[2], rest = 4 <= arguments.length ? __slice.call(arguments, 3) : [];
        if (data) {
          acc.collectedData[id] = (acc.collectedData[id] || []).concat(data);
        }
        if (success) {
          acc.successHandlers[id] = (acc.successHandlers[id] || []).concat(success);
        }
        if (error) {
          acc.errorHandlers[id] = (acc.errorHandlers[id] || []).concat(error);
        }
        if (acc.handles[id]) {
          return;
        }
        handler = function(options) {
          var args, collectedData;
          if (options == null) {
            options = options;
          }
          if (!(collectedData = acc.collectedData[id])) {
            return;
          }
          args = [collectedData, accumulatedSuccess, accumulatedError].concat(rest);
          func.apply(context, args);
          clearTimeout(acc.handles[id]);
          delete acc.handles[id];
          return delete acc.handlers[id];
        };
        acc.handlers[id] = handler;
        return acc.handles[id] = setTimeout((function() {
          return handler();
        }), acc.interval);
      };
    },
    afterLogin: function() {
      var args, context, eventType, func, loginHandler;
      context = arguments[0], func = arguments[1], eventType = arguments[2], args = 4 <= arguments.length ? __slice.call(arguments, 3) : [];
      if (eventType == null) {
        eventType = 'login';
      }
      if (mediator.user) {
        return func.apply(context, args);
      } else {
        loginHandler = function() {
          mediator.unsubscribe(eventType, loginHandler);
          return func.apply(context, args);
        };
        return mediator.subscribe(eventType, loginHandler);
      }
    },
    deferMethodsUntilLogin: function(obj, methods, eventType) {
      var func, name, _i, _len, _results;
      if (eventType == null) {
        eventType = 'login';
      }
      if (typeof methods === 'string') {
        methods = [methods];
      }
      _results = [];
      for (_i = 0, _len = methods.length; _i < _len; _i++) {
        name = methods[_i];
        func = obj[name];
        if (typeof func !== 'function') {
          throw new TypeError("utils.deferMethodsUntilLogin: method " + name + "not found");
        }
        _results.push(obj[name] = _(utils.afterLogin).bind(null, obj, func, eventType));
      }
      return _results;
    },
    ensureLogin: function() {
      var args, context, e, eventType, func, loginContext;
      context = arguments[0], func = arguments[1], loginContext = arguments[2], eventType = arguments[3], args = 5 <= arguments.length ? __slice.call(arguments, 4) : [];
      if (eventType == null) {
        eventType = 'login';
      }
      utils.afterLogin.apply(utils, [context, func, eventType].concat(__slice.call(args)));
      if (!mediator.user) {
        if ((e = args[0]) && typeof e.preventDefault === 'function') {
          e.preventDefault();
        }
        return mediator.publish('!showLogin', loginContext);
      }
    },
    ensureLoginForMethods: function(obj, methods, loginContext, eventType) {
      var func, name, _i, _len, _results;
      if (eventType == null) {
        eventType = 'login';
      }
      if (typeof methods === 'string') {
        methods = [methods];
      }
      _results = [];
      for (_i = 0, _len = methods.length; _i < _len; _i++) {
        name = methods[_i];
        func = obj[name];
        if (typeof func !== 'function') {
          throw new TypeError("utils.ensureLoginForMethods: method " + name + "not found");
        }
        _results.push(obj[name] = _(utils.ensureLogin).bind(null, obj, func, loginContext, eventType));
      }
      return _results;
    }
  });
  return utils;
});
