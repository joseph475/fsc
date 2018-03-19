// --------------------------------------------------------------------
// Relational
var Optionloads = Backbone.Model.extend({
    idAttribute: 'id',
	url: function () {
        if (this.isNew()) {
            //alert("testing if DELETE request was fire");
             return BASE_URL + 'api/checkload'; 
        } else {
            //alert("another testing if DELETE request was fire" + this.get('id'));
            return BASE_URL + 'api/checkload/id/' + this.get('id'); 
        }
    },  
    defaults: {
        document : '',
    }
});

// --------------------------------------------------------------------
// Relational
var Options = Backbone.Model.extend({
    idAttribute: 'id',
    url: function () {
        if (this.isNew()) {
            //alert("testing if DELETE request was fire");
             return BASE_URL + 'api/checklist'; 
        } else {
            //alert("another testing if DELETE request was fire" + this.get('id'));
            return BASE_URL + 'api/checklist/id/' + this.get('id'); 
        }
    },  
    defaults: {
        document    : '',
        published   : '',
        sort_order  : 0,
        sub_order   : '',
        officer_deck: '',
        officer_engr: '',
        rating_engr : '',
        rating_deck : '',
        rating_stwd : ''


    }
});

var TypeAheadCollection = Backbone.Collection.extend({model: Options});
