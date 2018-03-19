// --------------------------------------------------------------------
// 
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
        this.collection.on('add', this.renderOptionsform, this);
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);

        if(this.collection.size() == 0){
            e_model = new Options({vessel_id: '', position_id: '', published: '', basic_salary: '', ot_fixed: ''});
            this.collection.push(e_model);

            this.$el.find('.btn-group').hide();
        }


        this.showStatus();
    },
    events: {
        "shown a[data-toggle='tab']": "toggleSearch",
        "change #vessel_id" : "toggleSearch",
        "change #effective_year" : "toggleSearch",
        "click .sortcolumn": "updateSortBy",
        "click #loadmore-options": "loadMore",
        "click .record-add"   : "addPost"
    }, 
    addPost: function (e) {
        e.preventDefault();

        var that = this;        

        $('#addData').live('show', function () {
            $(this).find('.btn-success').die().live('click', function () {  
                var d = Array;
                $.map($('.inopts input, .inopts select, .inopts textarea').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                }); 

                d['vessel_id'] = $('#vessel_id').val(); 

                options = new Options();          
               
                options.save(d, {
                    success: function (model, response) {
                        this.$el = $('#addData');
                        this.$el.modal('hide');
                        alert = new AlertView({type: 'success', message: 'New record successfully added.'});
                        alert.render();
                    },
                    error: function (model, response) {
                        alert = new AlertView({type: 'error', message: response});
                        alert.render();
                    }
                });

            });               
        })
        .modal();
    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    toggleSearch: function (e) {
        // Clear contents every search because on mobile the content gets appended.
        $('#options-table-1 tbody').empty();
        this.collection.currentPage = 1;        
        this.collection.vessel_id = $('#vessel_id').val();
        this.collection.effective_year = $('#effective_year').val();
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
        options.vessel_id = $('#vessel_id').val();
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

        // if(this.collection.size() == 0){
        //     var collectData = [
        //         { position: 'No Record' },
        //     ];
        //     this.collection = new PaginatedCollection(collectData);
        // }
       
        this.collection.each(this.renderOptions, this);  
        this.collection.each(this.renderOptionsform, this);

        $('[rel="clickover"]').clickover({
            placement: get_popover_placement,
            html: true
        });
    },
    renderOptions: function (item) {
        var optionsView = new OptionsView({
            model: item,
            collection: this.collection
        });
        
        $('#options-table-1 tbody').append(optionsView.render().el);
    },
    renderOptionsform: function (item) {
        var optionsForm = new OptionsForm({
            model: item
        });

        $('#container-option-add').append(optionsForm.render().el);
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