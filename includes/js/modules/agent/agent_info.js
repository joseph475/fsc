var AgentModel=Backbone.Model.extend({idAttribute:"id",defaults:{principal_id:0},url:function(){if(this.isNew()){return BASE_URL+"api/agent"}else{return BASE_URL+"api/agent/id/"+this.get("id")}},validate:function(a){}});var AgentCollection=Backbone.Collection.extend({url:function(){return BASE_URL+"api/agent/id/"+this.id},id:0,model:AgentModel});var AgentView=Backbone.View.extend({el:$("#agent-info"),initialize:function(){this.$el.find("#cancel-btn").hide()},events:{"click #edit-btn":"toggleInput","click #cancel-btn":"toggleDisplay","click #save-btn":"saveAbout"},toggleInput:function(a){a.preventDefault();this.$el.find(".ab").each(function(d,e){var h;if($(e).attr("id")!="website"){h=$(e).html()}else{h=$("#website a").text()}var f;if($(e).hasClass("fw98")){f='class="fw98"'}else{if($(e).hasClass("fw93")){f='class="fw93"'}}var b;if($(e).hasClass("ab-txtarea")){b=$('<textarea class="span" rows="5"></textarea>')}else{if($(e).hasClass("ab-input")){var c;if($(e).hasClass("bdate")){c='id="bdate" style="width: 25%"'}else{if($(e).hasClass("odate1")){c='id="odate1" style="width: 93%"'}}b=$('<input type="text" '+f+" "+c+"/>")}else{if($(e).hasClass("ab-select")){var g;b=$('<select class="fw98"></select>');if($(e).hasClass("cs")){g=["Small","Medium","Large","Extra Large"]}else{if($(e).hasClass("sex")){g=["Male","Female"]}else{if($(e).hasClass("sts")){g=["Single","Married","Divorced","Widowed"]}}}for(i=0;i<g.length;i++){$("<option />",{value:g[i],text:g[i],selected:((g[i]==$(".ab-select").text())?true:false)}).appendTo(b)}}}}b.attr("name",$(e).attr("id")).val(h);$(e).html(b)});this.$el.find("#edit-btn").hide();this.$el.find("#save-btn").show();this.$el.find("#cancel-btn").show()},toggleDisplay:function(a){a.preventDefault();this.$el.find(".ab input, .ab textarea, .ab select").each(function(b,c){if($(c).parent("p").attr("id")!="website"){val=$(c).val()}else{val=$("<a></a>").attr("href",$(c).val()).attr("target","_blank").text($(c).val())}$(c).parent("p").html(val)});this.$el.find("#edit-btn").show();this.$el.find("#save-btn").hide();this.$el.find("#cancel-btn").hide()},saveAbout:function(b){var a=this;var c=Array;$.map($("input.ab, select.ab").serializeArray(),function(e,d){c[e.name]=e.value});agent=new AgentModel();if(this.collection){agent.set("id",this.collection.id)}agent.save(c,{success:function(e,d){if(d.status=="success"){if(d.mode==="post"){alert=new AlertView({type:"success",message:"New record succesfully save."});if(d.mode==="post"){$.ajax({url:BASE_URL+"agent-redirect/"+d.hash,dataType:"html",success:function(f){window.location=BASE_URL+f}})}}else{if(d.mode==="put"){alert=new AlertView({type:"success",message:"Record succesfully updated."})}}alert.render()}else{alert=new AlertView({type:"error",message:d.message["name"]["isEmpty"]});alert.render()}},error:function(e,d){alert=new AlertView({type:"error",message:d});alert.render()}})}});var AlertView=Backbone.View.extend({el:$("#alert-div"),template:$("#alertTemplate").html(),render:function(){var a=_.template(this.template);var b=Array;b.type=this.options.type;b.message=this.options.message;this.$el.html(a(b));return this}});