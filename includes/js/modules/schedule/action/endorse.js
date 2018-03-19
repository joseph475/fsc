// --------------------------------------------------------------------
// Relational
var EndorseModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/promotion'; 
        } else {            
            return BASE_URL + 'api/promotion/id/' + this.get('id'); 
        }
    },  
    defaults: {
        crew_id     : 0,
        onboard_id  : 0,
        salary_id   : 0,
        sched_id    : 0,
        duration_month  : 0,
        date_promoted  : '0000-00-00',
        extension_date  : '0000-00-00',
        remarks     : '',
        isembark    : '',
        ischeck     : 0,
        hash		: ''
    }
});

var TypeAheadCollection = Backbone.Collection.extend({model: EndorseModel});

// --------------------------------------------------------------------
// 
var EndorseMasterView = Backbone.View.extend({
    el: $("#endorse-list-view"),  
    
    initialize: function () {  

        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderEndorseView, this); 
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-e-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);
        
        if (this.collection.size() == 0) {
            e_model = new EndorseModel({hash: '', code: '', fullname: '0', onboard_id: '0', salary_id: '0', sched_id: 0, duration_month: '', date_promoted: '', remarks: '' });
            this.collection.push(e_model);
        }

        //this.embdate();
        this.showStatus();
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #submit-search": "toggleSearch",
        "click #loadmore-options": "loadMore",
        "click #endorse-submit"   : "PromoteSubmit",
    },
    PromoteSubmit: function (e) {

        var that = this;

        this.valid = true;

        _.each(this.collection.models, function(model) {
            if (!model.isValid()) {this.valid = false;}
        }, this);

        if (this.valid) {
            var ctr = 0;
            _.each(this.collection.models, function(model) {  
                model.set('sched_id', this.collection.sched_id);
                
                if(model.get('ischeck') == 1) {        
                    $(e.target).text('Saving...').attr('disabled', false);
                    model.save('', '',{                
                        success: function () {
                            countr3 = 0;
                            that.showStatus();

                            var promoteItems = new PromotionCollection();
                            promoteItems.sched_id = that.collection.sched_id;
                            promoteItems.vessel_id = that.collection.vessel_id;
                            promoteItems.end_date = that.collection.end_date;
                            var promotionmasterView = new PromotionMasterView({collection: promoteItems});

                            alert = new Alertpe7View({type: 'success', message: 'Update success.'});
                            alert.render();
                        },
                        error: function (model, response) {
                            alert = new Alertpe7View({type: 'error', message: response});
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
        // Clear contents every search because on mobile the content gets appended.
        $('#options-table-endorse tbody').empty();
        this.collection.currentPage = 1;        
        this.collection.searchVal = $('#esearch').val();
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
        window.location.hash = '/modAuth/?dicen06b7148da=d1c3n';
        var options = this.collection;
        options.currentPage = 0;
        options.pager();
    },
    render: function () {        
         var that = this;
        $('#loader-e-container').empty();
        
        this.collection.isLoading = false;

        // Change pager behavior depending on device
        $('#options-table-endorse tbody').empty();

        if (this.collection.size() != 0){
            $('#options-table-endorse tbody').empty();
        }
       
        this.collection.each(this.renderEndorseView, this);  

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
    renderEndorseView: function (item) {
        var optionsView = new EndorseView({
            model: item,
            collection: this.collection
        });
        $('#options-table-endorse tbody').append(optionsView.render().el);
    }
});

var Alertpe7View = Backbone.View.extend({
    el: $('#alertpe7-div'),    
    template: $('#alertpe7Template').html(),
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
var EndorseView = Backbone.View.extend({
    tagName: "tr",
    template: $("#endorse-list-item").html(),
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
var EndorseCollection = Backbone.Paginator.requestPager.extend({

    // As usual, let's specify the model to be used
    // with this collection
    model: EndorseModel,
    sched_id: 0,
    end_date: '0000-00',
    vessel_id: 0,

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
        url: BASE_URL + 'api/endorses?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 25,
        
        sortField: 'sort_order',
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
        'vessel_id': function() { return this.vessel_id; },
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
var EndorsePaginatedView = Backbone.View.extend({
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
            
        this.$el.appendTo('#endorsepagination');
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