// --------------------------------------------------------------------
// Relational
var PromotionModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/promotion'; 
        } else {            
            return BASE_URL + 'api/promotion/id/' + this.get('id'); 
        }
    },  
    defaults: {
        counter          : 0,
        new_position     : '',
        new_pos          : '',
        old_pos          : '',
        crew_id          : 0,
        fullname         : '',
        duration         : '',
        ispromoted       : 0,
        code             : '',
        reference        : '',
        salary_id        : 0,
        extension        : 0,
        start_date       : '0000-00-00', 
        end_date         : '0000-00-00', 
        new_end_date     : '0000-00-00', 
        extension_date   : '0000-00-00', 
        duration_month   : 0,
        oid              : 0,
        passport_expired : '0000-00-00',
        coc_expired      : '0000-00-00',
        medical_issued   : '0000-00-00',
        sirb             : '',
        remarks          : '',
        hash             : ''
    }
});

var countr3 = 0;

// --------------------------------------------------------------------
// 

var PromotionMasterView = Backbone.View.extend({
    el: $("#promotion-info"),  
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderPromotionView, this);  
        //this.collection.on('add', this.renderPromotionForm, this);
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-p-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);

        if(this.collection.size() == 0){
            e_model = new PromotionModel({old_pos: '', new_pos : '', duration_month : '0', fullname : '', medical_issued : '0000-00-00', sirb : '0000-00-00', passport_expired : '0000-00-00', coc_expired : '0000-00-00'});
            this.collection.push(e_model);
        }
       
        this.showStatus();
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "focus .ddate": "embdate",
        "click #promotion_add-btn"   : "addPromotion",
        "focus .defaultdate": "selectdate",
    }, 
    addPromotion: function (e) {
        e.preventDefault(); 

        var that = this;  

        $('#endorsepagination').empty();

        var endorseItems = new EndorseCollection();
        endorseItems.sched_id = that.collection.sched_id;
        endorseItems.vessel_id = that.collection.vessel_id;
        endorseItems.end_date = that.collection.end_date;

        var endorsemasterView = new EndorseMasterView({collection: endorseItems});
        var endorsepagination = new EndorsePaginatedView({collection: endorseItems});  

        $('#addPromotion').live('show', function () { 
        }).modal();
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
    embdate: function() {

        $( "#from" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 3,
            onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 3,
            onClose: function( selectedDate ) {
                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });

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

        $('#loader-p-container').empty();
        
        this.collection.isLoading = false;

        if (this.collection.size() != 0){
            $('#options-table-promotion tbody').empty();
        }
       
        countr3 = 0;
        this.collection.each(this.renderPromotionView, this);  
        //this.collection.each(this.renderPromotionForm, this);   
    },
    renderPromotionView: function (item) {
        var optionsView = new PromotionView({
            model: item,
            collection: this.collection
        });
        
        $('#options-table-promotion tbody').append(optionsView.render().el);
    }
});

// --------------------------------------------------------------------
// 
var PromotionView = Backbone.View.extend({
    tagName: "tr",
    template: $("#promotion-list-item").html(),
    embarkTemplate: _.template($("#option-promote-template").html()),
    editPromoteTemplate: _.template($("#edit-promote-template").html()),
    events: {
        'change input[type!="radio"], select': 'change',
        "click .promote-embark" : "promoteRec",
        "click .promotion-delete" : "confirmDelete",
        "click .edit-promote" : "editPromote",
        "click .final-delete3" : "FinalDelete"
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

        $('#deletePromotion').live('show', function () {
            $(this).find('#promotion-delete').die().live('click', function () {  

                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM  
                        that.remove();
                        that.showStatus(); 
                    }
                });  

                var endorseItems = new EndorseCollection();
                endorseItems.sched_id = that.collection.sched_id;
                endorseItems.vessel_id = that.collection.vessel_id;
                endorseItems.end_date = that.collection.end_date;

                var endorsemasterView = new EndorseMasterView({collection: endorseItems}); 
                endorsemasterView.showStatus();
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

        $('#finalDelete3').live('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {  

                var id = that.model.get('id');

                that.model.url = BASE_URL + 'api/promotion2/id/' + id; 

                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM  
                        that.remove();
                        that.showStatus(); 
                    }
                });  

                var endorseItems = new EndorseCollection();
                endorseItems.sched_id = that.collection.sched_id;
                endorseItems.vessel_id = that.collection.vessel_id;
                endorseItems.end_date = that.collection.end_date;

                var endorsemasterView = new EndorseMasterView({collection: endorseItems}); 
                endorsemasterView.showStatus();

                 alert = new Alert2View({type: 'success', message: 'Crew embarkation has been canceled.'});
                alert.render();
            });
        })
        .modal();
    },
    editPromote: function (e) {        
        e.preventDefault();

        this.$el = $('#container-option-editPromote');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.editPromoteTemplate(this.model.toJSON()));

        $('#editPromote').live('show', function () {
            $(this).find('.btn-primary').die().live('click', function () { 

                var d = Array;
                $.map($('.inopt input, .inopt select').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });       

                var id = that.model.get('id');
                that.model.url = BASE_URL + 'api/promotion2/id/' + id;         
               
                that.model.save(d, {
                    success: function (model, response) {
                        this.$el = $('#editPromote');
                        this.$el.modal('hide');
                        alert = new Alertpe7View({type: 'success', message: 'Record Successfully updated.'});
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new Alertpe7View({type: 'error', message: response});
                        alert.render();
                    }
                });
                that.showStatus();
            });               
        })
        .modal();
    },
    promoteRec: function (e) {        
        e.preventDefault();

        this.$el = $('#container-option-promote');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.embarkTemplate(this.model.toJSON()));

        $('#promoteData').live('show', function () {
            $(this).find('.btn-primary').die().live('click', function () {  

                var d = Array;
                $.map($('.inopt input').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });       

                options = new OnboardPromoteModel();         
               
                options.save(d, {
                    success: function () {
                        that.showStatus();
                        alert = new Alertpe7View({type: 'success', message: 'Record successfully updated.'});
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new Alertpe7View({type: 'error', message: response});
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
        countr3 = countr3 + 1;
        this.model.set('counter', countr3);

        var current_date = new Date();

        var arr = ['sirb', 'passport_expiry', 'passport_expired', 'coc_expired'];

        this.model.set('medical_issued', (this.model.get('medical_issued') == '0000-00-00')? '' : this.model.get('medical_issued'));

        for (var i = 0; i < arr.length; i++) {
            var doc = this.model.get(arr[i]);
            this.model.set(arr[i], (doc == '0000-00-00' || doc == null)? '' : doc);
            var doc = this.model.get(arr[i]);
            if (this.days_between(current_date, doc) <= 90) {
                this.model.set(arr[i], "<strong class='alert-expire'>" + doc + '</strong>');
            }
        }
        
        var tmpl = _.template(this.template);       

        // if(this.model.get('ispromoted') == 1){
        //     this.$el.addClass('promoted');    
        // } 

        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
}); 

// --------------------------------------------------------------------
// 
var PromotionCollection = Backbone.Paginator.requestPager.extend({

    // As usual, let's specify the model to be used
    // with this collection
    model: PromotionModel,
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
        url: BASE_URL + 'api/promotions?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 10,
        
        sortField: 'pos2.sort_order',
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
var PromotionPaginatedView = Backbone.View.extend({
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
            
        this.$el.appendTo('#promotionpagination');
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