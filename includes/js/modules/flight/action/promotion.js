var PromotionModel=Backbone.Model.extend({idAttribute:"id",url:function(){if(this.isNew()){return BASE_URL+"api/promotion"}else{return BASE_URL+"api/promotion/id/"+this.get("id")}},defaults:{counter:0,new_code:"",old_code:"",new_position:"",old_position:"",crew_id:0,fullname:"",duration:"",ispromoted:0,code:"",reference:"",salary_id:0,start_date:"0000-00-00",end_date:"0000-00-00",new_end_date:"0000-00-00",extension_date:"0000-00-00",duration_month:0,oid:0,passport_expired:"0000-00-00",coc_expired:"0000-00-00",medical_issued:"0000-00-00",sirb:"",remarks:"",hash:""}});var countr3=0;var PromotionMasterView=Backbone.View.extend({el:$("#promotion-info"),initialize:function(){$(".sortcolumn").css("cursor","pointer");this.collection.isLoading=false;this.collection.on("add",this.renderPromotionView,this);this.collection.on("reset",this.render,this);this.collection.on("fetch",function(){this.collection.isLoading=true;$("#loader-p-container").html('<img src="'+BASE_URL+'includes/img/ajax-loader.gif" />')},this);if(this.collection.size()==0){e_model=new PromotionModel({old_code:"",new_code:"",duration_month:"0",fullname:"",medical_issued:"0000-00-00",sirb:"0000-00-00",passport_expired:"0000-00-00",coc_expired:"0000-00-00"});this.collection.push(e_model)}this.showStatus()},events:{"click .sortcolumn":"updateSortBy"},updateSortBy:function(a){if(this.collection.sortDir=="desc"){dir="asc"}else{dir="desc"}this.collection.sortDir=String(dir);this.collection.updateOrder($(a.target).attr("col"))},showStatus:function(b){var a=this.collection;a.currentPage=0;a.pager()},render:function(){var a=this;$("#loader-p-container").empty();this.collection.isLoading=false;if(this.collection.size()!=0){$("#options-table-promotion tbody").empty()}this.collection.each(this.renderPromotionView,this)},renderPromotionView:function(b){var a=new PromotionView({model:b,collection:this.collection});$("#options-table-promotion tbody").append(a.render().el)}});var PromotionView=Backbone.View.extend({tagName:"tr",template:$("#promotion-list-item").html(),render:function(){countr3=countr3+1;this.model.set("counter",countr3);var a=_.template(this.template);this.$el.html(a(this.model.toJSON()));return this}});var PromotionCollection=Backbone.Paginator.requestPager.extend({model:PromotionModel,sched_id:0,end_date:"0000-00-00",vessel_id:0,paginator_core:{type:"GET",dataType:"json",url:BASE_URL+"api/promotions?"},paginator_ui:{firstPage:1,currentPage:1,perPage:10,sortField:"lastname",sortDir:"asc",searchField:null,searchVal:null,totalPages:10},server_api:{sched_id:function(){return this.sched_id},limit:function(){return this.perPage},offset:function(){if(this.currentPage==0){this.currentPage=1}return(this.currentPage-1)*this.perPage},sort:function(){return this.sortField},order:function(){return this.sortDir},searchField:function(){return this.searchField},searchVal:function(){return this.searchVal}},parse:function(a){var b=a.data;this.totalPages=Math.floor(a._count/this.perPage);this.totalRecords=a._count;return b}});var PromotionPaginatedView=Backbone.View.extend({events:{"click a.servernext":"nextResultPage","click a.serverprevious":"previousResultPage","click a.orderUpdate":"updateSortBy","click a.serverlast":"gotoLast","click a.page":"gotoPage","click a.serverfirst":"gotoFirst","click a.serverpage":"gotoPage","click .serverhowmany a":"changeCount"},tagName:"aside",template:_.template($("#tmpServerPagination").html()),initialize:function(){this.collection.on("reset",this.render,this);this.collection.on("change",this.render,this);this.$el.appendTo("#promotionpagination")},render:function(){var a=this.template(this.collection.info());this.$el.html(a)},updateSortBy:function(b){b.preventDefault();var a=$("#sortByField").val();this.collection.updateOrder(a)},nextResultPage:function(a){a.preventDefault();this.collection.requestNextPage()},previousResultPage:function(a){a.preventDefault();this.collection.requestPreviousPage()},gotoFirst:function(a){a.preventDefault();this.collection.goTo(this.collection.information.firstPage)},gotoLast:function(a){a.preventDefault();this.collection.goTo(this.collection.information.lastPage)},gotoPage:function(b){b.preventDefault();var a=$(b.target).text();this.collection.goTo(a)},changeCount:function(b){b.preventDefault();var a=$(b.target).text();this.collection.howManyPer(a)}});