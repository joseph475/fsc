// --------------------------------------------------------------------
// 
var OptionsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#emp-list-item").html(),    
    days_between: function (date1, date2) {
        var date2 = new Date(date2);

        // The number of milliseconds in one day
        var ONE_DAY = 1000 * 60 * 60 * 24

        // Convert both dates to milliseconds
        var date1_ms = date1.getTime()
        var date2_ms = date2.getTime()

        // Calculate the difference in milliseconds
        var difference_ms = Math.abs(date1_ms - date2_ms)
        
        // Convert back to days and return
        return Math.round(difference_ms/ONE_DAY)
    },
    render: function () {
        var current_date = new Date();

        var exp = this.model.get('date_expired');

        this.model.set('date_expired', (exp == '0000-00-00')? '' : exp);

        if (this.days_between(current_date, exp) <= 90) {
            this.model.set('date_expired', "<strong class='alert-expire'>" + exp + '</strong>');
        }
        
        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});