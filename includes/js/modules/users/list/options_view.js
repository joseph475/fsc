// --------------------------------------------------------------------
// 
var OptionsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#emp-list-item").html(),
    events: {
        "click .record-delete" : "confirmDelete"
    },
    confirmDelete: function (e) {
        e.preventDefault();
        var that = this;
        $('#deleteData').live('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {         
                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM                
                    that.remove();
                    }
                });   
            });
        })
        .modal();
    },
    render: function () {
        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
}); 
