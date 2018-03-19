var DocumentModel=Backbone.Model.extend({idAttribute:"id",url:function(){if(this.isNew()){return BASE_URL+"api/vessels_doc"}else{return BASE_URL+"api/vessels_doc/id/"+this.get("id")}},defaults:{vessel_id:0,remarks:"",documents:"",published:0}});var DocumentMasterView=Backbone.View.extend({el:$("#document-info"),initialize:function(){$(".sortcolumn").css("cursor","pointer");this.collection.isLoading=false;this.collection.on("add",this.renderDocumentView,this);this.collection.on("add",this.renderDocumentForm,this);this.collection.on("reset",this.render,this);this.collection.on("fetch",function(){this.collection.isLoading=true;$("#loader-container").html('<img src="'+BASE_URL+'includes/img/ajax-loader.gif" />')},this);if(this.collection.size()==0){e_model=new DocumentModel({documents:"",vessel_id:"",remarks:"",published:0});this.collection.push(e_model);this.$el.find(".btn-group").hide()}this.showStatus()},events:{"click .sortcolumn":"updateSortBy","click #document_add-btn":"addDocument"},addDocument:function(b){b.preventDefault();var a=this;$("#addDocument").live("show",function(){$(this).find(".btn-success").die().live("click",function(){var c=Array;$.map($(".inopts input, .inopts textarea").serializeArray(),function(e,d){c[e.name]=e.value});options=new DocumentModel();options.save(c,{success:function(e,d){this.$el=$("#addDocument");this.$el.modal("hide");a.showStatus();alert=new AlertDocumentView({type:"success",message:"New record successfully added."});alert.render()},error:function(e,d){alert=new AlertDocumentView({type:"error",message:d});alert.render()}})})}).modal()},updateSortBy:function(a){if(this.collection.sortDir=="desc"){dir="asc"}else{dir="desc"}this.collection.sortDir=String(dir);this.collection.updateOrder($(a.target).attr("col"))},showStatus:function(b){var a=this.collection;a.currentPage=0;a.pager()},render:function(){var a=this;this.collection.isLoading=false;if(this.collection.size()!=0){$("#options-table-document tbody").empty()}this.collection.each(this.renderDocumentView,this);this.collection.each(this.renderDocumentForm,this)},renderDocumentView:function(b){var a=new DocumentView({model:b,collection:this.collection});$("#options-table-document tbody").append(a.render().el)},renderDocumentForm:function(a){var b=new DocumentForm({model:a});$("#container-document-add").append(b.render().el)}});var AlertDocumentView=Backbone.View.extend({el:$("#alertdocument-div"),template:$("#alertDocumentTemplate").html(),render:function(){var a=_.template(this.template);var b=Array;b.type=this.options.type;b.message=this.options.message;this.$el.html(a(b));return this}});var DocumentView=Backbone.View.extend({tagName:"tr",template:$("#document-list-item").html(),editTemplate:_.template($("#option-edit-document").html()),events:{"click .record-delete":"confirmDelete","click .record-edit":"editDocument"},editDocument:function(b){b.preventDefault();this.$el=$("#container-document-edit");var a=this;this.$el.empty();this.$el.html(this.editTemplate(this.model.toJSON()));$("#editDocument").live("show",function(){$(this).find(".btn-primary").die().live("click",function(){var c=Array;$.map($(".inopts input, .inopts textarea").serializeArray(),function(e,d){c[e.name]=e.value});a.model.save(c,{success:function(e,d){a.showStatus();this.$el=$("#editDocument");this.$el.modal("hide");alert=new AlertDocumentView({type:"success",message:"Record successfully updated"});alert.render()},error:function(e,d){alert=new AlertDocumentView({type:"error",message:d});alert.render()}})})}).modal()},showStatus:function(b){var a=this.collection;a.currentPage=0;a.pager()},confirmDelete:function(b){b.preventDefault();var a=this;$("#deleteDocument").live("show",function(){$(this).find(".btn-danger").die().live("click",function(){a.model.destroy({success:function(d,c){a.remove();alert=new AlertDocumentView({type:"success",message:"Record successfully deleted"});alert.render()}})})}).modal()},render:function(){var a=_.template(this.template);this.$el.html(a(this.model.toJSON()));return this}});var DocumentForm=Backbone.View.extend({template:$("#container-document-add"),addTemplate:_.template($("#option-add-document").html()),render:function(){this.template.empty();this.template.html(this.addTemplate(this.model.toJSON()));return this}});var DocumentCollection=Backbone.Paginator.requestPager.extend({model:DocumentModel,vessel_id:0,paginator_core:{type:"GET",dataType:"json",url:BASE_URL+"api/vessels_docs?"},paginator_ui:{firstPage:1,currentPage:1,perPage:10,sortField:"id",sortDir:"asc",searchField:null,searchVal:null,totalPages:10},server_api:{vessel_id:function(){return this.vessel_id},limit:function(){return this.perPage},offset:function(){if(this.currentPage==0){this.currentPage=1}return(this.currentPage-1)*this.perPage},sort:function(){return this.sortField},order:function(){return this.sortDir},searchField:function(){return this.searchField},searchVal:function(){return this.searchVal}},parse:function(a){var b=a.data;this.totalPages=Math.floor(a._count/this.perPage);this.totalRecords=a._count;return b}});var DocumentPaginatedView=Backbone.View.extend({events:{"click a.servernext":"nextResultPage","click a.serverprevious":"previousResultPage","click a.orderUpdate":"updateSortBy","click a.serverlast":"gotoLast","click a.page":"gotoPage","click a.serverfirst":"gotoFirst","click a.serverpage":"gotoPage","click .serverhowmany a":"changeCount"},tagName:"aside",template:_.template($("#tmpServerPagination").html()),initialize:function(){this.collection.on("reset",this.render,this);this.collection.on("change",this.render,this);this.$el.appendTo("#Documentpagination")},render:function(){var a=this.template(this.collection.info());this.$el.html(a)},updateSortBy:function(b){b.preventDefault();var a=$("#sortByField").val();this.collection.updateOrder(a)},nextResultPage:function(a){a.preventDefault();this.collection.requestNextPage()},previousResultPage:function(a){a.preventDefault();this.collection.requestPreviousPage()},gotoFirst:function(a){a.preventDefault();this.collection.goTo(this.collection.information.firstPage)},gotoLast:function(a){a.preventDefault();this.collection.goTo(this.collection.information.lastPage)},gotoPage:function(b){b.preventDefault();var a=$(b.target).text();this.collection.goTo(a)},changeCount:function(b){b.preventDefault();var a=$(b.target).text();this.collection.howManyPer(a)}});