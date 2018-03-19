// --------------------------------------------------------------------
// Relational
var JoinModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/joining'; 
        } else {            
            return BASE_URL + 'api/joining/id/' + this.get('id'); 
        }
    },  
    defaults: {
        counter          : 0,
        crew_id          : 0,
        control_nos      : 0,
        control_nos2     : 0,
        deparment_id	 : 0,
        fullname         : '',
        duration         : '',
        salary_id        : 0,
        position_id		 : 0,
        position 		 : '',
        duration_month   : 0,
        code             : '',
        start_date       : '0000-00-00',
        est_end_date     : '0000-00-00',
        passport_expired : '0000-00-00',
        coc_expired      : '0000-00-00',
        medical_issued   : '0000-00-00',
        sirb             : '0000-00-00',
        remarks          : '',
        hash             : '',
        isembark         : 0
    }
});

var countr = 0;
// --------------------------------------------------------------------
// 

var JoinMasterView = Backbone.View.extend({
    el: $("#joining-info"),  
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        countr = 0;

        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderJoinView, this);  
        //this.collection.on('add', this.renderJoinForm, this);
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-j-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);

        if (this.collection.size() == 0) {
            e_model = new JoinModel({crew_id: '0', fullname: '', deparment_id: 0, position_id: 0, position: '', duration: 0, code: '', est_end_date: '', passport_expired: '0000-00-00', medical_issued: '0000-00-00', coc_expired: '0000-00-00', start_date: '0000-00-00', hash: '', sirb: '0000-00-00', remarks: '' });
            this.collection.push(e_model);
        }

        this.showStatus();
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #join_add-btn"   : "addJoin",
        "focus .ddate": "embdate",
        "focus .defaultdate": "selectdate",
    }, 
    addJoin: function (e) {
        e.preventDefault();  
        var that = this;

        $('#CandidatePagination').empty();

        var crewsItems = new CrewsCollection();
        crewsItems.sched_id = this.collection.sched_id;
        crewsItems.vessel_id = this.collection.vessel_id;
        crewsItems.start_date = this.collection.start_date;
        crewsItems.end_date = this.collection.end_date;

        var crewsmasterView = new CrewsMasterView({collection: crewsItems}); 
        var crewspagination = new CrewsPaginatedView({collection: crewsItems});  

        $('#addJoin').live('show', function () {
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
        $('#loader-j-container').empty();

        countr = 0;
        
        this.collection.isLoading = false;

        if (this.collection.size() != 0){
            $('#options-table-join tbody').empty();
        } 

        counter = 0;
        this.collection.each(this.renderJoinView, this);    
    },
    renderJoinView: function (item) {
        var optionsView = new JoinView({
            model: item,
            collection: this.collection,
        });
        
        $('#options-table-join tbody').append(optionsView.render().el);
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
var JoinView = Backbone.View.extend({
    tagName: "tr",
    template: $("#join-list-item").html(),
    embarkTemplate: _.template($("#option-embark-template").html()),
    editTemplate: _.template($("#option-edit-template").html()),
    events: {
        'change input[type!="radio"], select': 'change',
        "click .join-embark" : "embarkRec",
        "click .edit-embark" : "editEmbark",
        "click .join-delete" : "confirmDelete",
        "click .final-delete" : "FinalDelete"
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

        $('#deleteJoin').live('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {  

                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM  
                        that.remove();
                        that.showStatus(); 
                    }
                });  
                
                var crewsItems = new CrewsCollection();
                crewsItems.sched_id = sched_id;
                crewsItems.vessel_id = vessel_id;
                crewsItems.end_date = end_date;

                var crewsmasterView = new CrewsMasterView({collection: crewsItems}); 
                crewsmasterView.showStatus();
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

        $('#finalDelete').live('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {  

                var id = that.model.get('id');

                that.model.url = BASE_URL + 'api/joining2/id/' + id; 

                that.model.destroy({
                    success: function (model, response) {
                        // Remove this view from the DOM
                        if(response.status == 'failed'){
                            alert = new Alert2View({type: 'error', message: response.message});
                            alert.render();
                        } else {
                            that.remove();
                            that.collection.pager(); 
                        }
                    },
                    error: function (model, response) {
                        alert = new Alert2View({type: 'error', message: response});
                        alert.render();
                    }
                });  

                var crewsItems = new CrewsCollection();
                crewsItems.sched_id = sched_id;
                crewsItems.vessel_id = vessel_id;
                crewsItems.end_date = end_date;

                var crewsmasterView = new CrewsMasterView({collection: crewsItems}); 
                crewsmasterView.showStatus();

                alert = new Alert2View({type: 'success', message: 'Crew embarkation has been canceled.'});
                alert.render();
            });
        })
        .modal();
    },
    editEmbark: function (e) {        
        e.preventDefault();

        this.$el = $('#container-option-edit');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));

        $('#editData').live('show', function () {
            $(this).find('.btn-primary').die().live('click', function () { 

                var d = Array;
                $.map($('.inopt input, .inopt select, .inopt textarea').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });       

                var id = that.model.get('id');
                that.model.url = BASE_URL + 'api/joining2/id/' + id;         
               
                that.model.save(d, {
                    success: function (model, response) {
                        this.$el = $('#editData');
                        this.$el.modal('hide');
                        alert = new Alert2View({type: 'success', message: 'Record Successfully updated.'});
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new Alert2View({type: 'error', message: response});
                        alert.render();
                    }
                });
                that.showStatus();
            });               
        })
        .modal();
    },
    embarkRec: function (e) {        
        e.preventDefault();

        this.$el = $('#container-option-embark');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.embarkTemplate(this.model.toJSON()));

        $('#embarkData').live('show', function () {
            $(this).find('.btn-primary').die().live('click', function () {  

                var d = Array;
                $.map($('.inopt input').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });    

                options = new OnboardModel();    
                options.set('sched_id', that.collection.sched_id);               
                options.save(d, {
                    success: function (model, response) {
                        alert = new Alert2View({type: 'success', message: 'Crew successfully onboard.'});
                        alert.render();
                        that.model.set('onboard_id', response['id']).save();
                        that.showStatus();
                    },
                    error: function (model, response) {
                        alert = new Alert2View({type: 'error', message: response});
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
        //var difference_ms = Math.abs(date1_ms - date2_ms)
        if(date2_ms >= date1_ms) {
            var difference_ms = Math.abs(date2_ms - date1_ms)
        } else {
            var difference_ms = - Math.abs(date2_ms - date1_ms)
        }
        
        // Convert back to days and return
        return Math.round(difference_ms/ONE_DAY)
    },
    render: function () {   
        countr = countr + 1;       
        this.model.set('counter', countr);

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

        // if(this.model.get('isembark') == 1){
        //     this.$el.addClass('isembark');    
        // }   
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
}); 

// --------------------------------------------------------------------
// 

var JoinCollection = Backbone.Paginator.requestPager.extend({
    
    // As usual, let's specify the model to be used
    // with this collection
    model: JoinModel,
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
        url: BASE_URL + 'api/joinings?'
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
var JoinPaginatedView = Backbone.View.extend({
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
            
        this.$el.appendTo('#joinpagination');
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