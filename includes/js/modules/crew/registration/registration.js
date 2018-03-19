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
    saveAbout: function (d) {
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
          
            options.save(f, {
                success: function (a, b) {
                    if (b.status == "success") {
                        if (b.mode === "post") {
                            alert = new Alert0View({
                                type: "success",
                                message: "New record succesfully save."
                            });
                        
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
                                alert = new Alert0View({
                                    type: "success",
                                    message: "Record succesfully updated."
                                });
                        
                    			alert.render();

                    			$("#save-btn").text('Save');
								$("#save-btn").attr('disabled', false);
                            }
                        }

                    } else {
                        alert = new Alert0View({
                            type: "error",
                            message: b.message.firstname["isEmpty"]
                        })
                    }
                },
                error: function (a, b) {
                    alert = new Alert0View({
                        type: "error",
                        message: b
                    });
                    alert.render();

                    $("#save-btn").text('Save');
					$("#save-btn").attr('disabled', false);
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
var ChildModel = Backbone.Model.extend({
    idAttribute: "id",
    url: function () {
        if (this.isNew()) {
            return BASE_URL + "api/crew_child"
        } else {
            return BASE_URL + "api/crew_child/id/" + this.get("id")
        }
    },
    defaults: {
        crew_id: 0,
        child_name: "",
        child_birthdate: "0000-00-00",
        child_address: "",
        relationship: ""
    }
});
var ChildMasterView = Backbone.View.extend({
    el: $("#children-info"),
    initialize: function () {
        $(".sortcolumn").css("cursor", "pointer");
        this.collection.isLoading = false;
        this.collection.on("add", this.renderChildView, this);
        this.collection.on("add", this.renderChildForm, this);
        this.collection.on("reset", this.render, this);
        this.collection.on("fetch", function () {
            this.collection.isLoading = true;
            $("#loader-container").html('<img src="' + BASE_URL + 'includes/img/ajax-loader.gif" />')
        }, this);
        if (this.collection.size() == 0) {
            e_model = new ChildModel({
                child_name: "",
                child_birthdate: "",
                child_address: "",
                relationship: ""
            });
            this.collection.push(e_model);
            this.$el.find(".btn-group").hide()
        }
        this.showStatus()
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #child_add-btn": "addChild",
        "focus .jrdate": "selectdate"
    },
    addChild: function (c) {
        c.preventDefault();
        var d = this;
        $("#addChild").live("show", function () {
            $(this).find(".btn-success").die().live("click", function () {
                var a = Array;
                $.map($(".inopts input, .inopts select").serializeArray(), function (b, f) {
                    a[b.name] = b.value
                });
                options = new ChildModel();
                options.save(a, {
                    success: function (b, f) {
                        this.$el = $("#addChild");
                        this.$el.modal("hide");
                        d.showStatus();
                        alert = new Alert5View({
                            type: "success",
                            message: "New record successfully added."
                        });
                        alert.render()
                    },
                    error: function (b, f) {
                        alert = new Alert5View({
                            type: "error",
                            message: f
                        });
                        alert.render()
                    }
                })
            })
        }).modal()
    },
    updateSortBy: function (b) {
        if (this.collection.sortDir == "desc") {
            dir = "asc"
        } else {
            dir = "desc"
        }
        this.collection.sortDir = String(dir);
        this.collection.updateOrder($(b.target).attr("col"))
    },
    showStatus: function (c) {
        var d = this.collection;
        d.currentPage = 0;
        d.pager()
    },
    selectdate: function () {
        $(".jrdate").datepicker({
            yearRange: "-80y:y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip"
        })
    },
    render: function () {
        var b = this;
        this.collection.isLoading = false;
        if (this.collection.size() != 0) {
            $("#options-table-child tbody").empty()
        }
        this.collection.each(this.renderChildView, this);
        this.collection.each(this.renderChildForm, this)
    },
    renderChildView: function (c) {
        var d = new ChildView({
            model: c,
            collection: this.collection
        });
        $("#options-table-child tbody").append(d.render().el)
    },
    renderChildForm: function (d) {
        var c = new ChildForm({
            model: d
        });
        $("#container-child-add").append(c.render().el)
    }
});
var Alert5View = Backbone.View.extend({
    el: $("#alert5-div"),
    template: $("#alert5Template").html(),
    render: function () {
        var d = _.template(this.template);
        var c = Array;
        c.type = this.options.type;
        c.message = this.options.message;
        this.$el.html(d(c));
        return this
    }
});
var ChildView = Backbone.View.extend({
    tagName: "tr",
    template: $("#child-list-item").html(),
    editTemplate: _.template($("#option-edit-child").html()),
    events: {
        "click .record-delete": "confirmDelete",
        "click .record-edit": "editChild"
    },
    editChild: function (c) {
        c.preventDefault();
        this.$el = $("#container-child-edit");
        var d = this;
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));
        $("#editChild").live("show", function () {
            $(this).find(".btn-primary").die().live("click", function () {
                var a = Array;
                $.map($(".inopts input, .inopts select").serializeArray(), function (b, f) {
                    a[b.name] = b.value
                });
                d.model.save(a, {
                    success: function (b, f) {
                        d.showStatus();
                        this.$el = $("#editChild");
                        this.$el.modal("hide");
                        alert = new AlertView({
                            type: "success",
                            message: "Record successfully updated"
                        });
                        alert.render()
                    },
                    error: function (b, f) {
                        alert = new AlertView({
                            type: "error",
                            message: f
                        });
                        alert.render()
                    }
                })
            })
        }).modal()
    },
    showStatus: function (c) {
        var d = this.collection;
        d.currentPage = 0;
        d.pager()
    },
    confirmDelete: function (c) {
        c.preventDefault();
        var d = this;
        $("#deleteChild").live("show", function () {
            $(this).find(".btn-danger").die().live("click", function () {
                d.model.destroy({
                    success: function (a, b) {
                        d.remove()
                    }
                })
            })
        }).modal()
    },
    render: function () {
        var b = _.template(this.template);
        this.$el.html(b(this.model.toJSON()));
        return this
    }
});
var ChildForm = Backbone.View.extend({
    template: $("#container-child-add"),
    addTemplate: _.template($("#option-add-child").html()),
    render: function () {
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this
    }
});
var ChildCollection = Backbone.Paginator.requestPager.extend({
    model: ChildModel,
    crew_id: 0,
    paginator_core: {
        type: "GET",
        dataType: "json",
        url: BASE_URL + "api/crew_childs?"
    },
    paginator_ui: {
        firstPage: 1,
        currentPage: 1,
        perPage: 5,
        sortField: "id",
        sortDir: "asc",
        searchField: null,
        searchVal: null,
        totalPages: 10
    },
    server_api: {
        crew_id: function () {
            return this.crew_id
        },
        limit: function () {
            return this.perPage
        },
        offset: function () {
            if (this.currentPage == 0) {
                this.currentPage = 1
            }
            return (this.currentPage - 1) * this.perPage
        },
        sort: function () {
            return this.sortField
        },
        order: function () {
            return this.sortDir
        },
        searchField: function () {
            return this.searchField
        },
        searchVal: function () {
            return this.searchVal
        }
    },
    parse: function (d) {
        var c = d.data;
        this.totalPages = Math.floor(d._count / this.perPage);
        this.totalRecords = d._count;
        return c
    }
});
var ChildPaginatedView = Backbone.View.extend({
    events: {
        "click a.servernext": "nextResultPage",
        "click a.serverprevious": "previousResultPage",
        "click a.orderUpdate": "updateSortBy",
        "click a.serverlast": "gotoLast",
        "click a.page": "gotoPage",
        "click a.serverfirst": "gotoFirst",
        "click a.serverpage": "gotoPage",
        "click .serverhowmany a": "changeCount"
    },
    tagName: "aside",
    template: _.template($("#tmpServerPagination").html()),
    initialize: function () {
        this.collection.on("reset", this.render, this);
        this.collection.on("change", this.render, this);
        this.$el.appendTo("#childpagination")
    },
    render: function () {
        var b = this.template(this.collection.info());
        this.$el.html(b)
    },
    updateSortBy: function (c) {
        c.preventDefault();
        var d = $("#sortByField").val();
        this.collection.updateOrder(d)
    },
    nextResultPage: function (b) {
        b.preventDefault();
        this.collection.requestNextPage()
    },
    previousResultPage: function (b) {
        b.preventDefault();
        this.collection.requestPreviousPage()
    },
    gotoFirst: function (b) {
        b.preventDefault();
        this.collection.goTo(this.collection.information.firstPage)
    },
    gotoLast: function (b) {
        b.preventDefault();
        this.collection.goTo(this.collection.information.lastPage)
    },
    gotoPage: function (c) {
        c.preventDefault();
        var d = $(c.target).text();
        this.collection.goTo(d)
    },
    changeCount: function (c) {
        c.preventDefault();
        var d = $(c.target).text();
        this.collection.howManyPer(d)
    }
});
var DocsModel = Backbone.Model.extend({
    idAttribute: "id",
    url: function () {
        if (this.isNew()) {
            return BASE_URL + "api/crew_doc"
        } else {
            return BASE_URL + "api/crew_doc/id/" + this.get("id")
        }
    },
    defaults: {
        document: "",
        crew_id: 0,
        docs_nos: "",
        date_issued: "0000-00-00",
        date_expired: "0000-00-00",
        remarks: "",
        endorsement: "",
        capacity: "",
        published: 0,
        file_docs: "",
        docs_file: "",
        position_id: 0
    }
});
var TypeAheadCollection = Backbone.Collection.extend({
    model: DocsModel
});
var DocsMasterView = Backbone.View.extend({
    el: $("#documents-info"),
    initialize: function () {
        $(".sortcolumn").css("cursor", "pointer");
        this.collection.isLoading = false;
        this.collection.on("add", this.renderDocsView, this);
        this.collection.on("reset", this.render, this);
        this.collection.on("fetch", function () {
            this.collection.isLoading = true;
            $("#loader-container").html('<img src="' + BASE_URL + 'includes/img/ajax-loader.gif" />')
        }, this);
        if (this.collection.size() == 0) {
            e_model = new DocsModel({
                document: "",
                published: "",
                docs_nos: "",
                date_issued: "",
                date_expired: "",
                remarks: "",
                file_docs: "",
                docs_file: "",
                endorsement: "",
                capacity: ""
            });
            this.collection.push(e_model);
            this.$el.find(".btn-group").hide()
        }
        this.showStatus()
    },
    events: {
        "click #doc_save-btn": "saveDocs",
        "click #submit-search": "toggleSearch",
        "click #doc_generate-btn": "generateDocs",
        "focus .ddate": "selectdate",
        "click .sortcolumn": "updateSortBy"
    },
    toggleSearch: function (a) {
        a.preventDefault();
        $("#options-table-docs tbody").empty();
        this.collection.currentPage = 1;
        this.collection.searchVal = $("#search").val();
        this.collection.pager()
    },
    saveDocs: function (c) {
        c.preventDefault();
        var a = this;
        this.valid = true;
        _.each(this.collection.models, function (d) {
            if (!d.isValid()) {
                this.valid = false
            }
        }, this);
        if (this.valid) {
            var b = 0;
            _.each(this.collection.models, function (d) {
                $(c.target).text("Saving...").attr("disabled", false);
                d.save("", "", {
                    success: function () {
                        alert = new Alert2View({
                            type: "success",
                            message: "Document successfully updated"
                        });
                        alert.render()
                    },
                    error: function (f, e) {
                        alert = new Alert2View({
                            type: "error",
                            message: e
                        });
                        alert.render()
                    },
                    wait: true
                });
                $(c.target).text("Save")
            }, this)
        }
    },
    generateDocs: function (b) {
        b.preventDefault();
        var a = this;
        var c = Array;
        docu = new DocsModel();
        c.crew_id = this.collection.crew_id;
        docu.save(c, {
            success: function (e, d) {
                a.showStatus();
                alert = new Alert2View({
                    type: "success",
                    message: "Document successfully modified."
                });
                alert.render()
            },
            error: function (e, d) {
                alert = new Alert2View({
                    type: "error",
                    message: d
                });
                alert.render()
            }
        });
        $("#generateData").live("show", function () {
            setTimeout(function () {
                $("#loader-container").html('<img src="' + BASE_URL + 'includes/img/ajax-loader.gif" />');
                $("#generateData").modal("hide")
            }, 2000)
        }).modal()
    },
    selectdate: function () {
        $(".ddate").datepicker({
            yearRange: "-60y:+10y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip"
        })
    },
    updateSortBy: function (a) {
        if (this.collection.sortDir == "desc") {
            dir = "asc"
        } else {
            dir = "desc"
        }
        this.collection.sortDir = String(dir);
        this.collection.updateOrder($(a.target).attr("col"))
    },
    showStatus: function (b) {
        var a = this.collection;
        a.currentPage = 0;
        a.pager()
    },
    render: function () {
        var a = this;
        this.collection.isLoading = false;
        if (this.collection.size() != 0) {
            $("#options-table-docs tbody").empty()
        }
        this.collection.each(this.renderDocsView, this);
        $("#search").typeahead({
            source: function (c, d) {
                queryAttributes = {};
                queryAttributes.searchVal = c;
                queryAttributes.crew_id = a.collection.crew_id;
                var b = [];
                $.ajax({
                    url: a.collection.paginator_core.url,
                    data: queryAttributes,
                    dataType: "json",
                    success: function (e) {
                        typeAheadCollection = new TypeAheadCollection(e.data);
                        return d(typeAheadCollection.pluck("document"))
                    }
                })
            },
            minLength: 4
        })
    },
    renderDocsView: function (b) {
        var a = new DocsView({
            model: b,
            collection: this.collection
        });
        $("#options-table-docs tbody").append(a.render().el)
    }
});
var Alert2View = Backbone.View.extend({
    el: $("#alert2-div"),
    template: $("#alert2Template").html(),
    render: function () {
        var a = _.template(this.template);
        var b = Array;
        b.type = this.options.type;
        b.message = this.options.message;
        this.$el.html(a(b));
        return this
    }
});
var DocsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#docs-list-item").html(),
    events: {
        "click .record-delete": "confirmDelete",
        'change input[type!="radio"], select': "change",
        "click .record-upload": "test"
    },
    test: function (b) {
        b.preventDefault();
        var a = this;
        a.showStatus();
        $("#uploadData").live("show", function () {
            $("#file-message").hide();
            $(this).find(".btn-success").die().live("click", function () {
                $.ajaxFileUpload({
                    url: BASE_URL + "upload/upload_files",
                    secureuri: false,
                    fileElementId: "userfile",
                    dataType: "json",
                    data: {},
                    success: function (e, c) {
                        var d = "label-important";
                        var f = "error";
                        if (e.status != "error") {
                            a.model.set("docs_file", e.name).save();
                            d = "label-success";
                            f = "success";
                            $("#options-table-docs tbody").empty();
                            a.showStatus()
                        }
                        $("#file-message").show().html('<span class="label ' + d + '">' + e.msg + ".</span>");
                        this.$el = $("#uploadData");
                        this.$el.modal("hide");
                        alert = new Alert2View({
                            type: f,
                            message: e.msg
                        });
                        alert.render()
                    }
                });
                return false
            })
        }).modal()
    },
    showStatus: function (b) {
        var a = this.collection;
        a.currentPage = 1;
        a.pager()
    },
    change: function (a) {
        change = {};
        if (a.target.type == "checkbox") {
            if ($(a.target).is(":checked")) {
                a.target.value = 1
            } else {
                a.target.value = 0
            }
        }
        change[$(a.target).attr("name")] = $(a.target).val();
        this.model.set(change, {
            silent: true
        })
    },
    confirmDelete: function (b) {
        b.preventDefault();
        var a = this;
        $("#deleteDocs").live("show", function () {
            $(this).find(".btn-danger").die().live("click", function () {
                a.model.destroy({
                    success: function (d, c) {
                        a.remove()
                    }
                })
            })
        }).modal()
    },
    render: function () {
        var c = new Date();
        var d = this.model.get("date_expired");
        var b = this.model.get("date_issued");
        this.model.set("date_issued", (b == "0000-00-00") ? "" : b);
        this.model.set("date_expired", (d == "0000-00-00") ? "" : d);
        var a = _.template(this.template);
        this.$el.html(a(this.model.toJSON()));
        return this
    }
});
var DocsCollection = Backbone.Paginator.requestPager.extend({
    model: DocsModel,
    crew_id: 0,
    hashid: 0,
    totalRec: 0,
    paginator_core: {
        type: "GET",
        dataType: "json",
        url: BASE_URL + "api/crew_docs?"
    },
    paginator_ui: {
        firstPage: 1,
        currentPage: 1,
        perPage: 50,
        sortField: "jd_document.sort_order",
        sortDir: "asc",
        searchField: "published",
        searchVal: null,
        totalPages: 10
    },
    server_api: {
        crew_id: function () {
            return this.crew_id
        },
        published: function () {
            return 1
        },
        limit: function () {
            return this.perPage
        },
        offset: function () {
            if (this.currentPage == 0) {
                this.currentPage = 1
            }
            return (this.currentPage - 1) * this.perPage
        },
        sort: function () {
            return this.sortField
        },
        order: function () {
            return this.sortDir
        },
        searchField: function () {
            return this.searchField
        },
        searchVal: function () {
            return this.searchVal
        }
    },
    parse: function (a) {
        var b = a.data;
        this.totalPages = Math.floor(a._count / this.perPage);
        this.totalRecords = a._count;
        return b
    }
});
var DocsPaginatedView = Backbone.View.extend({
    events: {
        "click a.servernext": "nextResultPage",
        "click a.serverprevious": "previousResultPage",
        "click a.orderUpdate": "updateSortBy",
        "click a.serverlast": "gotoLast",
        "click a.page": "gotoPage",
        "click a.serverfirst": "gotoFirst",
        "click a.serverpage": "gotoPage",
        "click .serverhowmany a": "changeCount"
    },
    tagName: "aside",
    template: _.template($("#tmpServerPagination").html()),
    initialize: function () {
        this.collection.on("reset", this.render, this);
        this.collection.on("change", this.render, this);
        this.$el.appendTo("#docspagination")
    },
    render: function () {
        var a = this.template(this.collection.info());
        this.$el.html(a)
    },
    updateSortBy: function (b) {
        b.preventDefault();
        var a = $("#sortByField").val();
        this.collection.updateOrder(a)
    },
    nextResultPage: function (a) {
        a.preventDefault();
        this.collection.requestNextPage()
    },
    previousResultPage: function (a) {
        a.preventDefault();
        this.collection.requestPreviousPage()
    },
    gotoFirst: function (a) {
        a.preventDefault();
        this.collection.goTo(this.collection.information.firstPage)
    },
    gotoLast: function (a) {
        a.preventDefault();
        this.collection.goTo(this.collection.information.lastPage)
    },
    gotoPage: function (b) {
        b.preventDefault();
        var a = $(b.target).text();
        this.collection.goTo(a)
    },
    changeCount: function (b) {
        b.preventDefault();
        var a = $(b.target).text();
        this.collection.howManyPer(a)
    }
});
var EducModel = Backbone.Model.extend({
    idAttribute: "id",
    url: function () {
        if (this.isNew()) {
            return BASE_URL + "api/crew_educs"
        } else {
            return BASE_URL + "api/crew_educs/id/" + this.get("id")
        }
    },
    defaults: {
        crew_id: 0,
        year: "0000 - 0000",
        school: "",
        course: "",
        vocational: ""
    }
});
var EducMasterView = Backbone.View.extend({
    el: $("#education-info"),
    initialize: function () {
        $(".sortcolumn").css("cursor", "pointer");
        this.collection.isLoading = false;
        this.collection.on("add", this.renderEducView, this);
        this.collection.on("add", this.renderEducForm, this);
        this.collection.on("reset", this.render, this);
        this.collection.on("fetch", function () {
            this.collection.isLoading = true;
            $("#loader-container").html('<img src="' + BASE_URL + 'includes/img/ajax-loader.gif" />')
        }, this);
        if (this.collection.size() == 0) {
            e_model = new EducModel({
                year: "",
                school: "",
                course: "",
                vocational: ""
            });
            this.collection.push(e_model);
            this.$el.find(".btn-group").hide()
        }
        this.showStatus()
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #educ_add-btn": "addPost"
    },
    addPost: function (c) {
        c.preventDefault();
        var d = this;
        $("#addData").live("show", function () {
            $(this).find(".btn-success").die().live("click", function () {
                var a = Array;
                $.map($(".inopts input").serializeArray(), function (b, f) {
                    a[b.name] = b.value
                });
                options = new EducModel();
                options.save(a, {
                    success: function (b, f) {
                        this.$el = $("#addData");
                        this.$el.modal("hide");
                        d.showStatus();
                        alert = new Alert3View({
                            type: "success",
                            message: "New record successfully added."
                        });
                        alert.render()
                    },
                    error: function (b, f) {
                        alert = new Alert3View({
                            type: "error",
                            message: f
                        });
                        alert.render()
                    }
                })
            })
        }).modal()
    },
    updateSortBy: function (b) {
        if (this.collection.sortDir == "desc") {
            dir = "asc"
        } else {
            dir = "desc"
        }
        this.collection.sortDir = String(dir);
        this.collection.updateOrder($(b.target).attr("col"))
    },
    showStatus: function (c) {
        var d = this.collection;
        d.currentPage = 0;
        d.pager()
    },
    render: function () {
        var b = this;
        this.collection.isLoading = false;
        if (this.collection.size() != 0) {
            $("#options-table-educs tbody").empty()
        }
        this.collection.each(this.renderEducView, this);
        this.collection.each(this.renderEducForm, this)
    },
    renderEducView: function (c) {
        var d = new EducView({
            model: c,
            collection: this.collection
        });
        $("#options-table-educs tbody").append(d.render().el)
    },
    renderEducForm: function (d) {
        var c = new EducForm({
            model: d
        });
        $("#container-option-add").append(c.render().el)
    }
});
var Alert3View = Backbone.View.extend({
    el: $("#alert3-div"),
    template: $("#alert3Template").html(),
    render: function () {
        var d = _.template(this.template);
        var c = Array;
        c.type = this.options.type;
        c.message = this.options.message;
        this.$el.html(d(c));
        return this
    }
});
var EducView = Backbone.View.extend({
    tagName: "tr",
    className: "employee-container",
    template: $("#emp-list-item").html(),
    editTemplate: _.template($("#option-edit-template").html()),
    events: {
        "click .record-delete": "confirmDelete",
        "click .record-edit": "editPost"
    },
    editPost: function (c) {
        c.preventDefault();
        this.$el = $("#container-option-edit");
        var d = this;
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));
        $("#editData").live("show", function () {
            $(this).find(".btn-primary").die().live("click", function () {
                var a = Array;
                $.map($("input.ab").serializeArray(), function (b, f) {
                    a[b.name] = b.value
                });
                d.model.save(a, {
                    success: function (b, f) {
                        d.showStatus();
                        this.$el = $("#editData");
                        this.$el.modal("hide");
                        alert = new Alert3View({
                            type: "success",
                            message: "Record successfully updated"
                        });
                        alert.render()
                    },
                    error: function (b, f) {
                        alert = new Alert3View({
                            type: "error",
                            message: f
                        });
                        alert.render()
                    }
                })
            })
        }).modal()
    },
    showStatus: function (c) {
        var d = this.collection;
        d.currentPage = 0;
        d.pager()
    },
    confirmDelete: function (c) {
        c.preventDefault();
        var d = this;
        $("#deleteData").live("show", function () {
            $(this).find(".btn-danger").die().live("click", function () {
                d.model.destroy({
                    success: function (a, b) {
                        d.remove()
                    }
                })
            })
        }).modal()
    },
    render: function () {
        var b = _.template(this.template);
        this.$el.html(b(this.model.toJSON()));
        return this
    }
});
var EducForm = Backbone.View.extend({
    template: $("#container-option-add"),
    addTemplate: _.template($("#option-add-template").html()),
    render: function () {
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this
    }
});
var EducCollection = Backbone.Paginator.requestPager.extend({
    model: EducModel,
    crew_id: 0,
    paginator_core: {
        type: "GET",
        dataType: "json",
        url: BASE_URL + "api/crew_educations?"
    },
    paginator_ui: {
        firstPage: 1,
        currentPage: 1,
        perPage: 5,
        sortField: "id",
        sortDir: "asc",
        searchField: null,
        searchVal: null,
        totalPages: 10
    },
    server_api: {
        crew_id: function () {
            return this.crew_id
        },
        limit: function () {
            return this.perPage
        },
        offset: function () {
            if (this.currentPage == 0) {
                this.currentPage = 1
            }
            return (this.currentPage - 1) * this.perPage
        },
        sort: function () {
            return this.sortField
        },
        order: function () {
            return this.sortDir
        },
        searchField: function () {
            return this.searchField
        },
        searchVal: function () {
            return this.searchVal
        }
    },
    parse: function (d) {
        var c = d.data;
        this.totalPages = Math.floor(d._count / this.perPage);
        this.totalRecords = d._count;
        return c
    }
});
var PaginatedView = Backbone.View.extend({
    events: {
        "click a.servernext": "nextResultPage",
        "click a.serverprevious": "previousResultPage",
        "click a.orderUpdate": "updateSortBy",
        "click a.serverlast": "gotoLast",
        "click a.page": "gotoPage",
        "click a.serverfirst": "gotoFirst",
        "click a.serverpage": "gotoPage",
        "click .serverhowmany a": "changeCount"
    },
    tagName: "aside",
    template: _.template($("#tmpServerPagination").html()),
    initialize: function () {
        this.collection.on("reset", this.render, this);
        this.collection.on("change", this.render, this);
        this.$el.appendTo("#pagination")
    },
    render: function () {
        var b = this.template(this.collection.info());
        this.$el.html(b)
    },
    updateSortBy: function (c) {
        c.preventDefault();
        var d = $("#sortByField").val();
        this.collection.updateOrder(d)
    },
    nextResultPage: function (b) {
        b.preventDefault();
        this.collection.requestNextPage()
    },
    previousResultPage: function (b) {
        b.preventDefault();
        this.collection.requestPreviousPage()
    },
    gotoFirst: function (b) {
        b.preventDefault();
        this.collection.goTo(this.collection.information.firstPage)
    },
    gotoLast: function (b) {
        b.preventDefault();
        this.collection.goTo(this.collection.information.lastPage)
    },
    gotoPage: function (c) {
        c.preventDefault();
        var d = $(c.target).text();
        this.collection.goTo(d)
    },
    changeCount: function (c) {
        c.preventDefault();
        var d = $(c.target).text();
        this.collection.howManyPer(d)
    }
});
var WorksModel = Backbone.Model.extend({
    idAttribute: "id",
    url: function () {
        if (this.isNew()) {
            return BASE_URL + "api/crew_work"
        } else {
            return BASE_URL + "api/crew_work/id/" + this.get("id")
        }
    },
    defaults: {
        crew_id: 0,
        company: "",
        vessel: "",
        rank: "",
        grt: "",
        type: "",
        engine: "",
        trade: "",
        embarked: "0000-00-00",
        disembarked: "0000-00-00",
        remarks: ""
    }
});
var WorksMasterView = Backbone.View.extend({
    el: $("#works-info"),
    initialize: function () {
        $(".sortcolumn").css("cursor", "pointer");
        this.collection.isLoading = false;
        this.collection.on("add", this.renderWorksView, this);
        this.collection.on("add", this.renderWorksForm, this);
        this.collection.on("reset", this.render, this);
        this.collection.on("fetch", function () {
            this.collection.isLoading = true;
            $("#loader-container").html('<img src="' + BASE_URL + 'includes/img/ajax-loader.gif" />')
        }, this);
        if (this.collection.size() == 0) {
            e_model = new WorksModel({
                company: "",
                vessel: "",
                rank: "",
                grt: "",
                type: "",
                engine: "",
                trade: "",
                embarked: "",
                disembarked: "",
                remarks: ""
            });
            this.collection.push(e_model);
            this.$el.find(".btn-group").hide()
        }
        this.embdate();
        this.showStatus()
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #work_add-btn": "addWorkPost",
        "focus .wdate": "embdate"
    },
    addWorkPost: function (c) {
        c.preventDefault();
        var d = this;
        $("#addWork").live("show", function () {
            $(this).find(".btn-success").die().live("click", function () {
                var a = Array;
                $.map($(".inopts input,.inopts select").serializeArray(), function (b, f) {
                    a[b.name] = b.value
                });
                options = new WorksModel();
                options.save(a, {
                    success: function (b, f) {
                        this.$el = $("#addWork");
                        this.$el.modal("hide");
                        d.showStatus();
                        alert = new Alert4View({
                            type: "success",
                            message: "New record successfully added."
                        });
                        alert.render()
                    },
                    error: function (b, f) {
                        alert = new Alert4View({
                            type: "error",
                            message: f
                        });
                        alert.render()
                    }
                })
            })
        }).modal()
    },
    updateSortBy: function (b) {
        if (this.collection.sortDir == "desc") {
            dir = "asc"
        } else {
            dir = "desc"
        }
        this.collection.sortDir = String(dir);
        this.collection.updateOrder($(b.target).attr("col"))
    },
    showStatus: function (c) {
        var d = this.collection;
        d.currentPage = 0;
        d.pager()
    },
    render: function () {
        var b = this;
        this.collection.isLoading = false;
        if (this.collection.size() != 0) {
            $("#options-table-works tbody").empty()
        }
        this.collection.each(this.renderWorksView, this);
        this.collection.each(this.renderWorksForm, this)
    },
    renderWorksView: function (c) {
        var d = new WorksView({
            model: c,
            collection: this.collection
        });
        $("#options-table-works tbody").append(d.render().el)
    },
    renderWorksForm: function (d) {
        var c = new WorksForm({
            model: d
        });
        $("#container-option-add").append(c.render().el)
    },
    embdate: function () {
        $(".wdate").datepicker({
            yearRange: "-80y:y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip"
        })
    }
});
var Alert4View = Backbone.View.extend({
    el: $("#alert4-div"),
    template: $("#alert4Template").html(),
    render: function () {
        var d = _.template(this.template);
        var c = Array;
        c.type = this.options.type;
        c.message = this.options.message;
        this.$el.html(d(c));
        return this
    }
});
var WorksView = Backbone.View.extend({
    tagName: "tr",
    template: $("#works-list-item").html(),
    editTemplate: _.template($("#works-edit-template").html()),
    initialize: function () {
        this.dembdate()
    },
    events: {
        "click .record-delete": "confirmDelete",
        "click .record-edit": "editPost",
        "focus .wdate": "dembdate"
    },
    editPost: function (c) {
        c.preventDefault();
        this.$el = $("#container-works-edit");
        var d = this;
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));
        $("#editWork").live("show", function () {
            $(this).find(".btn-primary").die().live("click", function () {
                var a = Array;
                $.map($("input.ab, select.ab").serializeArray(), function (b, f) {
                    a[b.name] = b.value
                });
                d.model.save(a, {
                    success: function (b, f) {
                        d.showStatus();
                        this.$el = $("#editWork");
                        this.$el.modal("hide");
                        alert = new Alert4View({
                            type: "success",
                            message: "Record successfully updated"
                        });
                        alert.render()
                    },
                    error: function (b, f) {
                        alert = new Alert4View({
                            type: "error",
                            message: f
                        });
                        alert.render()
                    }
                })
            })
        }).modal()
    },
    confirmDelete: function (c) {
        c.preventDefault();
        var d = this;
        $("#deleteWork").live("show", function () {
            $(this).find(".btn-danger").die().live("click", function () {
                d.model.destroy({
                    success: function (a, b) {
                        d.remove();
                        d.showStatus()
                    }
                })
            })
        }).modal()
    },
    showStatus: function (c) {
        var d = this.collection;
        d.currentPage = 0;
        d.pager()
    },
    render: function () {
        var b = _.template(this.template);
        this.$el.html(b(this.model.toJSON()));
        return this
    },
    dembdate: function () {
        $(".wdate").datepicker({
            yearRange: "-80y:y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip"
        })
    }
});
var WorksForm = Backbone.View.extend({
    template: $("#container-works-add"),
    addTemplate: _.template($("#works-add-template").html()),
    render: function () {
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this
    }
});
var WorksCollection = Backbone.Paginator.requestPager.extend({
    model: WorksModel,
    crew_id: 0,
    paginator_core: {
        type: "GET",
        dataType: "json",
        url: BASE_URL + "api/crew_works?"
    },
    paginator_ui: {
        firstPage: 1,
        currentPage: 1,
        perPage: 5,
        sortField: "embarked",
        sortDir: "desc",
        searchField: null,
        searchVal: null,
        totalPages: 10
    },
    server_api: {
        crew_id: function () {
            return this.crew_id
        },
        limit: function () {
            return this.perPage
        },
        offset: function () {
            if (this.currentPage == 0) {
                this.currentPage = 1
            }
            return (this.currentPage - 1) * this.perPage
        },
        sort: function () {
            return this.sortField
        },
        order: function () {
            return this.sortDir
        },
        searchField: function () {
            return this.searchField
        },
        searchVal: function () {
            return this.searchVal
        }
    },
    parse: function (d) {
        var c = d.data;
        this.totalPages = Math.floor(d._count / this.perPage);
        this.totalRecords = d._count;
        return c
    }
});
var WorksPaginatedView = Backbone.View.extend({
    events: {
        "click a.servernext": "nextResultPage",
        "click a.serverprevious": "previousResultPage",
        "click a.orderUpdate": "updateSortBy",
        "click a.serverlast": "gotoLast",
        "click a.page": "gotoPage",
        "click a.serverfirst": "gotoFirst",
        "click a.serverpage": "gotoPage",
        "click .serverhowmany a": "changeCount"
    },
    tagName: "aside",
    template: _.template($("#tmpServerPagination").html()),
    initialize: function () {
        this.collection.on("reset", this.render, this);
        this.collection.on("change", this.render, this);
        this.$el.appendTo("#workpagination")
    },
    render: function () {
        var b = this.template(this.collection.info());
        this.$el.html(b)
    },
    updateSortBy: function (c) {
        c.preventDefault();
        var d = $("#sortByField").val();
        this.collection.updateOrder(d)
    },
    nextResultPage: function (b) {
        b.preventDefault();
        this.collection.requestNextPage()
    },
    previousResultPage: function (b) {
        b.preventDefault();
        this.collection.requestPreviousPage()
    },
    gotoFirst: function (b) {
        b.preventDefault();
        this.collection.goTo(this.collection.information.firstPage)
    },
    gotoLast: function (b) {
        b.preventDefault();
        this.collection.goTo(this.collection.information.lastPage)
    },
    gotoPage: function (c) {
        c.preventDefault();
        var d = $(c.target).text();
        this.collection.goTo(d)
    },
    changeCount: function (c) {
        c.preventDefault();
        var d = $(c.target).text();
        this.collection.howManyPer(d)
    }
});
var CommentModel = Backbone.Model.extend({
    idAttribute: "id",
    url: function () {
        if (this.isNew()) {
            return BASE_URL + "api/crew_comment"
        } else {
            return BASE_URL + "api/crew_comment/id/" + this.get("id")
        }
    },
    defaults: {
        crew_id: 0,
        description: ""
    }
});
var CommentMasterView = Backbone.View.extend({
    el: $("#comment-info"),
    initialize: function () {
        $(".sortcolumn").css("cursor", "pointer");
        this.collection.isLoading = false;
        this.collection.on("add", this.renderCommentView, this);
        this.collection.on("add", this.renderCommentForm, this);
        this.collection.on("reset", this.render, this);
        this.collection.on("fetch", function () {
            this.collection.isLoading = true;
            $("#loader-container").html('<img src="' + BASE_URL + 'includes/img/ajax-loader.gif" />')
        }, this);
        if (this.collection.size() == 0) {
            e_model = new CommentModel({
                title: "",
                crew_id: "",
                description: ""
            });
            this.collection.push(e_model);
            this.$el.find(".btn-group").hide()
        }
        this.showStatus()
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #comment_add-btn": "addComment"
    },
    addComment: function (c) {
        c.preventDefault();
        var d = this;
        $("#addComment").live("show", function () {
            $(this).find(".btn-success").die().live("click", function () {
                var a = Array;
                $.map($(".inopts input, .inopts textarea, .inopts select").serializeArray(), function (b, f) {
                    a[b.name] = b.value
                });
                options = new CommentModel();
                options.save(a, {
                    success: function (b, f) {
                        this.$el = $("#addComment");
                        this.$el.modal("hide");
                        d.showStatus();
                        alert = new AlertCommentView({
                            type: "success",
                            message: "New record successfully added."
                        });
                        alert.render()
                    },
                    error: function (b, f) {
                        alert = new AlertCommentView({
                            type: "error",
                            message: f
                        });
                        alert.render()
                    }
                })
            })
        }).modal()
    },
    updateSortBy: function (b) {
        if (this.collection.sortDir == "desc") {
            dir = "asc"
        } else {
            dir = "desc"
        }
        this.collection.sortDir = String(dir);
        this.collection.updateOrder($(b.target).attr("col"))
    },
    showStatus: function (c) {
        var d = this.collection;
        d.currentPage = 0;
        d.pager()
    },
    render: function () {
        var b = this;
        this.collection.isLoading = false;
        if (this.collection.size() != 0) {
            $("#options-table-comment tbody").empty()
        }
        this.collection.each(this.renderCommentView, this);
        this.collection.each(this.renderCommentForm, this)
    },
    renderCommentView: function (c) {
        var d = new CommentView({
            model: c,
            collection: this.collection
        });
        $("#options-table-comment tbody").append(d.render().el)
    },
    renderCommentForm: function (d) {
        var c = new CommentForm({
            model: d
        });
        $("#container-comment-add").append(c.render().el)
    }
});
var AlertCommentView = Backbone.View.extend({
    el: $("#alertComment-div"),
    template: $("#alertCommentTemplate").html(),
    render: function () {
        var d = _.template(this.template);
        var c = Array;
        c.type = this.options.type;
        c.message = this.options.message;
        this.$el.html(d(c));
        return this
    }
});
var CommentView = Backbone.View.extend({
    tagName: "tr",
    template: $("#comment-list-item").html(),
    editTemplate: _.template($("#option-edit-comment").html()),
    events: {
        "click .record-delete": "confirmDelete",
        "click .record-edit": "editComment"
    },
    editComment: function (c) {
        c.preventDefault();
        this.$el = $("#container-comment-edit");
        var d = this;
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));
        $("#editComment").live("show", function () {
            $(this).find(".btn-primary").die().live("click", function () {
                var a = Array;
                $.map($(".inopts input, .inopts textarea, .inopts select").serializeArray(), function (b, f) {
                    a[b.name] = b.value
                });
                d.model.save(a, {
                    success: function (b, f) {
                        d.showStatus();
                        this.$el = $("#editComment");
                        this.$el.modal("hide");
                        alert = new AlertCommentView({
                            type: "success",
                            message: "Record successfully updated"
                        });
                        alert.render()
                    },
                    error: function (b, f) {
                        alert = new AlertCommentView({
                            type: "error",
                            message: f
                        });
                        alert.render()
                    }
                })
            })
        }).modal()
    },
    showStatus: function (c) {
        var d = this.collection;
        d.currentPage = 0;
        d.pager()
    },
    confirmDelete: function (c) {
        c.preventDefault();
        var d = this;
        $("#deleteComment").live("show", function () {
            $(this).find(".btn-danger").die().live("click", function () {
                d.model.destroy({
                    success: function (a, b) {
                        d.remove()
                    }
                })
            })
        }).modal()
    },
    render: function () {
        var b = _.template(this.template);
        this.$el.html(b(this.model.toJSON()));
        return this
    }
});
var CommentForm = Backbone.View.extend({
    template: $("#container-comment-add"),
    addTemplate: _.template($("#option-add-comment").html()),
    render: function () {
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this
    }
});
var CommentCollection = Backbone.Paginator.requestPager.extend({
    model: CommentModel,
    crew_id: 0,
    paginator_core: {
        type: "GET",
        dataType: "json",
        url: BASE_URL + "api/crew_comments?"
    },
    paginator_ui: {
        firstPage: 1,
        currentPage: 1,
        perPage: 5,
        sortField: "id",
        sortDir: "asc",
        searchField: null,
        searchVal: null,
        totalPages: 10
    },
    server_api: {
        crew_id: function () {
            return this.crew_id
        },
        limit: function () {
            return this.perPage
        },
        offset: function () {
            if (this.currentPage == 0) {
                this.currentPage = 1
            }
            return (this.currentPage - 1) * this.perPage
        },
        sort: function () {
            return this.sortField
        },
        order: function () {
            return this.sortDir
        },
        searchField: function () {
            return this.searchField
        },
        searchVal: function () {
            return this.searchVal
        }
    },
    parse: function (d) {
        var c = d.data;
        this.totalPages = Math.floor(d._count / this.perPage);
        this.totalRecords = d._count;
        return c
    }
});
var CommentPaginatedView = Backbone.View.extend({
    events: {
        "click a.servernext": "nextResultPage",
        "click a.serverprevious": "previousResultPage",
        "click a.orderUpdate": "updateSortBy",
        "click a.serverlast": "gotoLast",
        "click a.page": "gotoPage",
        "click a.serverfirst": "gotoFirst",
        "click a.serverpage": "gotoPage",
        "click .serverhowmany a": "changeCount"
    },
    tagName: "aside",
    template: _.template($("#tmpServerPagination").html()),
    initialize: function () {
        this.collection.on("reset", this.render, this);
        this.collection.on("change", this.render, this);
        this.$el.appendTo("#commentpagination")
    },
    render: function () {
        var b = this.template(this.collection.info());
        this.$el.html(b)
    },
    updateSortBy: function (c) {
        c.preventDefault();
        var d = $("#sortByField").val();
        this.collection.updateOrder(d)
    },
    nextResultPage: function (b) {
        b.preventDefault();
        this.collection.requestNextPage()
    },
    previousResultPage: function (b) {
        b.preventDefault();
        this.collection.requestPreviousPage()
    },
    gotoFirst: function (b) {
        b.preventDefault();
        this.collection.goTo(this.collection.information.firstPage)
    },
    gotoLast: function (b) {
        b.preventDefault();
        this.collection.goTo(this.collection.information.lastPage)
    },
    gotoPage: function (c) {
        c.preventDefault();
        var d = $(c.target).text();
        this.collection.goTo(d)
    },
    changeCount: function (c) {
        c.preventDefault();
        var d = $(c.target).text();
        this.collection.howManyPer(d)
    }
});
var LangModel = Backbone.Model.extend({
    idAttribute: "id",
    defaults: {
        firstname: "",
        lastname: "",
        photo: ""
    },
    url: function () {
        if (this.isNew()) {
            return BASE_URL + "api/language"
        } else {
            return BASE_URL + "api/language/id/" + this.get("id")
        }
    }
});
var Langcollection = Backbone.Collection.extend({
    url: function () {
        return BASE_URL + "api/crew/id/" + this.id
    },
    id: 0,
    model: LangModel
});
var LangView = Backbone.View.extend({
    el: $("#language-info"),
    initialize: function () {},
    events: {
        "click #language-btn": "saveAbout"
    },
    saveAbout: function (d) {
        var e = this;
        var f = Array;
        $.map($("input.ab").serializeArray(), function (a, b) {
            f[a.name] = a.value
        });
        options = new LangModel();
        if (this.collection) {
            options.set("id", this.collection.id)
        }
        options.save(f, {
            success: function (a, b) {
                alert = new AlertLangView({
                    type: "success",
                    message: "Record succesfully updated."
                });
                alert.render()
            },
            error: function (a, b) {
                alert = new AlertLangView({
                    type: "error",
                    message: b
                });
                alert.render()
            }
        })
    }
});
var AlertLangView = Backbone.View.extend({
    el: $("#alertlanguage-div"),
    template: $("#alertLangTemplate").html(),
    render: function () {
        var d = _.template(this.template);
        var c = Array;
        c.type = this.options.type;
        c.message = this.options.message;
        this.$el.html(d(c));
        return this
    }
});
var AssessModel = Backbone.Model.extend({
    idAttribute: "id",
    defaults: {
        firstname: "",
        lastname: "",
        photo: ""
    },
    url: function () {
        if (this.isNew()) {
            return BASE_URL + "api/assessment"
        } else {
            return BASE_URL + "api/assessment/id/" + this.get("id")
        }
    }
});
var Assesscollection = Backbone.Collection.extend({
    url: function () {
        return BASE_URL + "api/crew/id/" + this.id
    },
    id: 0,
    model: AssessModel
});
var AssessView = Backbone.View.extend({
    el: $("#assessment-info"),
    initialize: function () {},
    events: {
        "click #assessment-btn": "saveAbout"
    },
    saveAbout: function (d) {
        var e = this;
        var f = Array;
        $.map($("select.ab, textarea.ab").serializeArray(), function (a, b) {
            f[a.name] = a.value
        });
        options = new AssessModel();
        if (this.collection) {
            options.set("id", this.collection.id)
        }
        options.save(f, {
            success: function (a, b) {
                alert = new AlertAssessView({
                    type: "success",
                    message: "Record succesfully updated."
                });
                alert.render()
            },
            error: function (a, b) {
                alert = new AlertAssessView({
                    type: "error",
                    message: b
                });
                alert.render()
            }
        })
    }
});
var AlertAssessView = Backbone.View.extend({
    el: $("#alertAssess-div"),
    template: $("#alertAssessTemplate").html(),
    render: function () {
        var d = _.template(this.template);
        var c = Array;
        c.type = this.options.type;
        c.message = this.options.message;
        this.$el.html(d(c));
        return this
    }
});
var RemarksModel = Backbone.Model.extend({
    idAttribute: "id",
    url: function () {
        if (this.isNew()) {
            return BASE_URL + "api/crew_remarks"
        } else {
            return BASE_URL + "api/crew_remarks/id/" + this.get("id")
        }
    },
    defaults: {
        crew_id: 0,
        remarks: "",
        remarks_date: "0000-00-00",
        remarks_by: "",
        published: ""
    }
});
var RemarksMasterView = Backbone.View.extend({
    el: $("#remarks-info"),
    initialize: function () {
        $(".sortcolumn").css("cursor", "pointer");
        this.collection.isLoading = false;
        this.collection.on("add", this.renderremarksView, this);
        this.collection.on("add", this.renderremarksForm, this);
        this.collection.on("reset", this.render, this);
        this.collection.on("fetch", function () {
            this.collection.isLoading = true;
            $("#loader-container").html('<img src="' + BASE_URL + 'includes/img/ajax-loader.gif" />')
        }, this);
        if (this.collection.size() == 0) {
            e_model = new RemarksModel({
                remarks: "",
                remarks_date: "",
                remarks_by: "",
                published: ""
            });
            this.collection.push(e_model);
            this.$el.find(".btn-group").hide()
        }
        this.showStatus()
    },
    events: {
        "click .sortcolumn": "updateSortBy",
        "click #remarks_add-btn": "addremarks",
        "focus .jrdate": "selectdate"
    },
    addremarks: function (c) {
        c.preventDefault();
        var d = this;
        $("#addremarks").live("show", function () {
            $(this).find(".btn-success").die().live("click", function () {
                var a = Array;
                $.map($(".inopts input, .inopts textarea").serializeArray(), function (b, f) {
                    a[b.name] = b.value
                });
                options = new RemarksModel();
                options.save(a, {
                    success: function (b, f) {
                        this.$el = $("#addremarks");
                        this.$el.modal("hide");
                        d.showStatus();
                        alert = new Alert5rView({
                            type: "success",
                            message: "New record successfully added."
                        });
                        alert.render()
                    },
                    error: function (b, f) {
                        alert = new Alert5rView({
                            type: "error",
                            message: f
                        });
                        alert.render()
                    }
                })
            })
        }).modal()
    },
    updateSortBy: function (b) {
        if (this.collection.sortDir == "desc") {
            dir = "asc"
        } else {
            dir = "desc"
        }
        this.collection.sortDir = String(dir);
        this.collection.updateOrder($(b.target).attr("col"))
    },
    showStatus: function (c) {
        var d = this.collection;
        d.currentPage = 0;
        d.pager()
    },
    selectdate: function () {
        $(".jrdate").datepicker({
            yearRange: "-80y:y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip"
        })
    },
    render: function () {
        var b = this;
        this.collection.isLoading = false;
        if (this.collection.size() != 0) {
            $("#options-table-remarks tbody").empty()
        }
        this.collection.each(this.renderremarksView, this);
        this.collection.each(this.renderremarksForm, this)
    },
    renderremarksView: function (c) {
        var d = new RemarksView({
            model: c,
            collection: this.collection
        });
        $("#options-table-remarks tbody").append(d.render().el)
    },
    renderremarksForm: function (d) {
        var c = new RemarksForm({
            model: d
        });
        $("#container-remarks-add").append(c.render().el)
    }
});
var Alert5rView = Backbone.View.extend({
    el: $("#alert5r-div"),
    template: $("#alert5rTemplate").html(),
    render: function () {
        var d = _.template(this.template);
        var c = Array;
        c.type = this.options.type;
        c.message = this.options.message;
        this.$el.html(d(c));
        return this
    }
});
var RemarksView = Backbone.View.extend({
    tagName: "tr",
    template: $("#remarks-list-item").html(),
    editTemplate: _.template($("#option-edit-remarks").html()),
    events: {
        "click .record-delete": "confirmDelete",
        "click .record-edit": "editremarks"
    },
    editremarks: function (c) {
        c.preventDefault();
        this.$el = $("#container-remarks-edit");
        var d = this;
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));
        $("#editremarks").live("show", function () {
            $(this).find(".btn-primary").die().live("click", function () {
                var a = Array;
                $.map($(".inopts input, .inopts textarea").serializeArray(), function (b, f) {
                    a[b.name] = b.value
                });
                d.model.save(a, {
                    success: function (b, f) {
                        d.showStatus();
                        this.$el = $("#editremarks");
                        this.$el.modal("hide");
                        alert = new Alert5rView({
                            type: "success",
                            message: "Record successfully updated"
                        });
                        alert.render()
                    },
                    error: function (b, f) {
                        alert = new Alert5rView({
                            type: "error",
                            message: f
                        });
                        alert.render()
                    }
                })
            })
        }).modal()
    },
    showStatus: function (c) {
        var d = this.collection;
        d.currentPage = 0;
        d.pager()
    },
    confirmDelete: function (c) {
        c.preventDefault();
        var d = this;
        $("#deleteremarks").live("show", function () {
            $(this).find(".btn-danger").die().live("click", function () {
                d.model.destroy({
                    success: function (a, b) {
                        d.remove()
                    }
                })
            })
        }).modal()
    },
    render: function () {
        var b = _.template(this.template);
        this.$el.html(b(this.model.toJSON()));
        return this
    }
});
var RemarksForm = Backbone.View.extend({
    template: $("#container-remarks-add"),
    addTemplate: _.template($("#option-add-remarks").html()),
    render: function () {
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this
    }
});
var RemarksCollection = Backbone.Paginator.requestPager.extend({
    model: RemarksModel,
    crew_id: 0,
    paginator_core: {
        type: "GET",
        dataType: "json",
        url: BASE_URL + "api/crew_remarkss?"
    },
    paginator_ui: {
        firstPage: 1,
        currentPage: 1,
        perPage: 5,
        sortField: "id",
        sortDir: "asc",
        searchField: null,
        searchVal: null,
        totalPages: 10
    },
    server_api: {
        crew_id: function () {
            return this.crew_id
        },
        limit: function () {
            return this.perPage
        },
        offset: function () {
            if (this.currentPage == 0) {
                this.currentPage = 1
            }
            return (this.currentPage - 1) * this.perPage
        },
        sort: function () {
            return this.sortField
        },
        order: function () {
            return this.sortDir
        },
        searchField: function () {
            return this.searchField
        },
        searchVal: function () {
            return this.searchVal
        }
    },
    parse: function (d) {
        var c = d.data;
        this.totalPages = Math.floor(d._count / this.perPage);
        this.totalRecords = d._count;
        return c
    }
});
var RemarksPaginatedView = Backbone.View.extend({
    events: {
        "click a.servernext": "nextResultPage",
        "click a.serverprevious": "previousResultPage",
        "click a.orderUpdate": "updateSortBy",
        "click a.serverlast": "gotoLast",
        "click a.page": "gotoPage",
        "click a.serverfirst": "gotoFirst",
        "click a.serverpage": "gotoPage",
        "click .serverhowmany a": "changeCount"
    },
    tagName: "aside",
    template: _.template($("#tmpServerPagination").html()),
    initialize: function () {
        this.collection.on("reset", this.render, this);
        this.collection.on("change", this.render, this);
        this.$el.appendTo("#remarkspagination")
    },
    render: function () {
        var b = this.template(this.collection.info());
        this.$el.html(b)
    },
    updateSortBy: function (c) {
        c.preventDefault();
        var d = $("#sortByField").val();
        this.collection.updateOrder(d)
    },
    nextResultPage: function (b) {
        b.preventDefault();
        this.collection.requestNextPage()
    },
    previousResultPage: function (b) {
        b.preventDefault();
        this.collection.requestPreviousPage()
    },
    gotoFirst: function (b) {
        b.preventDefault();
        this.collection.goTo(this.collection.information.firstPage)
    },
    gotoLast: function (b) {
        b.preventDefault();
        this.collection.goTo(this.collection.information.lastPage)
    },
    gotoPage: function (c) {
        c.preventDefault();
        var d = $(c.target).text();
        this.collection.goTo(d)
    },
    changeCount: function (c) {
        c.preventDefault();
        var d = $(c.target).text();
        this.collection.howManyPer(d)
    }
});