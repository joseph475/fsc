var Options=Backbone.Model.extend({idAttribute:"label_id",url:function(){if(this.isNew()){return BASE_URL+"api/admin_label"}else{return BASE_URL+"api/admin_label/id/"+this.get("label_id")}},defaults:{label_code:"",label:"",inactive:""}});var TypeAheadCollection=Backbone.Collection.extend({model:Options});var DirectoryView=Backbone.View.extend({el:$("#options-list-view"),initialize:function(){$(".sortcolumn").css("cursor","pointer");if(this.options.status_id==undefined){}this.collection.isLoading=false;this.collection.status_id=1;this.collection.on("add",this.renderOptions,this);this.collection.on("add",this.renderOptionsform,this);this.collection.on("reset",this.render,this);this.collection.on("fetch",function(){this.collection.isLoading=true;$("#loader-container").html('<img src="'+BASE_URL+'includes/img/ajax-loader.gif" />')},this);if(this.collection.size()==0){e_model=new Options({label_id:"0",label:"",label_code:"",published:""});this.collection.push(e_model)}},events:{"shown a[data-toggle='tab']":"showStatus","click .sortcolumn":"updateSortBy","click #submit-search":"toggleSearch","click #loadmore-options":"loadMore","click .record-add":"addPost"},addPost:function(c){c.preventDefault();var d=this;$("#addData").live("show",function(){$(this).find(".btn-success").die().live("click",function(){var a=Array;$.map($(".inopts input").serializeArray(),function(b,f){a[b.name]=b.value});options=new Options();options.save(a,{success:function(b,f){this.$el=$("#addData");this.$el.modal("hide");alert=new AlertView({type:"success",message:"New record successfully added."});alert.render()},error:function(b,f){alert=new AlertView({type:"error",message:f});alert.render()}})})}).modal()},loadMore:function(b){this.collection.requestNextPage()},toggleSearch:function(b){$("#options-table-1 tbody").empty();this.collection.currentPage=1;this.collection.searchVal=$("#search").val();this.collection.pager()},updateSortBy:function(b){if(this.collection.sortDir=="desc"){dir="asc"}else{dir="desc"}this.collection.sortDir=String(dir);this.collection.updateOrder($(b.target).attr("col"))},showStatus:function(c){window.location.hash="/status/1";var d=this.collection;d.status_id=1;d.currentPage=0;d.pager()},render:function(){var b=this;$("#loader-container").empty();this.collection.isLoading=false;if($("#load-more-container").is(":hidden")){$("#options-table-1 tbody").empty()}if(this.collection.size()!=0){$("#options-table-1 tbody").empty()}this.collection.each(this.renderOptions,this);this.collection.each(this.renderOptionsform,this);$("#search").typeahead({source:function(f,e){queryAttributes={};queryAttributes.searchVal=f;var a=[];$.ajax({url:b.collection.paginator_core.url,data:queryAttributes,dataType:"json",success:function(c){typeAheadCollection=new TypeAheadCollection(c.data);return e(typeAheadCollection.pluck("label"))}})},minLength:4});$('[rel="clickover"]').clickover({placement:get_popover_placement,html:true})},renderOptions:function(c){var d=new OptionsView({model:c});$("#options-table-1 tbody").append(d.render().el)},renderOptionsform:function(d){var c=new OptionsForm({model:d});$("#container-option-add").append(c.render().el)}});var AlertView=Backbone.View.extend({el:$("#alert-div"),template:$("#alertTemplate").html(),render:function(){var d=_.template(this.template);var c=Array;c.type=this.options.type;c.message=this.options.message;this.$el.html(d(c));return this}});var OptionsView=Backbone.View.extend({tagName:"tr",template:$("#emp-list-item").html(),editTemplate:_.template($("#option-edit-template").html()),events:{"click .record-delete":"confirmDelete","click .record-edit":"editPost"},editPost:function(c){c.preventDefault();this.$el=$("#container-option-edit");var d=this;this.$el.empty();this.$el.html(this.editTemplate(this.model.toJSON()));$("#editData").live("show",function(){$(this).find(".btn-primary").die().live("click",function(){var a=Array;$.map($(".inopt input").serializeArray(),function(b,f){a[b.name]=b.value});d.model.save(a,{success:function(b,f){this.$el=$("#editData");this.$el.modal("hide");alert=new AlertView({type:"success",message:"Update success."});alert.render()},error:function(b,f){alert=new AlertView({type:"error",message:f});alert.render()}})})}).modal()},confirmDelete:function(c){c.preventDefault();var d=this;$("#deleteData").live("show",function(){$(this).find(".btn-danger").die().live("click",function(){d.model.destroy({success:function(a,b){d.remove()}})})}).modal()},render:function(){var b=_.template(this.template);this.$el.html(b(this.model.toJSON()));return this}});var OptionsForm=Backbone.View.extend({template:$("#container-option-add"),addTemplate:_.template($("#option-add-template").html()),render:function(){this.template.empty();this.template.html(this.addTemplate(this.model.toJSON()));return this}});var PaginatedView=Backbone.View.extend({events:{"click a.servernext":"nextResultPage","click a.serverprevious":"previousResultPage","click a.orderUpdate":"updateSortBy","click a.serverlast":"gotoLast","click a.page":"gotoPage","click a.serverfirst":"gotoFirst","click a.serverpage":"gotoPage","click .serverhowmany a":"changeCount"},tagName:"aside",template:_.template($("#tmpServerPagination").html()),initialize:function(){this.collection.on("reset",this.render,this);this.collection.on("change",this.render,this);this.$el.appendTo("#pagination")},render:function(){var b=this.template(this.collection.info());this.$el.html(b)},updateSortBy:function(c){c.preventDefault();var d=$("#sortByField").val();this.collection.updateOrder(d)},nextResultPage:function(b){b.preventDefault();this.collection.requestNextPage()},previousResultPage:function(b){b.preventDefault();this.collection.requestPreviousPage()},gotoFirst:function(b){b.preventDefault();this.collection.goTo(this.collection.information.firstPage)},gotoLast:function(b){b.preventDefault();this.collection.goTo(this.collection.information.lastPage)},gotoPage:function(c){c.preventDefault();var d=$(c.target).text();this.collection.goTo(d)},changeCount:function(c){c.preventDefault();var d=$(c.target).text();this.collection.howManyPer(d)}});var PaginatedCollection=Backbone.Paginator.requestPager.extend({model:Options,paginator_core:{type:"GET",dataType:"json",url:BASE_URL+"api/admin_labels?"},paginator_ui:{firstPage:1,currentPage:1,perPage:50,sortField:"label_id",sortDir:"asc",searchField:null,searchVal:null,totalPages:10},server_api:{limit:function(){return this.perPage},offset:function(){if(this.currentPage==0){this.currentPage=1}return(this.currentPage-1)*this.perPage},sort:function(){return this.sortField},order:function(){return this.sortDir},searchField:function(){return this.searchField},searchVal:function(){return this.searchVal}},parse:function(d){var c=d.data;this.totalPages=Math.floor(d._count/this.perPage);this.totalRecords=d._count;return c}});