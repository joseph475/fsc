// --------------------------------------------------------------------
// Relational
var Options = Backbone.Model.extend({
    idAttribute: 'id',
	url: function () {
        if (this.isNew()) {
            //alert("testing if DELETE request was fire");
            return BASE_URL + 'api/type_sub'; 
        } else {
            //alert("another testing if DELETE request was fire" + this.get('id'));
            return BASE_URL + 'api/type_sub/id/' + this.get('id'); 
        }
    },  
    defaults: {
        code: ''
    }
});

var TypeAheadCollection = Backbone.Collection.extend({model: Options});
