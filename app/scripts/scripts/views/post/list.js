// Generated by CoffeeScript 1.6.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin', 'views/base/collection-view', 'views/post/item', 'views/alert', 'views/loading', 'models/post', 'models/posts', 'text!views/templates/post/list.html'], function(Chaplin, CollectionView, PostItemView, AlertView, LoadingView, Post, Posts, template) {
  'use strict';
  var PostListView, _ref;
  return PostListView = (function(_super) {
    __extends(PostListView, _super);

    function PostListView() {
      _ref = PostListView.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    PostListView.prototype.itemView = PostItemView;

    PostListView.prototype.template = template;

    PostListView.prototype.addCollectionListeners = function() {
      PostListView.__super__.addCollectionListeners.apply(this, arguments);
      this.subscribeEvent('before:fetch', function() {
        return this.loadingView = new LoadingView({
          message: '回复加载中...',
          container: $('.post:last').prev()
        });
      });
      return this.subscribeEvent('after:fetch', function() {
        if (this.loadingView != null) {
          this.loadingView.dispose();
        }
        this.loadingView = null;
        return this.loading = false;
      });
    };

    PostListView.prototype.events = {
      'submit #post-form': function(e) {
        var post,
          _this = this;
        e.preventDefault();
        post = new Post;
        return post.save(this.$('#post-form').serializeJSON(), {
          success: function(resp) {
            return _this.collection.add(post);
          },
          error: function(resp, xhr) {
            return _this.alert.error(xhr.responseText);
          }
        });
      }
    };

    PostListView.prototype.render = function() {
      var _this = this;
      PostListView.__super__.render.apply(this, arguments);
      this.alert = new AlertView;
      this.loading = false;
      return $(window).scroll(function() {
        if ($(window).scrollTop() >= $(document).height() - $(window).height() && !_this.loading) {
          _this.loading = true;
          return _this.collection.hasNextPage() && _this.collection.nextPage();
        }
      });
    };

    PostListView.prototype.getTemplateData = function() {
      var data;
      data = PostListView.__super__.getTemplateData.apply(this, arguments);
      _.extend(data, {
        topic: this.model
      });
      return data;
    };

    return PostListView;

  })(CollectionView);
});
