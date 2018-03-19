// --------------------------------------------------------------------
// 
var Signature=Backbone.Model.extend({idAttribute:"user_id",url:function(){return BASE_URL+"api/user/id/"+this.get("user_id")+"/signature"},defaults:{last_name:"",first_name:"",fullname:"",counter:0}});
var DocsMasterView = Backbone.View.extend({
    el: $("#options-list-view"),      
    _href1: $(".report-print1").attr("href"),
    _href2: $(".report-print2").attr("href"),
    _href3: $(".report-print3").attr("href"), 
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderDocsView, this); 
        this.collection.on('add', this.renderOptionsform, this);
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);

        if(this.collection.size() == 0){
            e_model = new DocsModel({document: '', file_docs: '', sort_order: '', sub_order: '', rating_stwd: '', officer_engr: '', officer_deck: '', rating_deck: '', rating_engr: '', date_issued: '', date_expired: '', docs_nos: '', endorsement :''});
            this.collection.push(e_model);
        }

        this.showStatus();
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #submit-search": "toggleSearch",
        "click #loadmore-options": "loadMore",
        "click .record-set"   : "setPost"
    }, 
    setPost: function (e) {
        e.preventDefault();

        var that = this;        

        $('#setData').live('show', function () {
            $(this).find('.btn-success').die().live('click', function () {  

                var d = Array;
                $.map($('.inopts select').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });  

                options = new Signature();             
                
                options.set('user_id', that.collection.user_id);           

                options.save(d, {
                    success: function (model, response) {
                        this.$el = $('#addData');
                        this.$el.modal('hide');
                        // alert = new AlertView({type: 'success', message: 'New record successfully successfully.'});
                        // alert.render();
                    },
                    error: function (model, response) {
                        alert = new AlertView({type: 'error', message: response});
                        alert.render();
                    }
                });

            });               
        })
        .modal();
    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    toggleSearch: function (e) {
        // Clear contents every search because on mobile the content gets appended.
        e.preventDefault();
        $('#options-table-docs tbody').empty();
        this.collection.currentPage = 1;       
        this.collection.searchVal = $('#search').val(); 
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
        var options = this.collection;
        options.currentPage = 0;
        options.pager();
    },
    render: function () {        
        var that = this;
        
        this.collection.isLoading = false;

        if (this.collection.size() != 0){
            $('#options-table-docs tbody').empty();
        }
       
        this.collection.each(this.renderDocsView, this); 
        this.collection.each(this.renderOptionsform, this); 

        $('#search').typeahead({
            source: function (query, process) {
                queryAttributes = {};
                queryAttributes['searchVal'] = query;
                queryAttributes['crew_id']  = that.collection.crew_id;
                var list = [];

                $.ajax({
                    url: that.collection.paginator_core.url,
                    data: queryAttributes,
                    dataType: 'json',
                    success: function (response) {
                        typeAheadCollection = new TypeAheadCollection(response.data);
                        return process(typeAheadCollection.pluck('document'));
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
    renderDocsView: function (item) {
        var optionsView = new DocsView({
            model: item,
            collection: this.collection
        });
        $('#options-table-docs tbody').append(optionsView.render().el);
    },
    renderOptionsform: function (item) {
        var optionsForm = new OptionsForm({
            model: item
        });

        $('#container-option-set').append(optionsForm.render().el);
    } 
});

var OptionsForm = Backbone.View.extend({
    template: $('#container-option-set'),
    addTemplate: _.template($("#option-set-template").html()),
    render: function () { 
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this;
    }
});

// --------------------------------------------------------------------
// Relational
var DocsModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/checklist'; 
        } else {            
            return BASE_URL + 'api/checklist/id/' + this.get('id'); 
        }
    },  
    defaults: {
        'document' : '',
        'officer_deck' : '',
    }
});

var TypeAheadCollection = Backbone.Collection.extend({model: DocsModel});

// --------------------------------------------------------------------
// 
var DocsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#docs-list-item").html(),
    days_between: function (date1, date2) {
        var date2 = new Date(date2);

        // The number of milliseconds in one day
        var ONE_DAY = 1000 * 60 * 60 * 24

        // Convert both dates to milliseconds
        var date1_ms = date1.getTime()
        var date2_ms = date2.getTime()

        // Calculate the difference in milliseconds
        if(date2_ms >= date1_ms) {
            var difference_ms = Math.abs(date2_ms - date1_ms)
        } else {
            var difference_ms = - Math.abs(date2_ms - date1_ms)
        }
        
        // Convert back to days and return
        return Math.round(difference_ms/ONE_DAY)
    },
    render: function () {

        var current_date = new Date();

        var exp = this.model.get('date_expired');
        var iss = this.model.get('date_issued');

        this.model.set('date_issued', (iss === '0000-00-00' || iss === '1970-01-01')? '' : iss);
        this.model.set('date_expired', (exp === '0000-00-00' || exp === '1970-01-01')? '' : exp);

        if (this.days_between(current_date, exp) <= 90) {
            if(exp === '0000-00-00' || exp === '1970-01-01') {

            } else {
                this.model.set('date_expired', "<strong class='alert-expire'>" + exp + '</strong>'); 
            }
            
        }

        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});

// --------------------------------------------------------------------
// 
var DocsCollection = Backbone.Paginator.requestPager.extend({

    // As usual, let's specify the model to be used
    // with this collection
    model: DocsModel,
    crew_id: 0,
    vessel_id: 0,
    user_id: 0,
    type_id: 0,
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
        url: BASE_URL + 'api/checklist_crews?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 100,
        
        sortField: 'sort_order',
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
        'type_id': function() { return this.type_id;},
        'crew_id': function() { return this.crew_id;},
        'published': function() { return 1;},
        'limit': function() { return this.perPage;},
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
var DocsPaginatedView = Backbone.View.extend({
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
            
        this.$el.appendTo('#docspagination');
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