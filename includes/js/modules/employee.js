// --------------------------------------------------------------------
// 
var Employee = Backbone.Model.extend({
    url: function () {
        return BASE_URL + 'api/201/employee';
    }
});

// --------------------------------------------------------------------
// 
var EmployeeView = Backbone.View.extend({
    tagName: "tr",
    className: "employee-container",
    template: $("#emp-list-item").html(),
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});  

// --------------------------------------------------------------------
// 
var DirectoryView = Backbone.View.extend({
    el: $("#employee-list-view"),    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        if (this.options.status_id == undefined) {
            this.options.status_id = $('a[data-toggle="tab"]:first').attr('dep');
        }

        this.collection.isLoading = false;

        this.collection.status_id = this.options.status_id;

        this.collection.on('add', this.renderEmployee, this);        
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);
    },
    events: {
        "shown a[data-toggle='tab']": "showStatus",
        "click .sortcolumn": "updateSortBy",
        "click #submit-search": "toggleSearch",
        "click #loadmore-employee": "loadMore"
    },    
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    toggleSearch: function (e) {
        // Clear contents every search because on mobile the content gets appended.
        $('#employee-table-' + this.collection.status_id + ' tbody').empty();
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
        this.collection.sortDir = dir;        
        this.collection.updateOrder($(e.target).attr('col'));
    },
    showStatus: function (e) {
        window.location.hash = '/status_id-' + $(e.target).attr('dep')
        var employees = this.collection;
        employees.status_id = $(e.target).attr('dep');
        employees.currentPage = 0;
        employees.pager();
    },
    render: function () {        
        var that = this;
        $('#loader-container').empty();
        
        this.collection.isLoading = false;

        // Change pager behavior depending on device
        if ($('#load-more-container').is(':hidden')) {
            $('#employee-table-' + this.collection.status_id + ' tbody').empty();
        }
        
        this.collection.each(this.renderEmployee);                    

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
                        return process(typeAheadCollection.pluck('full_name'));
                    }
                });                
            },            
            minLength: 4
        });  

        this.$el.find('a[rel="popover"]').popover({trigger: 'hover', html: true});
    },
    renderEmployee: function (item) {
        var employeeView = new EmployeeView({
            model: item
        });
        
        $('#employee-table-' + item.get('status_id') + ' tbody').append(employeeView.render().el);       
    }
});

var TypeAheadCollection = Backbone.Collection.extend({model: Employee});

// --------------------------------------------------------------------
// 
var PaginatedCollection = Backbone.Paginator.requestPager.extend({

    // As usual, let's specify the model to be used
    // with this collection
    model: Employee,

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
        url: BASE_URL + 'api/201/employees?'
    },
    
    paginator_ui: {
        // the lowest page index your API allows to be accessed
        firstPage: 1,
    
        // which page should the paginator start from 
        // (also, the actual page the paginator is on)
        currentPage: 1,
        
        // how many items per page should be shown
        perPage: 5,
        
        sortField: 'first_name',
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
        'status_id': function() { return this.status_id; },
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
var PaginatedView = Backbone.View.extend({
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
            
        this.$el.appendTo('#pagination');
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

// --------------------------------------------------------------------
// 
var EmployeeListRouter = Backbone.Router.extend({
    routes: {
        '' : 'defaultList',
        'status_id-:id' : 'loadList'     
    },
    initialize: function () {
    
    },
    defaultList: function () {
        id = $('a[data-toggle="tab"]:first').attr('dep');

        $('li a[dep="' + id + '"]').trigger('shown');
    },
    loadList: function (id) {
        $('li a[dep="' + id + '"]').tab('show');
    }    
});