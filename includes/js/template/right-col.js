var DepartmentUserModel = Backbone.Collection.extend();

var DepartmentUsersCollection = Backbone.Collection.extend({
	url: function () {
		exclude_id = '';
		if (this.exclude_id != undefined) {
			exclude_id = '?exclude_ids[0]=' + this.exclude_id;
		}

		offset = Math.floor(Math.random() * (25));

		return BASE_URL + 'api/department/id/' + this.department_id + '/users' + exclude_id + '&offset=' + offset;
	},
	parse: function (response) {
        this.totalRecords = response._count;

        return response.data;
	}	
});

var DepartmentUserView = Backbone.View.extend({
	tagName: 'a',
	className: 'label label-info',
	style : 'display: inline',
	attributes: function() {
    	return {
    		'data-content' : '<p>' + this.model.get('company') + '</p><p>' + this.model.get('position') + '</p>',
    		'rel' : 'popover',
		    'href': BASE_URL + 'profile/' + this.model.get('hash'),
		    'data-original-title': this.model.get('full_name'),		    
		    };
	},
    template: $("#depuser-template").html(),
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});

var DepartmentUsersView = Backbone.View.extend({
	el: $('#depusers-preview'),
	initialize: function () {
		this.collection.fetch();
		this.collection.on('reset', this.render, this);
	},	
	render: function () {
		this.$el.find('.depuser-count').text(this.collection.totalRecords);
		this.collection.each(this.renderOne, this);
		this.$el.find('.depusers-container').find('a').removeAttr('style');
		$('a[rel*=popover]').popover({placement: get_popover_placement, html: true, trigger: 'hover'});
	},
	renderOne: function (item) {
        var subview = new DepartmentUserView({
            model: item
        });
        
        this.$el.find('.depusers-container').append($(subview.render().el).hide().fadeIn('slow'));
        this.$el.find('.depusers-container').append('\n');
	}
});