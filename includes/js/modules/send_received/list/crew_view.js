// --------------------------------------------------------------------
// Relational
var crewModel = Backbone.Model.extend({
    defaults: {
        'last_name': '',
        'first_name' : '',
        'fullname' : '',
        'crew_id'	: 0
    }
});

// --------------------------------------------------------------------
// 

var crewMasterView = Backbone.View.extend({
    el: $("#options-list-view"),  
    
    initialize: function () {        

        this.collection.isLoading = false;
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
          
        }, this);

        if(this.collection.size() == 0){
            e_model = new crewModel();
            this.collection.push(e_model);
        }

        this.collection.currentPage = 0;
        this.collection.pager();
    },
    render: function () {        
        var that = this;
        
        this.collection.isLoading = false;

        $('#dicen').empty();
        _.each(this.collection.models, function(model) {	
			var option = $("<option/>", {
                value: model.get("crew_id"),
                text: model.get("code") +  ' - ' + model.get("fullname") 
            }).appendTo($('#dicen'));
		}); 

    }
});

// --------------------------------------------------------------------
// 
var crewCollection = Backbone.Paginator.requestPager.extend({

    // As usual, let's specify the model to be used
    // with this collection
    model: crewModel,
    vessel_id: 0,
    date1: '0000-00-00',

    // We're going to map the parameters supported by
    // your API or backend data service back to attributes
    // that are internally used by Backbone.Paginator. 

    // e.g the NetFlix API refers to it's parameter for 
    // stating how many results to skip ahead by as $skip
    // and it's number of items to return per page as $top

    // We simply map these to the relevant Paginator equivalents

    // Note that you can define support for new custom attributes
    // adding them with any name you want

    paginator_core: {
        // the type of the request (GET by default)
        type: 'GET',
        
        // the type of reply (jsonp by default)
        dataType: 'json',
    
        // the URL (or base URL) for the service
        url: BASE_URL + 'api/search_vessel?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 1000,
        
        sortField: 'position.sort_order, onboard.start_date ',
        sortDir: 'asc',        
        searchField: null,
        searchVal: null,        
        // a default number of total pages to query in case the API or 
        // service you are using does not support providing the total 
        // number of pages for us.
        // 10 as a default in case your service doesn't return the total
        totalPages: 10
    },
    
    server_api: {
        'vessel_id': function() { return this.vessel_id; },
        'end_date': function() {
            if(this.date1 == '0000-00-00'){
                return '';
            }
            return "'" + String(this.date1) + "'"; 
        },
        'limit': function() { return this.perPage;},
        'offset': function() { 
            if (this.currentPage == 0) {
                this.currentPage = 1;
            }

            return (this.currentPage - 1) * this.perPage;
        },
        'sort': function() { return this.sortField; },
        'order': function() { return this.sortDir; },
        'searchField': function () { return this.searchField; },
        'searchVal': function () { return this.searchVal; }
    },

    parse: function (response) {        
        // Be sure to change this based on how your results        
        var tags = response.data;
        //Normally this.totalPages would equal response.d.__count
        //but as this particular NetFlix request only returns a
        //total count of items for the search, we divide.        
        this.totalPages = Math.floor(response._count / this.perPage);
        this.totalRecords = response._count;
        return tags;
    }

});
