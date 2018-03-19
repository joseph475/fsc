// --------------------------------------------------------------------
// Relational
var BankModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/crew_bank'; 
        } else {            
            return BASE_URL + 'api/crew_bank/id/' + this.get('id'); 
        }
    },  
    defaults: {
        'crew_id'        : 0,
        'amount'         : '',
        'date_issued'    : '0000-00-00',
        'type'           : '',
        'type_nos'       : '',
        'remarks'        : ''
    }
});

// --------------------------------------------------------------------
// 

var BankMasterView = Backbone.View.extend({
    el: $("#bank-info"),  
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderBankView, this);  
        this.collection.on('add', this.renderBankForm, this);
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);

        if(this.collection.size() == 0){
            e_model = new BankModel({amount: '', date_issued: '', type: '', type_nos: '', remarks: ''});
            this.collection.push(e_model);

            this.$el.find('.btn-group').hide();
        }

        this.showStatus();
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #bank_add-btn"   : "addbank",
        "focus .jrdate": "selectdate"
    }, 
    addbank: function (e) {
        e.preventDefault();

        var that = this;        

        $('#addbank').live('show', function () {
            $(this).find('.btn-success').die().live('click', function () {  

                var d = Array;
                $.map($('.inbanks input, .inbanks select, .inbanks textarea').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });  

                options = new BankModel();             
               
                options.save(d, {
                    success: function (model, response) {
                        this.$el = $('#addbank');
                        this.$el.modal('hide');
                        that.showStatus();
                        alert = new AlertBanksView({type: 'success', message: 'New record successfully added.'});
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new AlertBanksView({type: 'error', message: response});
                        alert.render();
                    }
                });

            });               
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
    selectdate: function() {
        $('.jrdate').datepicker({
            yearRange: "-80y:y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" 
        });
    },
    render: function () {        
        var that = this;
        
        this.collection.isLoading = false;

        if (this.collection.size() != 0){
            $('#options-table-bank tbody').empty();
        }

        this.collection.each(this.renderBankView, this);  
        this.collection.each(this.renderBankForm, this);   
    },
    renderBankView: function (item) {
        var optionsView = new BankView({
            model: item,
            collection: this.collection
        });
        
        $('#options-table-bank tbody').append(optionsView.render().el);
    },    
    renderBankForm: function (item) {
        var optionsForm = new BankForm({
            model: item
        });

        $('#container-bank-add').append(optionsForm.render().el);
    }
});

var AlertBanksView = Backbone.View.extend({
    el: $('#alertBanks-div'),    
    template: $('#alertBanksTemplate').html(),
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
var BankView = Backbone.View.extend({
    tagName: "tr",
    template: $("#bank-list-item").html(),
    editTemplate: _.template($("#option-edit-bank").html()),
    events: {
        "click .record-delete" : "confirmDelete",
        "click .record-edit"   : "editbank"
    },
    editbank: function (e) {        
        e.preventDefault();

        this.$el = $('#container-bank-edit');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));

        $('#editbank').live('show', function () { 
            $(this).find('.btn-primary').die().live('click', function () {  

                var d = Array;
                $.map($('.inbanks input, .inbanks select, .inbanks textarea').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });                
               
                that.model.save(d, {
                    success: function (model, response) {
                        that.showStatus();
                        this.$el = $('#editbank');
                        this.$el.modal('hide');
                        alert = new AlertBanksView({type: 'success', message: 'Record successfully updated'});
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new AlertBanksView({type: 'error', message: response});
                        alert.render();
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
    confirmDelete: function (e) {
        e.preventDefault();
        var that = this;
        $('#deletebank').live('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {         
                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM                
                    that.remove();
                    }
                });   
            });
        })
        .modal();
    },
    render: function () {
        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
}); 

var BankForm = Backbone.View.extend({
    template: $('#container-bank-add'),
    addTemplate: _.template($("#option-add-bank").html()),
    render: function () { 
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this;
    }
});

// --------------------------------------------------------------------
// 
var BankCollection = Backbone.Paginator.requestPager.extend({

    // As usual, let's specify the model to be used
    // with this collection
    model: BankModel,
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
        url: BASE_URL + 'api/crew_banks?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 5,
        
        sortField: 'date_issued',
        sortDir: 'DESC',        
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
var BankPaginatedView = Backbone.View.extend({
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
            
        this.$el.appendTo('#bankpagination');
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