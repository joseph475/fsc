var MessageModel = Backbone.Model.extend(
	{
		defaults: {			
			'recipient_id' : undefined,
			'message' : ''
		},		
		validate: function(attrs) {			
			

			if (attrs.message == '') {
				return 'Message is empty.';
			}
		},
		url: function () {
			if (this.isNew()) {
				return BASE_URL + 'api/message/'; 
			} else {
				return BASE_URL + 'api/message/id/' + this.get('id');
			}
		},
	}
);