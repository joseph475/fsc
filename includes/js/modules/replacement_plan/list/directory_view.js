var DirectoryView=Backbone.View.extend({el:$("#options-list-view"),_href:$(".report-print").attr("href"),initialize:function(){$(".sortcolumn").css("cursor","pointer");if(this.options.status_id==undefined){}this.collection.isLoading=false;this.collection.status_id=1;this.collection.on("add",this.renderOptions,this);this.collection.on("reset",this.render,this);this.collection.on("fetch",function(){this.collection.isLoading=true;$("#loader-container").html('<img src="'+BASE_URL+'includes/img/ajax-loader.gif" />')},this);this.showStatus()},events:{"click .sortcolumn":"updateSortBy","click #submit-search":"toggleSearch","click #loadmore-options":"loadMore","focus .monthPicker":"monthpicker"},loadMore:function(a){this.collection.requestNextPage()},toggleSearch:function(c){c.preventDefault();$("#options-table-1 tbody").empty();this.collection.currentPage=1;$("#crrp").hide();if(!$("#month").val()){alert=new AlertView({type:"error",message:"Please select a Date to filter."});alert.render();$(".report-print").hide()}else{var a=Date.parse($("#month").val());var b=new Date(a.getFullYear(),a.getMonth(),1);this.collection.date1=(b.getMonth()+1)+"-"+b.getFullYear();$(".report-print").show()}this.collection.pager();$(".report-print").attr("href",this._href+"/"+this.collection.date1)},updateSortBy:function(a){if(this.collection.sortDir=="desc"){dir="asc"}else{dir="desc"}this.collection.sortDir=String(dir);this.collection.updateOrder($(a.target).attr("col"))},showStatus:function(b){window.location.hash="/status/1";var a=this.collection;a.status_id=1;a.currentPage=0;a.pager()},render:function(){var a=this;$("#loader-container").empty();this.collection.isLoading=false;if($("#load-more-container").is(":hidden")){$("#options-table-1 tbody").empty()}$(".report-print").show();if(this.collection.size()==0){$(".report-print").hide()}if(!$("#month").val()){$(".report-print").hide()}this.collection.each(this.renderOptions,this)},renderOptions:function(b){var a=new OptionsView({model:b});$("#options-table-1 tbody").append(a.render().el)},monthpicker:function(){$(".monthPicker").datepicker({dateFormat:"MM-yy",changeMonth:true,changeYear:true,showButtonPanel:true,onClose:function(d,b){var c=$("#ui-datepicker-div .ui-datepicker-month :selected").val();var a=$("#ui-datepicker-div .ui-datepicker-year :selected").val();$(this).val($.datepicker.formatDate("MM-yy",new Date(a,c,1)))}});$(".monthPicker").focus(function(){$(".ui-datepicker-calendar").hide();$("#ui-datepicker-div").position({my:"center top",at:"center bottom",of:$(this)})})}});var AlertView=Backbone.View.extend({el:$("#alert-div"),template:$("#alertTemplate").html(),render:function(){var a=_.template(this.template);var b=Array;b.type=this.options.type;b.message=this.options.message;this.$el.html(a(b));return this}});