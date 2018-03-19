// --------------------------------------------------------------------
// 
var DirectoryView = Backbone.View.extend({
    el: $("#options-list-view"),  
    _href: $(".report-print").attr("href"), 
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        if (this.options.status_id == undefined) {
            //this.options.status_id = $('a[data-toggle="tab"]:first').attr('dep');
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

        if (this.collection.size() == 0) {
            e_model = new Options({fullname: '0', vessel_name: '', remarks: '', position: '', dr: '0000-00-00', ds: '0000-00-00', dc: '0000-00-00', sent_thru: '', awb_no: ''});
            this.collection.push(e_model);
        }

        this.showStatus();
        this.filterby();
    },
    events: {
        "change #option" : "filterby",
        "click .sortcolumn": "updateSortBy",
        "click #submit-search": "toggleSearch",
        "click #loadmore-options": "loadMore",
        "click .record-add"   : "addPost",
        "focus .ddate": "selectdate",
        "change #vessel_id" : "crewSearch",
        "focus .ddate2": "embdate",
        "focus .monthPicker": "monthpicker"
    }, 
    crewSearch: function (e) {
        e.preventDefault();

        var that = this;
        var collection = new crewCollection();
        collection.vessel_id = $('#vessel_id').val();
        collection.date1 = $('#datetoday').val();
        var crewmasterView = new crewMasterView({collection: collection});
    }, 
    addPost: function (e) {
        e.preventDefault();

        var that = this;   

        var collection = new crewCollection();
        collection.vessel_id = $('#vessel_id').val();
        collection.date1 = $('#datetoday').val();
        var crewmasterView = new crewMasterView({collection: collection}); 

        $('#addData').live('show', function () {
            $(this).find('.btn-success').die().live('click', function () {  

                var d = Array;
                $.map($('.inopts input, .inopts select, .inopts textarea').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });
                options = new Options();             
               
                options.save(d, {
                    success: function (model, response) {
                        this.$el = $('#addData');
                        this.$el.modal('hide');
                        alert = new AlertView({type: 'success', message: 'New record successfully added.'});
                        alert.render();

        				that.showStatus();
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
        e.preventDefault();

        // Clear contents every search because on mobile the content gets appended.
        $('#options-table-1 tbody').empty();
        this.collection.currentPage = 1;        
        this.collection.searchVal = $('#search').val();

        if($('#option').val() == 0){       
            if(!$('#date1').val() || !$('#date2').val()){
                alert = new AlertView({type: 'error', message: 'Please select a Date to filter.'});
                alert.render();
            } else {
                this.collection.date1 = $('#date1').val();
                this.collection.date2 = $('#date2').val();
            } 
        } else if($('#option').val() == 1){
            if(!$('#month').val()){
                alert = new AlertView({type: 'error', message: 'Please select a Date to filter.'});
                alert.render();
            }else{
                var date = Date.parse($('#month').val());
                var date1 = new Date(date.getFullYear(), date.getMonth(), 1);
                var date2 = new Date(date.getFullYear(), date.getMonth() + 1, 0);

                this.collection.date1 = date1.getFullYear() + '-' + (date1.getMonth()+1) + '-' + date1.getDate();
                this.collection.date2 = date2.getFullYear() + '-' + (date2.getMonth()+1)  + '-' + date2.getDate();
            }
        }

        this.collection.pager();

        $(".report-print").attr("href", this._href + "/"  + $('#option').val() + "/" + this.collection.date1 + "/" + this.collection.date2);
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
        options.status_id = 1;
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

        $(".report-print").show();
        if(this.collection.size() == 0){
            $(".report-print").hide();
        }
       
        this.collection.each(this.renderOptions, this);  
        this.collection.each(this.renderOptionsform, this);  
    },
    selectdate: function() {
        $('.ddate').datepicker({
            yearRange: "-10y:+10y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" 
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

        $('#container-option-add').append(optionsForm.render().el);
    },
    filterby: function (e) {
        if($('#option').val() == 0){
            this.$el.find('.bydate').show(); 
            this.$el.find('.monthPicker').hide(); 
        } else if($('#option').val() == 1){
            this.$el.find('.bydate').hide(); 
            this.$el.find('.monthPicker').show();

            var date = new Date();
            var monthNames = [  "January", "February", "March", "April", "May", "June",
                                "July", "August", "September", "October", "November", "December" ];

            $('.monthPicker').val(monthNames[date.getMonth()] + '-' +  date.getFullYear());

        }
    },
    embdate: function() {

        $( "#date1" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            numberOfMonths: 3,
            onClose: function( selectedDate ) {
                $( "#date2" ).datepicker( "option", "minDate", selectedDate );

            }
        });
        $( "#date2" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            numberOfMonths: 3,
            onClose: function( selectedDate ) {
                $( "#date1" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
    },
    monthpicker: function() {
        $(".monthPicker").datepicker({
            dateFormat: 'MM-yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
             
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('MM-yy', new Date(year, month, 1)));
            }
        });
         
        $(".monthPicker").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
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