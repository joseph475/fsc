var DirectoryView=Backbone.View.extend({el:$("#options-list-view"),initialize:function(){$(".sortcolumn").css("cursor","pointer");if(this.options.status_id==undefined){}this.collection.isLoading=false;this.collection.status_id=1;this.collection.on("add",this.renderOptions,this);this.collection.on("add",this.renderOptionsform,this);this.collection.on("reset",this.render,this);this.collection.on("fetch",function(){this.collection.isLoading=true;$("#loader-container").html('<img src="'+BASE_URL+'includes/img/ajax-loader.gif" />')},this)},events:{"shown a[data-toggle='tab']":"showStatus","click .sortcolumn":"updateSortBy","click #submit-search":"toggleSearch","click #loadmore-options":"loadMore","click .record-add":"addPost"},addPost:function(b){b.preventDefault();var a=this;$("#addData").live("show",function(){$(this).find(".btn-success").die().live("click",function(){var c=Array;$.map($(".inopts input").serializeArray(),function(e,d){c[e.name]=e.value});options=new Options();options.save(c,{success:function(e,d){this.$el=$("#addData");this.$el.modal("hide");alert=new AlertView({type:"success",message:"New record successfully added."});alert.render()},error:function(e,d){alert=new AlertView({type:"error",message:d});alert.render()}})})}).modal()},loadMore:function(a){this.collection.requestNextPage()},toggleSearch:function(a){$("#options-table-1 tbody").empty();this.collection.currentPage=1;this.collection.searchVal=$("#search").val();this.collection.pager()},updateSortBy:function(a){if(this.collection.sortDir=="desc"){dir="asc"}else{dir="desc"}this.collection.sortDir=String(dir);this.collection.updateOrder($(a.target).attr("col"))},showStatus:function(b){window.location.hash="/status/1";var a=this.collection;a.status_id=1;a.currentPage=0;a.pager()},render:function(){var a=this;$("#loader-container").empty();this.collection.isLoading=false;if($("#load-more-container").is(":hidden")){$("#options-table-1 tbody").empty()}this.collection.each(this.renderOptions,this);this.collection.each(this.renderOptionsform,this);$("#search").typeahead({source:function(c,d){queryAttributes={};queryAttributes.searchVal=c;var b=[];$.ajax({url:a.collection.paginator_core.url,data:queryAttributes,dataType:"json",success:function(e){typeAheadCollection=new TypeAheadCollection(e.data);return d(typeAheadCollection.pluck("flag"))}})},minLength:4});$('[rel="clickover"]').clickover({placement:get_popover_placement,html:true})},renderOptions:function(b){var a=new OptionsView({model:b});$("#options-table-1 tbody").append(a.render().el)},renderOptionsform:function(a){var b=new OptionsForm({model:a});$("#container-option-add").append(b.render().el)}});var AlertView=Backbone.View.extend({el:$("#alert-div"),template:$("#alertTemplate").html(),render:function(){var a=_.template(this.template);var b=Array;b.type=this.options.type;b.message=this.options.message;this.$el.html(a(b));return this}});