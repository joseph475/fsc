// --------------------------------------------------------------------
// Relational
var FlightRepatModel = Backbone.Model.extend({
    idAttribute: 'id',    
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/flight'; 
        } else {            
            return BASE_URL + 'api/flight/id/' + this.get('id'); 
        }
    },  
    defaults: {
        sched_id            : 0, 
        type                : 'repat',
        flight_date         : '0000-00-00', 
        flight_no           : 0, 
        flight_time         : '', 
        origin              : '', 
        destination         : '', 
        remarks             : '',
        orides              : '',
        fd                  : '00-000-00'
    }
});

var AlertRepatView = Backbone.View.extend({
    el: $('#alert-repat-div'),    
    template: $('#alertRepatTemplate').html(),
    render: function () {
        var tmpl = _.template(this.template);
        var p = Array;
        p['type'] = this.options.type;
        p['message'] = this.options.message;
        this.$el.html(tmpl(p));

        return this;
    }
});

var FlightRepatCollection = Backbone.Paginator.requestPager.extend({
    // As usual, let's specify the model to be used
    // with this collection
    model: FlightRepatModel,
    id: 0,
    type: 'repat',

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
        url: BASE_URL + 'api/flights?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 10,
        
        sortField: 'flight_date',
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
        'sched_id' : function() { return this.id; },
        'type' : function() { return 'repat'; },
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

var FlightRepatView = Backbone.View.extend({
    el: $("#repat-info"), 
    initialize: function () {  
        $('.sortcolumn').css('cursor', 'pointer');

        var that = this;    
        this.collection = this.options.collection;
        this.isLoading = false;

        this.collection.on("add", this.renderOptions, this); 
        this.collection.on("add", this.renderOptionsform, this);
        this.collection.bind("reset", this.render, this);
        this.collection.fetch({success: function () {
                that.isLoading = true;                       
            }
        });  

        if (this.collection.size() == 0) {
            e_model = new FlightRepatModel({sched_id: '0', type: '', flight_date: '', flight_no: '', flight_time: '' });
            this.collection.push(e_model);
        }

        this.showStatus();
    },    
    events: {
        "click .sortcolumn"             : "updateSortBy",
        "focus .ddate"                  : "selectdate",
        "click #flight-repat-add-btn"   : "addSchedule",
    }, 
    addSchedule: function (e) {
        e.preventDefault();

        var that = this;        

        $('#addRepatFlight').live('show', function () {
            $(this).find('.btn-success').die().live('click', function () {  

                var d = Array;
                $.map($('.inpt-add-repat input').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });  
                options = new FlightRepatModel();          
               
                options.save(d, {
                    success: function (model, response) {
                        that.showStatus();
                        alert = new AlertRepatView({type: 'success', message: 'Flight schedule successfully added.'});
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new AlertRepatView({type: 'error', message: response});
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
        $('.ddate').datepicker({
            yearRange: "-80y:y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" 
        });
    }, 
    render: function () {
        var that = this;
        this.isLoading = false;

        if (this.collection.size() != 0){
            $('#flight-repat-table tbody').empty();
        }

        this.collection.each(this.renderOptions, this);          
        this.collection.each(this.renderOptionsform, this);    
    }, 
    renderOptions: function (item) {
        var optionsView = new FlightRepatOptionsView({
            model: item,
            collection: this.collection
        });

        $('#flight-repat-table tbody').append(optionsView.render().el);
    },
    renderOptionsform: function (item) {
        var optionsForm = new FlightRepatOptionsForm({
            model: item
        });

        $('#container-flight-repat-add').append(optionsForm.render().el);
    },
});

var FlightRepatOptionsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#flight-repat-list").html(),
    editTemplate: _.template($("#flight-repat-edit-template").html()),
    events: {
        "click .flight-repat-delete" : "confirmDelete",
        "click .flight-repat-edit"  : "EditFlight"
    },
    EditFlight: function (e) {
        e.preventDefault();

        this.$el = $('#container-flight-repat-edit');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));

        $('#editRepatFlight').live('show', function () {
            $(this).find('.btn-primary').die().live('click', function () {  

                var d = Array;
                $.map($('.inpt-edit-repat input').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });                
               
                that.model.save(d, {
                    success: function (model, response) {
                        that.showStatus();
                        this.$el = $('#editRepatFlight');
                        this.$el.modal('hide');
                        alert = new AlertRepatView({type: 'success', message: 'Flight schedule successfully updated.'});
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new AlertRepatView({type: 'error', message: response});
                        alert.render();
                    }
                });

            });               
        })
        .modal();
    },
    confirmDelete: function (e) {
        e.preventDefault();
        var that = this;
        $('#deleteRepatFlight').live('show', function () {
            $(this).find('#flight2-delete').die().live('click', function () {         
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
    showStatus: function (e) {
        var options = this.collection;
        options.currentPage = 0;
        options.pager();
    },
    render: function () {
        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
}); 

var FlightRepatOptionsForm = Backbone.View.extend({
    template: $('#container-flight-repat-add'),
    addTemplate: _.template($("#flight-repat-add-template").html()),
    render: function () { 
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this;
    }
});
