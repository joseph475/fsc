var PaginatedCollection=Backbone.Paginator.requestPager.extend({model:Options,paginator_core:{type:"GET",dataType:"json",url:BASE_URL+"api/users?"},paginator_ui:{firstPage:1,currentPage:1,perPage:50,sortField:"user_id",sortDir:"desc",searchField:null,searchVal:null,totalPages:10},server_api:{limit:function(){return this.perPage},offset:function(){if(this.currentPage==0){this.currentPage=1}return(this.currentPage-1)*this.perPage},sort:function(){return this.sortField},order:function(){return this.sortDir},searchField:function(){return this.searchField},searchVal:function(){return this.searchVal}},parse:function(a){var b=a.data;this.totalPages=Math.floor(a._count/this.perPage);this.totalRecords=a._count;return b}});