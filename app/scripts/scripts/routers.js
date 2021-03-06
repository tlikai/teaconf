// Generated by CoffeeScript 1.6.3
define(function() {
  'use strict';
  return function(match) {
    match('login', 'site#login', {
      name: 'login'
    });
    match('logout', 'site#logout', {
      name: 'logout'
    });
    match('register', 'site#register', {
      name: 'register'
    });
    match('resetPassword', 'site#resetPassword', {
      name: 'resetPassword'
    });
    match('user/:id', 'user#home', {
      params: {
        topic: true
      }
    });
    match('user/:id/topics', 'user#home', {
      name: 'user-topics',
      params: {
        topic: true
      }
    });
    match('user/:id/posts', 'user#home', {
      name: 'user-posts',
      params: {
        post: true
      }
    });
    match('user/:id/watch', 'user#home', {
      name: 'user-watch',
      params: {
        watch: true
      }
    });
    match('settings', 'user#settings');
    match('notifications', 'user#notifications', {
      params: {
        unread: true
      }
    });
    match('notifications/all', 'user#notifications', {
      name: 'notifications-all',
      params: {
        unread: false
      }
    });
    match('', 'topic#list', {
      name: 'index'
    });
    match('topic/create', 'topic#create');
    match(':tab', 'topic#list', {
      name: 'list-by-tab',
      constraints: {
        tab: /(popular|latest|watch|suggest)/
      }
    });
    match('topic/:id', 'topic#show');
    match('node', 'node#list');
    match('node/:node', 'topic#list', {
      name: 'list-by-node',
      constraints: {
        node: /\w+/
      }
    });
    match('node/:node/:tab', 'topic#list', {
      name: 'list-by-node-tab',
      constraints: {
        node: /\w+/,
        tab: /(popular|latest|watch|suggest)/
      }
    });
    return match('*action', 'site#404', {
      name: '404'
    });
  };
});
