// --------------------------------------------------------------------
// 
var Employee = Backbone.RelationalModel.extend({
	idAttribute: 'employee_id',
    url: function () {
        return BASE_URL + 'api/201/employee';
    }    
});

var TypeAheadCollection = Backbone.Collection.extend({model: Employee});