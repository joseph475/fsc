// --------------------------------------------------------------------
// 
var DirectoryView = Backbone.View.extend({
    el: $("#options-list-view"),  
    _href: $(".report-print").attr("href"), 

    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        if (this.options.status_id == undefined) {
            //this.options.status_id = $('#document_id').val();
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
        this.showStatus();
    },
    events: {
        "shown a[data-toggle='tab']": "toggleSearch",
        'click #submit-search' : "result",
        "click .sortcolumn": "updateSortBy",
        "click #loadmore-options": "loadMore",
        "focus .ddate": "selectdate",
        "click .record-set"   : "setPost"
    }, 
    setPost: function (e) {
        e.preventDefault();

        var that = this;        

        $('#setData').live('show', function () {
            $(this).find('.btn-success').die().live('click', function () {  

                var d = Array;
                $.map($('.inopts select').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });  

                options = new Signature();             
                
                options.set('user_id', that.collection.user_id);           

                options.save(d, {
                    success: function (model, response) {
                        this.$el = $('#addData');
                        this.$el.modal('hide');
                        // alert = new AlertView({type: 'success', message: 'New record successfully successfully.'});
                        // alert.render();
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
    result: function(e){
        e.preventDefault();

        var date1 = $('#from').val();
        if(!date1) {
            date1 = '0000-00-00';
        }

         // Clear contents every search because on mobile the content gets appended.
        $('#options-table-1 tbody').empty();
        this.collection.currentPage = 1;   
        this.collection.docs_id = $('#document_id').val();
        this.collection.vessel_id = $('#vessel_id').val();
        this.collection.date1 = $('#from').val();
        this.collection.pager();

        $(".report-print").attr("href", this._href + "/" + $('#document_id').val() + "/" + date1 + "/" + $('#vessel_id').val());
    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    toggleSearch: function (e) {
        // Clear contents every search because on mobile the content gets appended.
        var date1 = $('#from').val();
        if(!date1) {
            date1 = '0000-00-00';
        }

        $('#options-table-1 tbody').empty();
        this.collection.currentPage = 1;        
        this.collection.docs_id = $('#document_id').val();
        this.collection.vessel_id = $('#vessel_id').val();
        this.collection.date1 = date1;
        this.collection.pager();

        $(".report-print").attr("href", this._href + "/" + $('#document_id').val() + "/" + date1 + "/" + $('#vessel_id').val());
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
        options.docs_id = $('#document_id').val();
        options.vessel_id = $('#vessel_id').val();
        options.status_id = 1;
        options.currentPage = 0;
    },
    selectdate: function() {
        $('.ddate').datepicker({
            yearRange: "-10y:+10y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" ,
            dateFormat: 'yy-mm-dd',
        });
    }, 
    render: function () {        
        var that = this;
        $('#loader-container').empty();
        
        this.collection.isLoading = false;

        // Change pager behavior depending on device
        if ($('#load-more-container').is(':hidden')) {
            $('#options-table-1 tbody').empty();
        }       
       
        this.collection.each(this.renderOptions, this);  
        this.collection.each(this.renderOptionsform, this); 

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
    renderOptionsform: function (item) {
        var optionsForm = new OptionsForm({
            model: item
        });

        $('#container-option-set').append(optionsForm.render().el);
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

var OptionsForm = Backbone.View.extend({
    template: $('#container-option-set'),
    addTemplate: _.template($("#option-set-template").html()),
    render: function () { 
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this;
    }
});