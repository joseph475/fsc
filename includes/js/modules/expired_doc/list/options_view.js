var OptionsView=Backbone.View.extend({tagName:"tr",template:$("#emp-list-item").html(),render:function(){var a=_.template(this.template);this.$el.html(a(this.model.toJSON()));return this}});