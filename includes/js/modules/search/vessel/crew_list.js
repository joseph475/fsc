// --------------------------------------------------------------------
// Relational

var counter = 0;
var CrewListModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/crew_child'; 
        } else {            
            return BASE_URL + 'api/crew_child/id/' + this.get('id'); 
        }
    },  
    defaults: {
        'crew_id'               : 0,
        'code'                  : '',
        'birthdate'             : '0000-00-00',
        'signedcontract'        : 0,
        'fullname'              : '',
        'seaman_nos'            : '',
        'hash'                  : '',
        'passport'              : '',
        'start_date'            : '',
        'original_date'         : '',
        'embarked'              : '',
        'disembarked'           : '',
        'end_date'              : '',
        'duration'              : '',
        'month_duration'        : '',
        'joining_port'          : '',
        'file_docs'             : ''
    }
});

// --------------------------------------------------------------------
// 

var CrewListMasterView = Backbone.View.extend({
    el: $("#crewlist-info"),  
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderChildView, this); 
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);

        if(this.collection.size() == 0){
            e_model = new CrewListModel({child_name: '', child_birthdate: '', child_address: '', relationship: ''});
            this.collection.push(e_model);

            this.$el.find('.btn-group').hide();
        }

        this.showStatus();
    },
    events: {
        "click .sortcolumn": "updateSortBy"
    },
    updateSortBy: function (e) {                        
        if (this.collection.sortDir == 'desc') {
            dir = 'asc';
        } else {
            dir = 'desc';
        }
        this.collection.sortDir = String(dir);        
        this.collection.updateOrder($(e.target).attr('col'));
    },
    showStatus: function (e) {
        var options = this.collection;
        options.currentPage = 0;
        options.pager();
    },
    render: function () {        
        var that = this;
        
        this.collection.isLoading = false;

        if (this.collection.size() != 0){
            $('#options-table-crewlist tbody').empty();
        }
        
        counter = 0;
        this.collection.each(this.renderChildView, this);   
    },
    renderChildView: function (item) {
        var optionsView = new CrewListView({
            model: item,
            collection: this.collection
        });
        
        $('#options-table-crewlist tbody').append(optionsView.render().el);
    }
});

// --------------------------------------------------------------------
// 
var CrewListView = Backbone.View.extend({
    tagName: "tr",
    template: $("#crew-list-item").html(),
    days_between: function (date1, date2) {
        var date2 = new Date(date2);

        // The number of milliseconds in one day
        var ONE_DAY = 1000 * 60 * 60 * 24

        // Convert both dates to milliseconds
        var date1_ms = date1.getTime()
        var date2_ms = date2.getTime()

        // Calculate the difference in milliseconds
        var difference_ms = Math.abs(date1_ms - date2_ms)
        
        // Convert back to days and return
        return Math.round(difference_ms/ONE_DAY)
    },
    render: function () {
        counter = counter + 1;
        this.model.set('counter', counter);

        var current_date = new Date();

        if (this.days_between(current_date, this.model.get('seaman_expiry')) <= 90) {
            this.model.set('seaman_nos', "<strong class='alert-expire'>" + this.model.get('seaman_nos') + '</strong>');
        }

        if (parseFloat(this.model.get('duration')) > parseFloat(this.model.get('signedcontract'))) {
            this.$el.css({'background-color': '#ffd0d0', 'color' : '#717171'})
        }

        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
}); 

// --------------------------------------------------------------------
// 
var CrewListCollection = Backbone.Paginator.requestPager.extend({

    // As usual, let's specify the model to be used
    // with this collection
    model: CrewListModel,
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
        perPage: 50,
        
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
        // 'isdone': function() {
        //     return 0;
        // },
        'vessel_id': function() {
            if (this.vessel_id == 0) {
                return '';
            } 
            return this.vessel_id;
        },
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

// --------------------------------------------------------------------
// 
var CrewListPaginatedView = Backbone.View.extend({
    events: {
        'click a.servernext': 'nextResultPage',
        'click a.serverprevious': 'previousResultPage',
        'click a.orderUpdate': 'updateSortBy',
        'click a.serverlast': 'gotoLast',
        'click a.page': 'gotoPage',
        'click a.serverfirst': 'gotoFirst',
        'click a.serverpage': 'gotoPage',
        'click .serverhowmany a': 'changeCount'
    },

    tagName: 'aside',

    template: _.template($('#tmpServerPagination').html()),

    initialize: function () {

        this.collection.on('reset', this.render, this);
        this.collection.on('change', this.render, this);
            
        this.$el.appendTo('#crewlistpagination');
    },

    render: function () {
        var html = this.template(this.collection.info());
        this.$el.html(html);
    },

    updateSortBy: function (e) {
        e.preventDefault();
        var currentSort = $('#sortByField').val();
        this.collection.updateOrder(currentSort);
    },

    nextResultPage: function (e) {
        e.preventDefault();
        this.collection.requestNextPage();
    },

    previousResultPage: function (e) {
        e.preventDefault();
        this.collection.requestPreviousPage();
    },

    gotoFirst: function (e) {
        e.preventDefault();
        this.collection.goTo(this.collection.information.firstPage);
    },

    gotoLast: function (e) {
        e.preventDefault();
        this.collection.goTo(this.collection.information.lastPage);
    },

    gotoPage: function (e) {
        e.preventDefault();
        var page = $(e.target).text();
        this.collection.goTo(page);
    },

    changeCount: function (e) {
        e.preventDefault();
        var per = $(e.target).text();
        this.collection.howManyPer(per);
    }

});