// --------------------------------------------------------------------
// 
var DirectoryView = Backbone.View.extend({
    el: $("#options-list-view"),  
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        if (this.options.status_id == undefined) {
            //this.options.status_id = $('a[data-toggle="tab"]:first').attr('dep');
        }       
        
        this.collection.isLoading = false;
        
        this.collection.status_id = 1;
        this.collection.on('add', this.renderOptions, this);  
        this.collection.on('add', this.renderOptionsform, this);
        this.collection.on('add', this.renderGenerateform, this);
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);

        this.showStatus();
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "change #vessel_id" : "toggleSearch",
        "click #submit-search": "toggleSearch",
        "click #loadmore-options": "loadMore",
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
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    toggleSearch: function (e) {
        // Clear contents every search because on mobile the content gets appended.
        e.preventDefault();
        $('#options-table-1 tbody').empty();
        this.collection.currentPage = 1;        
        this.collection.vessel_id = $('#vessel_id').val();
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
        options.vessel_id = $('#vessel_id').val();
        options.currentPage = 0;
        options.pager();
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
    },     
    renderOptionsform: function (item) {
        var optionsForm = new OptionsForm({
            model: item
        });

        $('#container-option-set').append(optionsForm.render().el);
    } 
});

var OptionsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#emp-list-item").html(),
    editTemplate: _.template($("#generate-add-template").html()),
    events: {
    	"click .btn-generate" : "generateReport"
    },
    generateReport: function (e) {
    	e.preventDefault();
    	
    	this.$el = $('#container-generate-add');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));

    	$('#addGenerate').live('show', function () {

    		$('#g_vessel_id').val(that.model.get('vessel_id'));
    		$('#g_crew_id').val(that.model.get('crew_id'));
    		$('#g_onboard_id').val(that.model.get('onboard_id'));
        })
        .modal();
    },
    render: function () {
        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
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