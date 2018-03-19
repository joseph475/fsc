var RegModel = Backbone.Model.extend({
    idAttribute: "id",
    defaults: {
        firstname: "",
        lastname: "",
        photo: ""
    },
    url: function () {
        if (this.isNew()) {
            return BASE_URL + "api/crew"
        } else {
            return BASE_URL + "api/crew/id/" + this.get("id")
        }
    },
    validate: function (b) {}
});
var Regcollection = Backbone.Collection.extend({
    url: function () {
        return BASE_URL + "api/crew/id/" + this.id
    },
    id: 0,
    model: RegModel
});
var AboutView = Backbone.View.extend({
    el: $("#personal-info"),
    initialize: function () {
        this.$el.find("#cancel-btn").hide();
        this.$el.find("#profile-section2").show();
        this.$el.find("#profile-section1").hide();


		$(".fileinput-button").hide();
        if (this.collection) {            
       		this.fileupload();
			$(".fileinput-button").show();
        }
        this.date();
        $("#personal-info").on("show", function () {
            $("#profile-section2").show();
            $("#profile-section1").hide()
        });
        $("#personal-info").on("hidden", function () {
            $(this).css({
                height: "120px"
            });
            $("#profile-section2").hide();
            $("#profile-section1").show()
        })
    },
    events: {
        "click #edit-btn": "toggleInput",
        "click #save-btn": "saveAbout"
    },
    toggleInput: function (b) {
        b.preventDefault();
        this.$el.find(".ab").each(function (n, m) {
            var j;
            if ($(m).attr("id") != "website") {
                j = $(m).html()
            } else {
                j = $("#website a").text()
            }
            var l;
            if ($(m).hasClass("fw98")) {
                l = 'class="fw98"'
            } else {
                if ($(m).hasClass("fw93")) {
                    l = 'class="fw93"'
                }
            }
            var a;
            if ($(m).hasClass("ab-txtarea")) {
                a = $('<textarea class="span" rows="5"></textarea>')
            } else {
                if ($(m).hasClass("ab-input")) {
                    var o;
                    if ($(m).hasClass("bdate")) {
                        o = 'id="bdate" style="width: 25%"'
                    } else {
                        if ($(m).hasClass("odate1")) {
                            o = 'id="odate1" style="width: 93%"'
                        }
                    }
                    a = $('<input type="text" ' + l + " " + o + "/>")
                } else {
                    if ($(m).hasClass("ab-select")) {
                        var k;
                        a = $('<select class="fw98"></select>');
                        if ($(m).hasClass("cs")) {
                            k = ["Small", "Medium", "Large", "Extra Large"]
                        } else {
                            if ($(m).hasClass("sex")) {
                                k = ["Male", "Female"]
                            } else {
                                if ($(m).hasClass("sts")) {
                                    k = ["Single", "Married", "Divorced", "Widowed"]
                                }
                            }
                        }
                        for (i = 0; i < k.length; i++) {
                            $("<option />", {
                                value: k[i],
                                text: k[i],
                                selected: ((k[i] == $(".ab-select").text()) ? true : false)
                            }).appendTo(a)
                        }
                    }
                }
            }
            a.attr("name", $(m).attr("id")).val(j);
            $(m).html(a)
        });
        this.$el.find("#edit-btn").hide();
        this.$el.find("#save-btn").show();
        this.$el.find("#cancel-btn").show()
    },
    saveAbout: function (d) 
    {
        d.preventDefault();
        var e = this;
        var f = Array;

        $("#form-modal").validationEngine();
        if ($("#form-modal").validationEngine("validate")) {

	        $("#save-btn").text('wait...page redirecting');
	        $("#save-btn").attr('disabled', true);

            $.map($("input.ab, select.ab").serializeArray(), function (a, b) {
                f[a.name] = a.value
            });

            options = new RegModel();
            if (this.collection) {
                options.set("id", this.collection.id);
                options.set("photo", this.collection.photo)
            } 


        	$.ajax({
	            url     : BASE_URL + 'crew-applicant-validation',
	            data    : { 
	            			lastname : $('#inputlast').val(),
	            			firstname : $('#inputfirst').val(),
	            			middlename : $('#inputmiddle').val(),
	            			birthdate : $('#inputbirthdate').val()
	            		},
	            type    : 'POST',
	            success : function(data){
	                if(data && !options.get('id')) {
	                	$("#save-btn").text('Save');
						$("#save-btn").attr('disabled', false);

	    				alert = new Alert0View({ type: "error", message: "Crew already exist." });
                    	alert.render();
	                } else {
	                	options.save(f, {
			                success: function (a, b) {
			                    if (b.status == "success") {
			                        if (b.mode === "post") {
			                            alert = new Alert0View({ type: "success", message: "New record succesfully save."});
			                        	alert.render();

			                    		 $.ajax({
			                                url: BASE_URL + "crew-redirect/" + b.hash,
			                                dataType: "html",
			                                success: function (c) {
			                                    window.location = BASE_URL + c
			                                }
			                            })
			                        } else {
			                            if (b.mode === "put") {
			                                alert = new Alert0View({ type: "success", message: "Record succesfully updated." });
			                        
			                    			alert.render();

			                    			$("#save-btn").text('Save');
											$("#save-btn").attr('disabled', false);

                                            setTimeout(function () { $(".alert .close").trigger("click")}, 1000);
			                            }
			                        }

			                    } else {
			                        alert = new Alert0View({ type: "error", message: b.message.firstname["isEmpty"] });

			                        $("#save-btn").text('Save');
			                        $("#save-btn").attr('disabled', false);
			                    }
			                },
			                error: function (a, b) {
			                    alert = new Alert0View({ type: "error", message: b });
			                    alert.render();

			                    $("#save-btn").text('Save');
								$("#save-btn").attr('disabled', false);
			                }
			            });


	                }
	            }
	        });

          
            
        }
    },
    fileupload: function () {
        var b = this;
        options = new RegModel();
        if (this.collection) {
            options.set("id", this.collection.id);
            options.set("photo", this.collection.photo)
        }
      
        $("#form-modal").validationEngine();
        $("#fileupload").fileupload({
            add: function (d, a) {
                $("#save-btn").removeAttr("disabled");
                $("#preview-img").remove();
                $("#profile-img-default").hide();
                $("#save-btn").unbind("click");
                $("#save-btn").bind("click", function () {
                    if ($("#form-modal").validationEngine("validate")) {
                        a.submit()
                    }
                });
                window.loadImage(a.files[0], function (c) {
                    $(c).attr("id", "preview-img");
                    $(c).addClass("thumbnail");
                    $(c).attr("height", 88);
                    $(c).attr("width", 84);
                    $("#profile-img-container").append(c)
                })
            },
            start: function (a) {
                $("#upload-progress-container").removeClass("hidden")
            },
            progress: function (d, a) {
                progress = parseInt(a.loaded / a.total * 100, 10);
                $("#upload-progress").css("width", progress + "%").find("span").html(progress + "%")
            },
            done: function (d, a) {
                if (a.result[0].error != undefined) {
                    $("#photo-message").show().html('<span class="label label-important">' + a.result[0].error + ".</span>")
                } else {
                    if ($("#form-modal").validationEngine("validate")) {
                        setTimeout(function () {}, 2000);
                        $("#photo-message").show().html('<span class="label label-success">Photo successfully uploaded.</span>');
                        options.set("id", options.get("id"));
                        options.set("photo", a.result[0].name).save()
                    }
                }
            }
        })
    },
    date: function () {
        $("#inputbirthdate").datepicker({
            yearRange: "-80y:-15y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip"
        });
        $("#odate1").datepicker({
            yearRange: "-80y:y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip"
        })
    }
});
var Alert0View = Backbone.View.extend({
    el: $("#alert0-div"),
    template: $("#alert0Template").html(),
    render: function () {
        var d = _.template(this.template);
        var c = Array;
        c.type = this.options.type;
        c.message = this.options.message;
        this.$el.html(d(c));
        return this
    }
});