// --------------------------------------------------------------------
// Relational
var WorksModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/crew_work'; 
        } else {            
            return BASE_URL + 'api/crew_work/id/' + this.get('id'); 
        }
    },  
    defaults: {
        crew_id : 0,
        company : '',
        vessel  : '',
        rank    : '',
        grt     : '',
        type    : '',
        engine  : '',
        trade   : '',
        embarked : '0000-00-00',
        disembarked : '0000-00-00',
        remarks : ''
    }
});

// --------------------------------------------------------------------
// 
var WorksMasterView = Backbone.View.extend({
    el: $("#works-info"),  
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderWorksView, this);  
        this.collection.on('add', this.renderWorksForm, this);
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);

        if(this.collection.size() == 0){
            e_model = new WorksModel({company: '', vessel: '', rank: '', grt: '', type: '', engine: '', trade: '', embarked: '', disembarked: '', remarks: ''});
            this.collection.push(e_model);

            this.$el.find('.btn-group').hide();
        }

        this.embdate();
        this.showStatus();
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #work_add-btn"   : "addWorkPost",
        "focus .wdate": "embdate"
    }, 
    addWorkPost: function (e) {
        e.preventDefault();

        var that = this;        

        $('#addWork').live('show', function () {
            $(this).find('.btn-success').die().live('click', function () {  

                var d = Array;
                $.map($('.inopts input,.inopts select').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });  

                options = new WorksModel();             
               
                options.save(d, {
                    success: function (model, response) {
                    	if(response.status === 'invalid') {
                    		alert = new Alert4View({type: 'error', message: 'Entry is conflict on existing record. Please check embark and disembark date'});
                		} else {
                			alert = new Alert4View({type: 'success', message: 'New record successfully added.'}); 		
                    	}

                    	alert.render();
                        this.$el = $('#addWork');
                        this.$el.modal('hide');
                        that.showStatus();
                        
                    },
                    error: function (model, response) {
                        alert = new Alert4View({type: 'error', message: response});
                        alert.render();
                    }
                });

            }); 

             $(".wdate").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});          
        })
        .modal();
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
            $('#options-table-works tbody').empty();
        }
       
        this.collection.each(this.renderWorksView, this);  
        this.collection.each(this.renderWorksForm, this);   
    },
    renderWorksView: function (item) {
        var optionsView = new WorksView({
            model: item,
            collection: this.collection
        });
        
        $('#options-table-works tbody').append(optionsView.render().el);
    },    
    renderWorksForm: function (item) {
        var optionsForm = new WorksForm({
            model: item
        });

        $('#container-option-add').append(optionsForm.render().el);
    },
    embdate: function() {
        $('.wdate').datepicker({
            yearRange: "-80y:y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" 
        });
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
var WorksView = Backbone.View.extend({
    tagName: "tr",
    template: $("#works-list-item").html(),
    editTemplate: _.template($("#works-edit-template").html()),
    initialize: function () { 
        this.dembdate();
    },
    events: {
        "click .record-delete" : "confirmDelete",
        "click .record-edit"   : "editPost",
        "focus .wdate": "dembdate"
    },
    editPost: function (e) {        
        e.preventDefault();

        this.$el = $('#container-works-edit');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));

        $('#editWork').live('show', function () { 
            $(this).find('.btn-primary').die().live('click', function () {  

                var d = Array;
                $.map($('input.ab, select.ab').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });                
               
                that.model.save(d, {
                    success: function (model, response) {
                    	if(response.status === 'invalid') {
                    		alert = new Alert4View({type: 'error', message: 'Entry is conflict on existing record. Please check embark and disembark date'});
                		} else {
                			alert = new Alert4View({type: 'success', message: 'Record successfully updated'});		
                    	}

                    	alert.render();
                        this.$el = $('#editWork');
                        this.$el.modal('hide');
                        that.showStatus();
                    },
                    error: function (model, response) {
                        alert = new Alert4View({type: 'error', message: response});
                        alert.render();
                    }
                });

            });   
             $(".wdate").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});             
        })
        .modal();
    },
    confirmDelete: function (e) {
        e.preventDefault();
        var that = this;
        $('#deleteWork').live('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {         
                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM                
                    that.remove();
                    that.showStatus();
                    }
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
        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    },
    dembdate: function() {
        $('.wdate').datepicker({
            yearRange: "-80y:y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" 
        });
    } 
}); 

var WorksForm = Backbone.View.extend({
    template: $('#container-works-add'),
    addTemplate: _.template($("#works-add-template").html()),
    render: function () { 
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this;
    }
});

// --------------------------------------------------------------------
// 
var WorksCollection = Backbone.Paginator.requestPager.extend({

    // As usual, let's specify the model to be used
    // with this collection
    model: WorksModel,
    crew_id: 0,

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
        url: BASE_URL + 'api/crew_works?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 5,
        
        sortField: 'id',
        sortDir: 'desc',        
        searchField: null,
        searchVal: null,        
        // a default number of total pages to query in case the API or 
        // service you are using does not support providing the total 
        // number of pages for us.
        // 10 as a default in case your service doesn't return the total
        totalPages: 10
    },
    
    server_api: {
        'crew_id': function() { return this.crew_id; },
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
var WorksPaginatedView = Backbone.View.extend({
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
            
        this.$el.appendTo('#workpagination');
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