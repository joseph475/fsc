var DirectoryView = Backbone.View.extend({
    el: $("#options-list-view"),  
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        if (this.options.status_id == undefined) {
            //this.options.status_id = $('#vessel_id').val();
        }       
        
        this.collection.isLoading = false;
        
        this.collection.status_id = 1;
        this.collection.on('add', this.renderOptions, this);  
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);
        
        this.showStatus();
    },
    events: {
        "shown a[data-toggle='tab']": "toggleSearch",
        "change #position_id" : "toggleSearch",
        "click #submit-search": "toggleSearch",
        "click .sortcolumn": "updateSortBy",
        "click #loadmore-options": "loadMore",  
        "change #asofdate" : "toggleSearch",
    }, 
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    toggleSearch: function (e) 
    {
        e.preventDefault();

        // Clear contents every search because on mobile the content gets appended.
        $('#options-table-1 tbody').empty();
        this.collection.currentPage = 1;        
        this.collection.position_id = $('#position_id').val();
        this.collection.searchVal = $('#search').val();
        //this.collection.date1 = d.getFullYear() + '-' +  ( d.getMonth() + 1 ) + '-' + d.getDate();
        this.collection.pager();
        
        counter = 0;
        // $('#vessel_details').hide();
        // $('.report-print').hide();
        
        // $(".report-print").attr("href", this._href + "/" + $('#position_id').val());
        // $(".report-print2").attr("href", this._href2 + "/" + $('#position_id').val());
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
        window.location.hash = '/status/1';
        var options = this.collection;
        options.position_id = $('#position_id').val();
        options.status_id = 1;
        options.currentPage = 0;
    },
    render: function () {        
        var that = this;
        $('#loader-container').empty();
        
        this.collection.isLoading = false;

        // Change pager behavior depending on device
        if ($('#load-more-container').is(':hidden')) {
            $('#options-table-1 tbody').empty();
        }    

        $('#test span').text(this.collection.totalRecords);
       
        this.collection.each(this.renderOptions, this);  

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
                        return process(typeAheadCollection.pluck('fullname'));
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
    renderOptions: function (item) {
        var optionsView = new OptionsView({
            model: item
        });
        
        $('#options-table-1 tbody').append(optionsView.render().el);
    }
});

var AlertView = Backbone.View.extend({
    el: $('#alert-div'),    
    template: $('#alertTemplate').html(),
    render: function () {
        var tmpl = _.template(this.template);
        var p = Array;
        p['type'] = this.options.type;
        p['message'] = this.options.message;
        this.$el.html(tmpl(p));

        return this;
    }
});