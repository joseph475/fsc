var Options=Backbone.Model.extend({
	idAttribute:"crew_id",
	url:function(){
		if(this.isNew()){
			return BASE_URL+"api/crew"
		} else {
			return BASE_URL+"api/crew/id/"+this.get("crew_id")
		}
	},
	defaults: {
		crew_id:"",
		lastname:"",
		firstname:""
	}
});

var TypeAheadCollection=Backbone.Collection.extend({
	model:Options
});

var OptionPromotions=Backbone.Model.extend({
	idAttribute:"id",
	url:function() {
		if(this.isNew()){
			return BASE_URL+"api/promotion_history"
		} else {
			return BASE_URL+"api/promotion_history/id/"+this.get("id")
		}
	}, 
	defaults: { 
		isfrom_plan:"",
		prev_position:"",
		new_position:""
	}
});

var DirectoryView=Backbone.View.extend({
	el:$("#options-list-view"),
    _href: $(".report-print").attr("href"),
	initialize:function(){
		$(".sortcolumn").css("cursor","pointer");
		if(this.options.status_id==undefined){
			this.options.status_id=$('a[data-toggle="tab"]:first').attr("dep")
		}
		this.collection.isLoading=false;
		this.collection.status_id=this.options.status_id;
		this.collection.on("add",this.renderOptions,this);
		this.collection.on("reset",this.render,this);
		this.collection.on("fetch",function(){
			this.collection.isLoading=true;
			$("#loader-container").html('<img src="'+BASE_URL+'includes/img/ajax-loader.gif" />')
		},this);
        $('.report-print').hide();
	},
	events:{
		"shown a[data-toggle='tab']":"showStatus",
		"click .sortcolumn":"updateSortBy",
		"click #submit-search":"toggleSearch",
		"click #loadmore-options":"loadMore",
		"change #position_id":"toggleSearch",
		"change #principal_id":"toggleSearch"
	},
	loadMore:function(b){
		this.collection.requestNextPage()
	},
	toggleSearch:function(b){
		b.preventDefault();
		$("#options-table-"+this.collection.status_id+" tbody").empty();
		this.collection.currentPage=1;
		this.collection.searchVal=$("#search").val();
		this.collection.position_id=$("#position_id").val();
		this.collection.principal_id=$("#principal_id").val();
		this.collection.pager();
        $('.report-print').show();

        $(".report-print").attr("href", this._href + "/" + $('#principal_id').val()+ "/" + $('#position_id').val()+ "/" + this.collection.status_id);
	},
	updateSortBy:function(b){
		if(this.collection.sortDir=="desc"){
			dir="asc"
		}else{
			dir="desc"
		}
		this.collection.sortDir=String(dir);
		this.collection.updateOrder($(b.target).attr("col"))
	},
	showStatus:function(c){
		window.location.hash="/status/"+$(c.target).attr("dep");
		var d=this.collection;d.status_id=$(c.target).attr("dep");
		d.currentPage=0;
		d.pager();
        $('.report-print').hide();
	},
	render:function(){
		var b=this;
		$("#loader-container").empty();
		this.collection.isLoading=false;
		if($("#load-more-container").is(":hidden")){
			$("#options-table-"+this.collection.status_id+" tbody").empty()
		}
		$('#test span').text(this.collection.totalRecords);
		this.collection.each(this.renderOptions,this);
		$("#search").typeahead({
			source:function(f,e){
				queryAttributes={};
				queryAttributes.searchVal=f;
				var a=[];
				$.ajax({
					url:b.collection.paginator_core.url,
					data:queryAttributes,
					dataType:"json",
					success:function(c){
						typeAheadCollection=new TypeAheadCollection(c.data);
						return e(typeAheadCollection.pluck("fullname"))
					}
				})
			}, minLength:4
		});

		$('[rel="clickover"]').clickover({
			placement:get_popover_placement,
			html:true
		})
	},
	renderOptions:function(c){
		var d=new OptionsView({model:c});
		$("#options-table-"+this.collection.status_id+" tbody").append(d.render().el)
	}
});

var AlertView=Backbone.View.extend({
	el:$("#alert-div"),
	template:$("#alertTemplate").html(),
	render:function(){
		var d=_.template(this.template);
		var c=Array;
		c.type=this.options.type;
		c.message=this.options.message;
		this.$el.html(d(c));return this
	}
});

