var DirectoryView=Backbone.View.extend({el:$("#options-list-view"),initialize:function(){$("#search").typeahead({source:function(b,c){queryAttributes={};queryAttributes.searchVal=b;var a=[];$.ajax({url:BASE_URL+"api/crews?",data:queryAttributes,dataType:"json",success:function(d){typeAheadCollection=new TypeAheadCollection(d.data);return c(typeAheadCollection.pluck("fullname"))}})},minLength:4})}});var Options=Backbone.Model.extend({idAttribute:"crew_id",url:function(){if(this.isNew()){return BASE_URL+"api/crew"}else{return BASE_URL+"api/crew/id/"+this.get("crew_id")}},defaults:{crew_id:"",lastname:"",firstname:""}});var TypeAheadCollection=Backbone.Collection.extend({model:Options});