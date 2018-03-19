// --------------------------------------------------------------------
// Relational
var DocsModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/crew_doc'; 
        } else {            
            return BASE_URL + 'api/crew_doc/id/' + this.get('id'); 
        }
    },  
    defaults: {
        'document'      : '',
        'crew_id'       : 0,
        'docs_nos'      : '',
        'date_issued'   : '',
        'date_expired'  : '',
        'encoding_modified'   : '',
        'uploading_modified'  : '',
        'remarks'       : '',
        'endorsement'   : '',
        'capacity'      : '',
        'published'     : 0,
        'file_docs'     : '',
        'docs_file'     : '',
        'position_id'   : 0
    }
});

var TypeAheadCollection = Backbone.Collection.extend({model: DocsModel});

// --------------------------------------------------------------------
// 
var DocsMasterView = Backbone.View.extend({
    el: $("#documents-info"),  
    
    initialize: function () {  

        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderDocsView, this); 
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);

        if(this.collection.size() == 0){
            e_model = new DocsModel({document: '', published: '', docs_nos: '', date_issued: '', date_expired: '', remarks: '', file_docs: '', docs_file: '', endorsement: '', capacity: ''});
            this.collection.push(e_model);

            this.$el.find('.btn-group').hide();
            //this.$el.find('input[type!="file"], select').hide();
        }
        
        this.showStatus();
    },
    events: {
        "click #doc_save-btn": "saveDocs",
        "click #submit-search": "toggleSearch",
        "click #doc_generate-btn": "generateDocs",
        "focus .ddate": "selectdate",
        "click .sortcolumn": "updateSortBy",
    },
    toggleSearch: function (e) {
        e.preventDefault();
        // Clear contents every search because on mobile the content gets appended.
        $('#options-table-docs tbody').empty();
        this.collection.currentPage = 1;       
        this.collection.searchVal = $('#search').val(); 
        this.collection.pager();
    },
    saveDocs: function(e) {
        e.preventDefault();

        var that = this;
        this.valid = true;       

        _.each(this.collection.models, function(model) {
            if (!model.isValid()) {this.valid = false;}
        }, this);

        if (this.valid) {
            var ctr = 0;
            var success = true;
            _.each(this.collection.models, function(model) {                
                $(e.target).text('Saving...').attr('disabled', false);
                model.save('', '',{                
                    success: function () {
                        success = true;                        
                    },
                    error: function (model, response) {
                        success = false;
                    },
                    wait: true
                    
                });
                $(e.target).text('Save');
            }, this);

            if(success) {
                alert = new Alert2View({type: 'success', message: 'Document successfully updated'});
                alert.render();
            } else {
                alert = new Alert2View({type: 'error', message: response});
                alert.render();
            }

            setTimeout(function () { $(".alert .close").trigger("click")}, 1000);
        }
    },
    generateDocs: function(e) 
    {
        e.preventDefault();

        var that = this;  
        
        var d = Array;

        docu = new DocsModel();

        d['crew_id'] = this.collection.crew_id;

        docu.save(d, {
            success: function (model, response) {
                that.showStatus();
                alert = new Alert2View({type: 'success', message: 'Document successfully modified.'});
                alert.render();
            },
            error: function (model, response) {
                alert = new Alert2View({type: 'error', message: response});
                alert.render();
            }
        });     

        $('#generateData').live('show', function () {

            setTimeout(function() { 
                $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
                $('#generateData').modal('hide');
            }, 2000);
        }).modal();
        
    },
    selectdate: function() {
        $('.ddate').datepicker({
            yearRange: "-60y:+10y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" 
        });
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
        $(".ddate").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"}); 

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
    },
    renderDocsView: function (item) {
        var optionsView = new DocsView({
            model: item,
            collection: this.collection
        });
        $('#options-table-docs tbody').append(optionsView.render().el);
    }
});

var Alert2View = Backbone.View.extend({
    el: $('#alert2-div'),    
    template: $('#alert2Template').html(),
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
var DocsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#docs-list-item").html(),
    events: {
        "click .record-delete" : "confirmDelete",
        'change input[type!="radio"], select': 'change',
        'click .record-upload' : 'test',
    },
    test: function (e) {
        e.preventDefault();

        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear(); 

        var that = this;
         that.showStatus();
        $('#uploadData').live('show', function () {
            $('#file-message').hide();
            $(this).find('.btn-success').die().live('click', function () {           
                $.ajaxFileUpload({
                    url             : BASE_URL + 'upload/upload_files', 
                    secureuri       : false,
                    fileElementId   :'userfile',
                    dataType        : 'json',
                    data            : {
                        //'title'           : $('#title').val()
                    },
                    success  : function (data, status) {
                        var label = 'label-important';
                        var label2 = 'error';
                        if(data.status != 'error') {      
                 
                            that.model.set('uploading_modified', month + '/' + day + '/' + year);
                            that.model.set('docs_file', data.name).save();            
                            label = 'label-success';
                            label2 = 'success';
                             $('#options-table-docs tbody').empty();
                            that.showStatus();
                        } 

                        $('#file-message').show().html('<span class="label ' + label + '">' +  data.msg + '.</span>');
                        
                        this.$el = $('#uploadData');
                        this.$el.modal('hide');
                        
                        alert = new Alert2View({type: label2, message: data.msg });
                        alert.render();
                    }
                });
                return false;
            });
        })
        .modal();
    },
    showStatus: function (e) {
        var options = this.collection;
        options.currentPage = 1;
        options.pager();
    },
    change: function (e) {    
        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear(); 

        change = {};
        if(e.target.type == 'checkbox'){
            if($(e.target).is(':checked')) {
                e.target.value = 1;
            } else {
                e.target.value = 0;
            }
        }
        change[$(e.target).attr('name')] = $(e.target).val();
        change['encoding_modified'] =  month + '/' + day + '/' + year;          
        this.model.set(change, {silent:true});      
        //this.showStatus();
    },
    confirmDelete: function (e) {
        e.preventDefault();
        var that = this;
        $('#deleteDocs').live('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {         
                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM                
                    that.showStatus();
                    }
                });   
            });
        })
        .modal();
    },
    render: function () {
        var current_date = new Date();

        var exp = this.model.get('date_expired');
        var iss = this.model.get('date_issued');

        this.model.set('date_issued', (iss === '0000-00-00' || iss === '1970-01-01')? '' : iss);
        this.model.set('date_expired', (exp === '0000-00-00' || exp === '1970-01-01')? '' : exp);

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
    hashid: 0,
    totalRec: 0,

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
        url: BASE_URL + 'api/crew_docs?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 50,
        
        sortField: 'jd_document.sort_order',
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
        'crew_id': function() { return this.crew_id; },
        'published': function() { return 1; },
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