// --------------------------------------------------------------------
// Relational
var CrewsModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/joining'; 
        } else {            
            return BASE_URL + 'api/joining/id/' + this.get('id'); 
        }
    },  
    defaults: {
    	hash		: '',
    	fullname	: '',
        vessel_id   : 0,
        salary_id   : 0,
        crew_id     : 0,
        position_id : 0,
        sched_id    : 0,
        duration_year: 0,
        duration_month  : 1,
        remarks     : '',
        isembark    : '',
        ischeck     : 0
    }
});

var TypeAheadCollection = Backbone.Collection.extend({model: CrewsModel});

// --------------------------------------------------------------------
// 
var CrewsMasterView = Backbone.View.extend({
    el: $("#crews-list-view"),  
    
    initialize: function () {  

        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderCrewsView, this); 
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-c-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);
        
        if (this.collection.size() == 0) {
            e_model = new CrewsModel({crew_id: '0', hash: '', position_id: '0', sched_id: 0, code: '', fullname: '', duration_year: '', duration_month: '', remarks: '' });
            this.collection.push(e_model);
        }

        this.showStatus();
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #submit-search": "toggleSearch",
        "click #loadmore-options": "loadMore",
        "click #crews-submit"   : "JoinSubmit",
    },
    JoinSubmit: function (e) 
    {
        var that = this;

        this.valid = true;

        _.each(this.collection.models, function(model) {
            if (!model.isValid()) {this.valid = false;}
        }, this);

        if (this.valid) {
            var ctr = 0;

            _.each(this.collection.models, function(model) {  
                if(model.get('ischeck') == 1) {  
                    model.set('sched_id', this.collection.sched_id);
                    model.set('vessel_id', this.collection.vessel_id);
                    if(this.collection.start_date) {
                        model.set('start_date', this.collection.start_date);      
                    } else {
                        model.set('start_date', $('#inputjoining_date').val());      
                    }
                    
                    $(e.target).text('Saving...').attr('disabled', false);
                    model.save('', '',{                
                        success: function () {
                            countr = 0;
                            that.showStatus();

                            var joinItems = new JoinCollection();
                            joinItems.sched_id      = that.collection.sched_id;
                            joinItems.vessel_id     = that.collection.vessel_id;
                            joinItems.start_date    = that.collection.start_date;
                            joinItems.end_date      = that.collection.end_date;
                            var joinmasterView      = new JoinMasterView({collection: joinItems});

                            alert = new Alert2View({type: 'success', message: 'Crew successfully Added.'});
                            alert.render();
                        },
                        error: function (model, response) {
                            alert = new Alert2View({type: 'error', message: response});
                            alert.render();
                        },
                        wait: true
                    });
                    $(e.target).text('Save');
                }
            }, this);
        }
    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    toggleSearch: function (e) {
    	e.preventDefault();
        // Clear contents every search because on mobile the content gets appended.
        $('#options-table-crews tbody').empty();
        this.collection.currentPage = 1;        
        this.collection.searchVal = $('#search').val();
        this.collection.position_id = $('#position_id').val();
        this.collection.pager();
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
        window.location.hash = '/modAuth/?8106b7148b5da=d1c3n';
        var options = this.collection;
        options.currentPage = 0;
        options.pager();
    },
    render: function () {        
         var that = this;
        $('#loader-c-container').empty();
        
        this.collection.isLoading = false;
        
        $('#options-table-crews tbody').empty();
        this.collection.each(this.renderCrewsView, this);  

        $('#search').typeahead({
            source: function (query, process) {
                queryAttributes = {};
                queryAttributes['searchVal'] = query;
                var list = [];

                $.ajax({
                    url: that.collection.paginator_core.url,
                    data: queryAttributes,
                    dataType: 'json',
                    success: function (response) {
                        typeAheadCollection = new TypeAheadCollection(response.data);
                        return process(typeAheadCollection.pluck('lastname'));
                    }
                });                
            },            
            minLength: 4
        });  

        $('[rel="clickover"]').clickover({
            placement: get_popover_placement,
            html: true
        }); 
    },
    renderCrewsView: function (item) {
        var optionsView = new CrewsView({
            model: item,
            collection: this.collection
        });
        $('#options-table-crews tbody').append(optionsView.render().el);
    }
});

var Alert3View = Backbone.View.extend({
    el: $('#alert3-div'),    
    template: $('#alert3Template').html(),
    render: function () {
        var tmpl = _.template(this.template);
        var p = Array;
        p['type'] = this.options.type;
        p['message'] = this.options.message;
        this.$el.html(tmpl(p));

        return this;
    }
});

// --------------------------------------------------------------------
// 
var CrewsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#crews-list-item").html(),
    events: {
        'change input[type!="radio"], select': 'change'
    },
    change: function (e) {
        change = {};

        if(e.target.type == 'checkbox'){
            if($(e.target).is(':checked')) {
                e.target.value = 1;
            } else {
                e.target.value = 0;
            }
        }
        change[$(e.target).attr('name')] = $(e.target).val();               
        this.model.set(change, {silent:true});      
        //this.model.set(change);
    },
    render: function () {
        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});

// --------------------------------------------------------------------
// 
var CrewsCollection = Backbone.Paginator.requestPager.extend({

    // As usual, let's specify the model to be used
    // with this collection
    model: CrewsModel,
    sched_id: 0,
    start_date: '0000-00',
    end_date: '0000-00',
    vessel_id: 0,
    position_id: 0,

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
        url: BASE_URL + 'api/candidates?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 25,
        
        sortField: 'jd_position.sort_order, fullname',
        sortDir: 'asc',        
        searchField: 'published',
        searchVal: null,        
        // a default number of total pages to query in case the API or 
        // service you are using does not support providing the total 
        // number of pages for us.
        // 10 as a default in case your service doesn't return the total
        totalPages: 10
    },
    
    server_api: {
        //'end_date': function() { return "'" + this.start_date + "' AND '" + this.end_date + "'";  },
        'vessel_id': function() { return this.vessel_id; },
        'position_id': function() { 
        	if (this.position_id == 0) {
                return '';
            }
        	return this.position_id; 
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
var CrewsPaginatedView = Backbone.View.extend({
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
            
        this.$el.appendTo('#CandidatePagination');
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