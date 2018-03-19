// --------------------------------------------------------------------
// 
var User = Backbone.RelationalModel.extend({
    url: function () {
        return BASE_URL + 'api/user';
    },
    idAttribute: 'user_id'    
});
