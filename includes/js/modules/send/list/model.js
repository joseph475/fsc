var Options=Backbone.Model.extend({idAttribute:"id",url:function(){if(this.isNew()){return BASE_URL+"api/send"}else{return BASE_URL+"api/send/id/"+this.get("id")}},defaults:{photo:"",hash:"",fullname:"",crew_id:"",document:"",ds:"",date_sent:"",sent_thru:"", send_by:"", awb_no: ""}});var TypeAheadCollection=Backbone.Collection.extend({model:Options});