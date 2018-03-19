var counter = 0;
var OptionsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#emp-list-item").html(),
    render: function () {

        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
}); 



