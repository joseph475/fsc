var counter = 0;
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
	    if(date2_ms >= date1_ms) {
            var difference_ms = Math.abs(date2_ms - date1_ms)
        } else {
            var difference_ms = - Math.abs(date2_ms - date1_ms)
        }
	    
	    // Convert back to days and return
	    return Math.round(difference_ms/ONE_DAY)
    },
    render: function () {
        counter = counter + 1;
        this.model.set('counter', counter);

        var current_date = new Date();

        var arr = ['sea_expiry', 'seaman_expiry', 'passport_expiry', 'booklet_license_expiry', 'gmdss_expiry', 'coc_expiry', 'us_expiry', 'yellow_expiry', 'medical_expiry', 'mcv_expiry'];

		for (var i = 0; i < arr.length; i++) {
			var doc = this.model.get(arr[i]);
        	this.model.set(arr[i], (doc == '00/00/0000' || doc == '0000-00-00' || doc == null || doc == ''|| doc == 0)? '' : doc);
			var doc = this.model.get(arr[i]);
			if (this.days_between(current_date, doc) <= 90) {
				this.model.set(arr[i], "<strong class='alert-expire'>" + doc + '</strong>');
			}
		}

        var tmpl = _.template(this.template);        
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
}); 



