var OptionsView=Backbone.View.extend({tagName:"tr",template:$("#emp-list-item").html(),events:{'change input[type!="radio"], select':"change"},change:function(a){change={};change[$(a.target).attr("name")]=$(a.target).val();this.model.set(change,{silent:true})},render:function(){var a=_.template(this.template);this.$el.html(a(this.model.toJSON()));return this}});