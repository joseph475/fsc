// --------------------------------------------------------------------
// 
var DirectoryView = Backbone.View.extend({
    el: $("#options-list-view"),  
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');
   
        
        this.collection.isLoading = false;
        
        this.collection.on('add', this.renderOptions, this);  
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);
    },
    events: {
        "shown a[data-toggle='tab']": "showStatus",
        "click .sortcolumn": "updateSortBy",
        "change #type_id" : "toggleSearch",
        "click #submit-search": "toggleSearch",
        "click #loadmore-options": "loadMore",
        "click .record-save": "saveDocs",
        "click .record-add"   : "addPost"
    }, 
    saveDocs: function(e) {
        var that = this;
        this.valid = true;       

        _.each(this.collection.models, function(model) {
            if (!model.isValid()) {this.valid = false;}
        }, this);

        if (this.valid) {
            var ctr = 0;
            _.each(this.collection.models, function(model) {                
                $(e.target).text('Saving...').attr('disabled', false);
                model.save('', '',{                
                    success: function () {
                        alert = new AlertView({type: 'success', message: 'Update success.'});
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new AlertView({type: 'error', message: response});
                        alert.render();
                    },
                    wait: true
                    
                });
                $(e.target).text('Save');
            }, this);
        }
    },
    addPost: function (e) {
        e.preventDefault();

        var that = this;
        
        options = new Optionloads();   

        options.set('type_id', $('#type_id').val());  
        options.save('', {
            success: function (model, response) {
                alert = new AlertView({type: 'success', message: 'New record successfully added.'});
                alert.render();
            },
            error: function (model, response) {
                alert = new AlertView({type: 'error', message: response});
                alert.render();
            }
        });

        this.showStatus();
    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    toggleSearch: function (e) {
        e.preventDefault();
        // Clear contents every search because on mobile the content gets appended.
        $('#options-table-1 tbody').empty();
        this.collection.currentPage = 1;      
        this.collection.status_id = $('#type_id').val();  
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
        window.location.hash = '/status/1';
        var options = this.collection;
        options.status_id = $('#type_id').val();
        options.currentPage = 0;
        options.pager();
    },
    render: function () {        
        var that = this;
        $('#loader-container').empty();
        
        this.collection.isLoading = false;

        $('#options-table-1 tbody').empty();
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
    renderOptions: function (item) {
        var optionsView = new OptionsView({
            model: item
        });
        
        $('#options-table-1 tbody').append(optionsView.render().el);
    },    
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