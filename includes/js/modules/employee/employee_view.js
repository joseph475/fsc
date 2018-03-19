// --------------------------------------------------------------------
// 
var EmployeeView = Backbone.View.extend({
    tagName: "tr",
    className: "employee-container",
    template: $("#emp-list-item").html(),
    render: function () {
        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});  