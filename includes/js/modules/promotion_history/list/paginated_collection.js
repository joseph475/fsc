var PaginatedCollection=Backbone.Paginator.requestPager.extend({model:Options,date1:"0000-00-00",date2:"0000-00-00",paginator_core:{type:"GET",dataType:"json",url:BASE_URL+"api/promotion_historys?"},paginator_ui:{firstPage:1,currentPage:1,perPage:50,sortField:"id",sortDir:"asc",searchField:null,searchVal:null,totalPages:10},server_api:{promotion_date:function(){if(this.date1=="0000-00-00"&&this.date2=="0000-00-00"){return""}return"'"+String(this.date1)+"' AND '"+String(this.date2)+"'"},limit:function(){return this.perPage},offset:function(){if(this.currentPage==0){this.currentPage=1}return(this.currentPage-1)*this.perPage},sort:function(){return this.sortField},order:function(){return this.sortDir},searchField:function(){return this.searchField},searchVal:function(){return this.searchVal}},parse:function(a){var b=a.data;this.totalPages=Math.floor(a._count/this.perPage);this.totalRecords=a._count;return b}});