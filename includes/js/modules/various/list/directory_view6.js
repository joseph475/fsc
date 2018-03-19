var DirectoryView = Backbone.View.extend({
    el: $("#options-list-view"),  
    _href: $(".report-print").attr("href"),
    _href2: $(".report-print2").attr("href"),
    
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
        
         $('#vessel_details').hide();
        $('.report-print').hide();
        this.showStatus();
    },
    events: {
        "shown a[data-toggle='tab']": "toggleSearch",
        "change #vessel_id" : "toggleSearch",
        //"click #submit-search": "toggleSearch",
        "click .sortcolumn": "updateSortBy",
        "click #loadmore-options": "loadMore",
        "click .record-set"   : "setDocs",        
        "focus .monthPicker": "selectdate",
        "change #asofdate" : "toggleSearch",
    }, 
    setDocs: function (e) {
        e.preventDefault();

        var that = this;        

        $('#setDocs').live('show', function () {
            $(this).find('.btn-success').die().live('click', function () {  

                var d = Array;
                var a = 1;
                $.map($('.inopts select').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                
                    options2 = new Options2();

                    options2.set('id', a);
                    options2.save(d, {
                        success: function (model, response) {
                            this.$el = $('#setDocs');
                            that.toggleSearch();
                        },
                        error: function (model, response) {
                        }
                    });

                    a++;
                });  


            });               
        })
        .modal();


    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    toggleSearch: function (e) 
    {
        //var d = new Date($('#asofdate').val());

        // Clear contents every search because on mobile the content gets appended.
        $('#options-table-1 tbody').empty();
        this.collection.currentPage = 1;        
        this.collection.vessel_id = $('#vessel_id').val();
        //this.collection.date1 = d.getFullYear() + '-' +  ( d.getMonth() + 1 ) + '-' + d.getDate();
        this.collection.pager();
        
        counter = 0;
        $('#vessel_details').hide();
        $('.report-print').hide();
        
        $(".report-print").attr("href", this._href + "/" + $('#vessel_id').val());
        $(".report-print2").attr("href", this._href2 + "/" + $('#vessel_id').val());
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
    selectdate: function() {
        $('.monthPicker').datepicker({
            yearRange: "-80y:y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" 
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

        $('#test span').text(this.collection.totalRecords);
        // if(this.collection.size() == 0){
        //     var collectData = [
        //         { position: 'No Record' },
        //     ];
        //     this.collection = new PaginatedCollection(collectData);
        // }
       
        this.collection.each(this.renderOptions, this);  

        $('[rel="clickover"]').clickover({
            placement: get_popover_placement,
            html: true
        });
    },
    renderOptions: function (item) {
        var optionsView = new OptionsView({
            model: item
        });

        if(this.collection.size() != 0){
            $('#vessel_details').show();
            $('.report-print').show();
            
            $('#e_year').text(item.toJSON().e_year);
            $('#vessel').text(item.toJSON().vessel_name);
            $('#flag').text(item.toJSON().flag);
            $('#type').text(item.toJSON().vessel_type);
            $('#principal').text(item.toJSON().principal);
            $('#gross').text(item.toJSON().gross);
            $('#hps').text(item.toJSON().hp);
            $('#imo').text(item.toJSON().imo_nos);

          

            if(item.toJSON().flag == 'Japan') {
                $('#flag_lic_nos').text(item.toJSON().flag + ' License Nos./ Expiry');
                $('#flag_gmdss_nos').text(item.toJSON().flag + ' Orange Book Nos./ Expiry.');
            } 
            else if(item.toJSON().flag == 'Korea'){
                $('#flag_lic_nos').text('');
                $('#flag_gmdss_nos').text('');
            }
            else {
               $('#flag_lic_nos').text(item.toJSON().flag + ' License Booklet Nos./ Expiry');
                $('#flag_gmdss_nos').text(item.toJSON().flag + ' GMDSS No./ Expiry');
            }


            $('#column1').text(item.toJSON().column1_name);
            $('#column2').text(item.toJSON().column2_name);
            $('#column3').text(item.toJSON().column3_name);

             // if(item.toJSON().column3_name == '0') {
             //        $('#column3').text("-")
             // }else{
             //        $('#column3').text(item.toJSON().column3_name);
             // } 

            if(item.toJSON().booklet_license == 'N/A') {
                $('#f1').hide();  
            } else {
                $('#f1').show(); 
            }

            if(item.toJSON().gmdss_nos == 'N/A') {
                $('#f3').hide();  
            } else {
                $('#f3').show(); 
            }
        }
        
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