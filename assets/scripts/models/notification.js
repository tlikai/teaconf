define([
    'backbone',
], function(Backbone){
    var model =  Backbone.Model.extend({
        urlRoot: function(){
            return API_URL + '/notifications';
        },
    });

    model.readOne =  function(id, callback){
        $.ajax({
            url: API_URL + '/notification/read/' + id,
            method: 'POST',
            success: callback.success || null,
            error: callback.error || null
        });
    }

    return model;
});