var OptionsView=Backbone.View.extend({
	tagName:"tr",
	template:$("#emp-list-item").html(),
	promoteTemplate:_.template($("#option-promote-template").html()),
	events:{
		"click .record-delete":"confirmDelete",
		"click .record-promote":"confirmPromote"
	},
	confirmPromote:function(c){
		c.preventDefault();
		this.$el=$("#container-option-promote");
		var d=this;
		this.$el.empty();
		this.$el.html(this.promoteTemplate(this.model.toJSON()));
		$("#promoteData").live("show",function(){
			$(this).find(".btn-success").die().live("click",
				function(){
					var a=Array;
					$.map($(".inopts input, .inopts textarea, .inopts select").serializeArray(),
						function(e,g){
							a[e.name]=e.value
						});
					var b=new OptionPromotions();
					b.save(a,{
						success:function(e,g){
							alert=new AlertView({type:"success",message:"Crew successfully promoted."});
							alert.render()
						},
						error:function(e,g){
							alert=new AlertView({type:"error",message:g
						});
						alert.render()}
					})
				})
		}).modal()
	},
	confirmDelete:function(c){
		c.preventDefault();
		var d=this;$("#deleteData").live("show",function(){
			$(this).find(".btn-danger").die().live("click",function(){
				d.model.destroy({success:function(a,b){
					d.remove()
				}
			})
			})
		}).modal()
	},
	render:function(){
		var b=_.template(this.template);
		this.$el.html(b(this.model.toJSON()));
		return this
	}
});

var PaginatedView=Backbone.View.extend({
	events:{
		"click a.servernext":"nextResultPage",
		"click a.serverprevious":"previousResultPage",
		"click a.orderUpdate":"updateSortBy",
		"click a.serverlast":"gotoLast",
		"click a.page":"gotoPage",
		"click a.serverfirst":"gotoFirst",
		"click a.serverpage":"gotoPage",
		"click .serverhowmany a":"changeCount"
	},
	tagName:"aside",
	template:_.template($("#tmpServerPagination").html()),
	initialize:function(){
		this.collection.on("reset",this.render,this);
		this.collection.on("change",this.render,this);
		this.$el.appendTo("#pagination")
	},
	render:function(){
		var b=this.template(this.collection.info());
		this.$el.html(b)
	},
	updateSortBy:function(c){
		c.preventDefault();
		var d=$("#sortByField").val();
		this.collection.updateOrder(d)
	},
	nextResultPage:function(b){
		b.preventDefault();
		this.collection.requestNextPage()
	},
	previousResultPage:function(b){
		b.preventDefault();
		this.collection.requestPreviousPage()
	},
	gotoFirst:function(b){
		b.preventDefault();
		this.collection.goTo(this.collection.information.firstPage)
	},
	gotoLast:function(b){
		b.preventDefault();
		this.collection.goTo(this.collection.information.lastPage)
	},
	gotoPage:function(c){
		c.preventDefault();
		var d=$(c.target).text();
		this.collection.goTo(d)
	},
	changeCount:function(c){
		c.preventDefault();
		var d=$(c.target).text();
		this.collection.howManyPer(d)
	}
});

var PaginatedCollection=Backbone.Paginator.requestPager.extend({
	model:Options,
	position_id:0,
	paginator_core:{
		type:"GET",
		dataType:"json",
		url:BASE_URL+"api/crew_principals?"
	},
	paginator_ui:{
		firstPage:1,
		currentPage:1,
		perPage:30,
		sortField:"lastname",
		sortDir:"asc",
		searchField:null,
		searchVal:null,
		totalPages:10
	},
	server_api:{
		position_id:function(){
			if(this.position_id==0){
				return""
			}
			return this.position_id
		},
		principal_id:function(){
			if(this.principal_id==0){
				return""
			}
			return this.principal_id
		},
		status_id:function(){
			if(this.status_id=="all"){
				return""
			}
			return this.status_id
		},
		limit:function(){
			return this.perPage
		},
		offset:function(){
			if(this.currentPage==0){
				this.currentPage=1
			}
			return(this.currentPage-1)*this.perPage
		},
		sort:function(){
			return this.sortField
		},
		order:function(){
			return this.sortDir
		},
		searchField:function(){
			return this.searchField
		},
		searchVal:function(){
			return this.searchVal
		}
	},
	parse:function(d){
		var c=d.data;
		this.totalPages=Math.floor(d._count/this.perPage);
		this.totalRecords=d._count;
		return c
	}
});