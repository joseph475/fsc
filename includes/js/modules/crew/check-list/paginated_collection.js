var PaginatedCollection=Backbone.Paginator.requestPager.extend({model:Options,crew_id:0,user_id:0,paginator_core:{type:"GET",dataType:"json",url:BASE_URL+"api/checklist_crews?"},paginator_ui:{firstPage:1,currentPage:1,perPage:5,sortField:"sort_order",sortDir:"asc",searchField:null,searchVal:null,totalPages:10},server_api:{crew_id:function(){return this.crew_id},limit:function(){return this.perPage},offset:function(){if(this.currentPage==0){this.currentPage=1}return(this.currentPage-1)*this.perPage},sort:function(){return this.sortField},order:function(){return this.sortDir},searchField:function(){return this.searchField},searchVal:function(){return this.searchVal}},parse:function(a){var b=a.data;this.totalPages=Math.floor(a._count/this.perPage);this.totalRecords=a._count;return b}});