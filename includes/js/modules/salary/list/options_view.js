var OptionsView=Backbone.View.extend({tagName:"tr",template:$("#emp-list-item").html(),editTemplate:_.template($("#option-edit-template").html()),events:{"click .record-delete":"confirmDelete","click .record-edit":"editPost"},editPost:function(b){b.preventDefault();this.$el=$("#container-option-edit");var a=this;this.$el.empty();this.$el.html(this.editTemplate(this.model.toJSON()));$("#editData").live("show",function(){$(this).find(".btn-primary").die().live("click",function(){var c=Array;$.map($("input.ab, select.ab").serializeArray(),function(e,d){c[e.name]=e.value});a.model.save(c,{success:function(e,d){a.toggleSearch();a.$el=$("#editData");a.$el.modal("hide");alert=new AlertView({type:"success",message:"Update success."});alert.render()},error:function(e,d){alert=new AlertView({type:"error",message:d});alert.render()}})})}).modal()},confirmDelete:function(b){b.preventDefault();var a=this;$("#deleteData").live("show",function(){$(this).find(".btn-danger").die().live("click",function(){a.model.destroy({success:function(d,c){a.remove();alert=new AlertView({type:"success",message:"Record deleted."});alert.render()}})})}).modal()},toggleSearch:function(a){window.location.hash="/status/1";$("#options-table-1 tbody").empty();this.collection.currentPage=1;this.collection.vessel_id=$("#vessel_id").val();this.collection.pager()},render:function(){var a=_.template(this.template);this.$el.html(a(this.model.toJSON()));return this}});var OptionsForm=Backbone.View.extend({template:$("#container-option-add"),addTemplate:_.template($("#option-add-template").html()),render:function(){this.template.empty();this.template.html(this.addTemplate(this.model.toJSON()));return this}});