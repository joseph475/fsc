// --------------------------------------------------------------------
// 
var OptionsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#emp-list-item").html(),
    events: {
    	"click .record-delete" : "confirmDelete",
        'change input[type!="radio"], select': 'change'
    },
    change: function (e) {
        change = {};
        if(e.target.type == 'checkbox'){
            if($(e.target).is(':checked')) {
                e.target.value = 1;
            } else {
                e.target.value = 0;
            }
        }
        change[$(e.target).attr('name')] = $(e.target).val();               
        this.model.set(change, {silent:true}); 
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
