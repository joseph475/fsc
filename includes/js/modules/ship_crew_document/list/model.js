var Options=Backbone.Model.extend({idAttribute:"crew_id",url:function(){if(this.isNew()){return BASE_URL+"api/sc_doc/id/"}else{return BASE_URL+"api/sc_doc/id/"+this.get("id")}},defaults:{last_name:"",first_name:"",fullname:"",counter:0}});var TypeAheadCollection=Backbone.Collection.extend({model:Options});var Signature=Backbone.Model.extend({idAttribute:"user_id",url:function(){return BASE_URL+"api/user/id/"+this.get("user_id")+"/signature"},defaults:{last_name:"",first_name:"",fullname:"",counter:0}});