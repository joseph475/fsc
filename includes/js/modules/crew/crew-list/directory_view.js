var DirectoryView=Backbone.View.extend({el:$("#options-list-view"),_href:$(".report-print").attr("href"),_href2:$(".report-print2").attr("href"),initialize:function(){$(".sortcolumn").css("cursor","pointer");if(this.options.status_id==undefined){}this.collection.isLoading=false;this.collection.status_id=1;this.collection.on("add",this.renderOptions,this);this.collection.on("reset",this.render,this);this.collection.on("fetch",function(){this.collection.isLoading=true;$("#loader-container").html('<img src="'+BASE_URL+'includes/img/ajax-loader.gif" />')},this);$("#vessel_details").hide();$(".report-print").hide();this.showStatus()},events:{"shown a[data-toggle='tab']":"toggleSearch","change #vessel_id":"toggleSearch","click .sortcolumn":"updateSortBy","click #loadmore-options":"loadMore"},loadMore:function(a){this.collection.requestNextPage()},toggleSearch:function(a){$("#options-table-1 tbody").empty();this.collection.currentPage=1;this.collection.vessel_id=$("#vessel_id").val();this.collection.pager();$(".report-print").attr("href",this._href+"/"+$("#vessel_id").val());$(".report-print2").attr("href",this._href2+"/"+$("#vessel_id").val())},updateSortBy:function(a){if(this.collection.sortDir=="desc"){dir="asc"}else{dir="desc"}this.collection.sortDir=String(dir);this.collection.updateOrder($(a.target).attr("col"))},showStatus:function(b){window.location.hash="/status/1";var a=this.collection;a.vessel_id=$("#vessel_id").val();a.status_id=1;a.currentPage=0},render:function(){var a=this;$("#loader-container").empty();this.collection.isLoading=false;if($("#load-more-container").is(":hidden")){$("#options-table-1 tbody").empty()}this.collection.each(this.renderOptions,this);$('[rel="clickover"]').clickover({placement:get_popover_placement,html:true})},renderOptions:function(b){var a=new OptionsView({model:b});$("#vessel_details").hide();$(".report-print").hide();if(this.collection.size()!=0){$("#vessel_details").show();$(".report-print").show();$("#v_id").text(b.toJSON().vessel_id);$("#vessel").text(b.toJSON().vessel_name);$("#flag").text(b.toJSON().flag);$("#type").text(b.toJSON().vessel_type);$("#flag_lic_nos").text(b.toJSON().flag+" License/Booklet No.");$("#flag_lic_exp").text(b.toJSON().flag+" License/Booklet Expiry");$("#flag_gmdss_nos").text(b.toJSON().flag+" GMDSS No.");$("#flag_gmdss_exp").text(b.toJSON().flag+" GMDSS Expiry");if(b.toJSON().booklet_license=="N/A"){$("#f1").hide()}else{$("#f1").show()}if(b.toJSON().booklet_license_expiry=="N/A"){$("#f2").hide()}else{$("#f2").show()}if(b.toJSON().gmdss_nos=="N/A"){$("#f3").hide()}else{$("#f3").show()}if(b.toJSON().gmdss_expiry=="N/A"){$("#f4").hide()}else{$("#f4").show()}}$("#options-table-1 tbody").append(a.render().el)}});var AlertView=Backbone.View.extend({el:$("#alert-div"),template:$("#alertTemplate").html(),render:function(){var a=_.template(this.template);var b=Array;b.type=this.options.type;b.message=this.options.message;this.$el.html(a(b));return this}});