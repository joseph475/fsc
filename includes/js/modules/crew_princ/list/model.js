var Options=Backbone.Model.extend({idAttribute:"crew_id",url:function(){if(this.isNew()){return BASE_URL+"api/crew"}else{return BASE_URL+"api/crew/id/"+this.get("id")}},defaults:{lastname:"",first_name:"",fullname:"",counter:0}});

var TypeAheadCollection=Backbone.Collection.extend({model:Options});

