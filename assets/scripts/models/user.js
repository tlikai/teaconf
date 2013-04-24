define([
    'backbone',
], function(Backbone){
    var User = Backbone.Model.extend({
        defaults: {
            isGuest: true
        },
        urlRoot: function(){
            return this.isNew() ? API_URL + '/users' : API_URL + '/user';
        },
        authenticate: function(callback){
            var self = this;
            $.ajax({
                url: API_URL + '/authenticate',
                type: 'GET',
                async: false,
                success: function(user){
                    self.set(user);
                    self.set('isGuest', false);
                    if(typeof callback !== 'undefined')
                        callback.call(this, self);
                },
                error: function(){
                    self.clear();
                    self.set('isGuest', true);
                }
            });
        },
        login: function(id, password, callback){
            var self = this;
            $.ajax({
                url: API_URL + '/login',
                type: 'POST',
                data: {
                    id: id,
                    password: password
                },
                success: function(data){
                    self.authenticate();
                    callback.call(this, data, false);
                },
                error: function(xhr){
                    callback.call(this, xhr.responseText, xhr.status);
                }
            });
        },
        logout: function(){
            var self = this;
            $.ajax({
                url: API_URL + '/logout',
                type: 'DELETE'
            }).always(function(){
                self.authenticate();
                history.back();
            });
        },
        register: function(callback){
            var self = this;
            $.ajax({
                url: API_URL + '/register',
                type: 'POST',
                data: {
                    name: self.get('name'),
                    password: self.get('password'),
                    email: self.get('email')
                },
                success: function(data){
                    self.authenticate();
                    callback.call(this, data, false);
                },
                error: function(xhr){
                    callback.call(this, xhr.responseText, xhr.status);
                }
            });
        },
        fetchTopics: function(callback){
            $.ajax({
                url: API_URL + '/user/' + this.get('id') + '/topics',
                method: 'GET',
                success: function(data){
                    require([
                        'collections/topics'
                    ], function(Topics){
                        callback.success && callback.success(new Topics(data));
                    });
                },
                error: callback.error || null
            });
        }
    });
    return User;
});
