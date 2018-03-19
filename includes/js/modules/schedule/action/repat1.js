// --------------------------------------------------------------------
// Relational
var RepatModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/repat'; 
        } else {      
            return BASE_URL + 'api/repat/id/' + this.get('id'); 
        }
    },  
    defaults: {
        counter          : 0,
        crew_id          : 0,
        fullname         : '',
        duration         : '',
        joining_date     : '0000-00-00',
        code             : '',
        remarks          : '',
        hash             : '',
        isdisembark      : 0,
        reason           : ''
    }
});

// --------------------------------------------------------------------
// 
var countr2 = 0;

var RepatMasterView = Backbone.View.extend({
    el: $("#repat-info"),  
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderRepatView, this);  
        //this.collection.on('add', this.renderRepatForm, this);
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-r-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);

        if (this.collection.size() == 0) {
            e_model = new RepatModel({fullname: '', duration: '', remarks: '', code: '', position: '', onboard_id: ''});
            this.collection.push(e_model);
        }

        this.showStatus();
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #repat_add-btn"   : "addRepat",
        "focus .defaultdate": "selectdate",
    }, 
    addRepat: function (e) {
        e.preventDefault();    

        var that = this;

        $('#finishedpagination').empty();

        var finishedItems = new FinishedCollection();
        finishedItems.sched_id = this.collection.sched_id;
        finishedItems.vessel_id = this.collection.vessel_id;
        finishedItems.end_date = this.collection.end_date;

        var finishedmasterView = new FinishedMasterView({collection: finishedItems});
        var finishedpagination = new FinishedPaginatedView({collection: finishedItems}); 

        $('#addRepat').live('show', function () {
        }) .modal();
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
    selectdate: function() {
        $('.defaultdate').datepicker({
            yearRange: "-10y:+10y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" 
        });
    },
    render: function () {        
        var that = this;
        
        countr2 = 0;

        $('#loader-r-container').empty();
        
        this.collection.isLoading = false;

        if (this.collection.size() != 0){
            $('#options-table-repat tbody').empty();
        }
       
        this.collection.each(this.renderRepatView, this);    
    },
    renderRepatView: function (item) {
        var optionsView = new RepatView({
            model: item,
            collection: this.collection
        });
        
        $('#options-table-repat tbody').append(optionsView.render().el);
    }
});

var Alert4View = Backbone.View.extend({
    el: $('#alert4-div'),    
    template: $('#alert4Template').html(),
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
var RepatView = Backbone.View.extend({
    tagName: "tr",
    template: $("#repat-list-item").html(),
    disembarkTemplate: _.template($("#option-disembark-template").html()),
    editTemplate: _.template($("#option-edit-repat-template").html()),
    events: {
        'change input[type!="radio"], select': 'change',
        "click .repat-disembark" : "disembarkRec",
        "click .edit-disembark" : "editdisembarkRec",
        "click .repat-delete" : "confirmDelete",
        "click .final-delete2" : "FinalDelete"
    },
    change: function (e) {
        change = {};
        change[$(e.target).attr('name')] = $(e.target).val();               
        this.model.set(change, {silent:true});   
    },
    confirmDelete: function (e) {
        e.preventDefault();
        var that = this;    

        var sched_id = this.collection.sched_id;
        var vessel_id = this.collection.vessel_id; 
        var end_date = this.collection.end_date;

        $('#deleteRepat').live('show', function () {
            $(this).find('#repat-delete').die().live('click', function () {  

                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM  
                        that.remove();
                        that.showStatus(); 
                    }
                });  

                var finishedItems = new FinishedCollection();
                finishedItems.sched_id = sched_id;
                finishedItems.vessel_id = vessel_id;
                finishedItems.end_date = end_date;

                var finishedmasterView = new FinishedMasterView({collection: finishedItems}); 
                finishedmasterView.showStatus();
            });
        })
        .modal();
    },
    FinalDelete: function (e) {
        e.preventDefault();
        var that = this;

        var sched_id = this.collection.sched_id;
        var vessel_id = this.collection.vessel_id; 
        var end_date = this.collection.end_date;

        $('#finalDelete2').live('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {  

                var id = that.model.get('id');

                that.model.url = BASE_URL + 'api/repat2/id/' + id; 

                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM  
                        that.remove();
                        that.showStatus(); 
                    }
                });  

                var finishedItems = new FinishedCollection();
                finishedItems.sched_id = sched_id;
                finishedItems.vessel_id = vessel_id;
                finishedItems.end_date = end_date;

                var finishedmasterView = new FinishedMasterView({collection: finishedItems}); 
                finishedmasterView.showStatus();

                alert = new Alert4View({type: 'success', message: 'Crew repatration has been canceled.'});
                alert.render();
            });
        })
        .modal();
    },
    editdisembarkRec: function (e) {        
        e.preventDefault();

        this.$el = $('#container-option-edit-repat');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));

        $('#editDisembarkData').live('show', function () {
            $(this).find('.btn-primary').die().live('click', function () {  

                var d = Array;
                $.map($('.inopt input, .inopt select, .inopt textarea').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });       

                var id = that.model.get('id');
                that.model.url = BASE_URL + 'api/repat2/id/' + id;         
               
                that.model.save(d, {
                    success: function (model, response) {
                        this.$el = $('#editDisembarkData');
                        this.$el.modal('hide');
                        if(response['status'] == 'failed') {
                            alert = new Alert4View({type: 'error', message: response['message']});
                        } else {
                            alert = new Alert4View({type: 'success', message: 'Record Successfully updated.'});
                        }
                        that.showStatus();
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new Alert4View({type: 'error', message: response});
                        alert.render();
                    }
                });
                that.showStatus();
            });               
        })
        .modal();
    },
    disembarkRec: function (e) {
        e.preventDefault();

        this.$el = $('#container-option-disembark');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.disembarkTemplate(this.model.toJSON()));

        $('#disembarkData').live('show', function () {
            $(this).find('.btn-primary').die().live('click', function () {  

                var d = Array;
                $.map($('.inopt input, .inopt select, .inopt textarea').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });     

                options = new OnboardModel();    
                
                options.set('id', d['onboard_id']);      

                options.save(d, {
                    success: function (model, response) {
                        that.showStatus();
                        if(response['status'] == 'failed') {
                            alert = new Alert4View({type: 'error', message: response['message']});
                        } else {
                            alert = new Alert4View({type: 'success', message: 'Record Successfully updated.'});
                        }
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new Alert4View({type: 'error', message: response});
                        alert.render();
                    },
                });

            }); 
        })
        .modal();
    },
    showStatus: function (e){
        var options = this.collection;
        options.currentPage = 0;
        options.pager();
    },
    render: function () {
        countr2 = countr2 + 1;
        this.model.set('counter', countr2);

        var status = this.model.toJSON().isdisembark;
        var tmpl = _.template(this.template);  

        //if(status == 1){
            //this.$el.addClass('disembark');    
        //} 

        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
}); 

// --------------------------------------------------------------------
// 
var RepatCollection = Backbone.Paginator.requestPager.extend({

    // As usual, let's specify the model to be used
    // with this collection
    model: RepatModel,
    sched_id: 0,
    end_date: '0000-00-00',
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
        url: BASE_URL + 'api/repats?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 10,
        
        sortField: 'jd_position.sort_order',
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
        'sched_id' : function() { return this.sched_id; },
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
var RepatPaginatedView = Backbone.View.extend({
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
            
        this.$el.appendTo('#repatpagination');
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