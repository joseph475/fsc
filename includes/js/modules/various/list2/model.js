var Options=Backbone.Model.extend({idAttribute:"crew_id",url:function(){if(this.isNew()){return BASE_URL+"api/crew"}else{return BASE_URL+"api/crew/id/"+this.get("id")}},defaults:{last_name:"",first_name:"",fullname:"",counter:0}});var TypeAheadCollection=Backbone.Collection.extend({model:Options});var Options2=Backbone.Model.extend({idAttribute:"id",url:function(){if(this.isNew()){return BASE_URL+"api/document_various"}else{return BASE_URL+"api/document_various/id/"+this.get("id")}},defaults:{docs_id:""}});