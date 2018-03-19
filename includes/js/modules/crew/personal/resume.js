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
        child_telephone:"",
        relationship:""
    }
});
var ChildMasterView = Backbone.View.extend({
    el: $("#children-info"),
    initialize: function () {
        $(".sortcolumn").css("cursor", "pointer");
        this.collection.isLoading = false;
        this.collection.on("add", this.renderChildView, this);
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
                child_telephone:"",
                relationship: ""
            });
            this.collection.push(e_model);
            this.$el.find(".btn-group").hide()
        }
        this.showStatus()
    },
    events: {
        "click .sortcolumn": "updateSortBy"
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
            $("#options-table-child tbody").empty()
        }
        this.collection.each(this.renderChildView, this)
    },
    renderChildView: function (c) {
        var d = new ChildView({
            model: c,
            collection: this.collection
        });
        $("#options-table-child tbody").append(d.render().el)
    }
});
var ChildView = Backbone.View.extend({
    tagName: "tr",
    template: $("#child-list-item").html(),
    render: function () {
        var b = _.template(this.template);
        this.$el.html(b(this.model.toJSON()));
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
                encoding_modified: "",
                uploading_modified: "",
                capacity: ""
            });
            this.collection.push(e_model);
            this.$el.find(".btn-group").hide();
            this.$el.find("input, select").hide()
        }
        this.showStatus()
    },
    events: {
        "click .sortcolumn": "updateSortBy"
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
            $("#options-table-docs tbody").empty()
        }
        this.collection.each(this.renderDocsView, this)
    },
    renderDocsView: function (c) {
        var d = new DocsView({
            model: c,
            collection: this.collection
        });
        $("#options-table-docs tbody").append(d.render().el)
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
        encoding_modified: "",
        uploading_modified: "",
        endorsement: "",
        capacity: "",
        remarks: "",
        published: 0
    }
});
var DocsView = Backbone.View.extend({
    tagName: "tr",
    template: $("#docs-list-item").html(),
    days_between: function (e, d) {
        var d = new Date(d);
        var f = 1000 * 60 * 60 * 24;
        var c = e.getTime();
        var b = d.getTime();
        if (b >= c) {
            var a = Math.abs(b - c)
        } else {
            var a = -Math.abs(b - c)
        }
        return Math.round(a / f)
    },
    render: function () {
        var c = new Date();
        var d = this.model.get("date_expired");
        var b = this.model.get("date_issued");
        // var e = this.model.get("encoding_modified");
        // var f = this.model.get("uploading_modified");

        this.model.set("date_issued", (b === "0000-00-00" || b === "1970-01-01" ) ? "" : b);
        this.model.set("date_expired", (d === "0000-00-00" || d === "1970-01-01" ) ? "" : d);
        // this.model.set("encoding_modified", (e === "0000-00-00" || e === "1970-01-01" ) ? "" : e);
        // this.model.set("uploading_modified", (f === "0000-00-00" || f === "1970-01-01" ) ? "" : f);
        if (this.days_between(c, d) <= 90) {        	
            if(d === '0000-00-00' || d === '1970-01-01') {

            } else {
                this.model.set("date_expired", "<strong class='alert-expire'>" + d + "</strong>");
            }
    		
        }
        var a = _.template(this.template);
        this.$el.html(a(this.model.toJSON()));
        return this
    }
});
var DocsCollection = Backbone.Paginator.requestPager.extend({
    model: DocsModel,
    crew_id: 0,
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
        searchField: "",
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
    parse: function (d) {
        var c = d.data;
        this.totalPages = Math.floor(d._count / this.perPage);
        this.totalRecords = d._count;
        return c
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
var EducMasterView = Backbone.View.extend({
    el: $("#education-info"),
    initialize: function () {
        $(".sortcolumn").css("cursor", "pointer");
        this.collection.isLoading = false;
        this.collection.on("add", this.renderEducView, this);
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
                vocational: "",
                qualification: ""
            });
            this.collection.push(e_model);
            this.$el.find(".btn-group").hide()
        }
        this.showStatus()
    },
    events: {
        "click .sortcolumn": "updateSortBy"
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
        this.collection.each(this.renderEducView, this)
    },
    renderEducView: function (c) {
        var d = new EducView({
            model: c,
            collection: this.collection
        });
        $("#options-table-educs tbody").append(d.render().el)
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
var EducView = Backbone.View.extend({
    tagName: "tr",
    template: $("#emp-list-item").html(),
    render: function () {
        var b = _.template(this.template);
        this.$el.html(b(this.model.toJSON()));
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
            return BASE_URL + "api/crew_work_history"
        } else {
            return BASE_URL + "api/crew_work_history/id/" + this.get("id")
        }
    },
    defaults: {
        vessel_id: 0,
        crew_id: 0,
        company: "",
        vessel: "",
        rank: "",
        grt: "",
        TYPE: "",
        ENGINE: "",
        trade: "",
        embarked: "0000-00-00",
        disembarked: "0000-00-00",
        remarks: "",
        isdone: 0
    }
});
var WorksMasterView = Backbone.View.extend({
    el: $("#works-info"),
    initialize: function () {
        $(".sortcolumn").css("cursor", "pointer");
        this.collection.isLoading = false;
        this.collection.on("add", this.renderWorksView, this);
        this.collection.on("reset", this.render, this);
        this.collection.on("fetch", function () {
            this.collection.isLoading = true;
            $("#loader-container").html('<img src="' + BASE_URL + 'includes/img/ajax-loader.gif" />')
        }, this);
        if (this.collection.size() == 0) {
            e_model = new WorksModel({
                vessel_id: 0,
                company: "",
                vessel: "",
                rank: "",
                grt: "",
                TYPE: "",
                ENGINE: "",
                trade: "",
                embarked: "",
                disembarked: "",
                remarks: "",
                isdone: 0
            });
            this.collection.push(e_model);
            this.$el.find(".btn-group").hide()
        }
        this.showStatus()
    },
    events: {
        "click .sortcolumn": "updateSortBy"
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
            $("#options-table-works tbody").empty()
        }
        this.collection.each(this.renderWorksView, this)
    },
    renderWorksView: function (b) {
        var a = new WorksView({
            model: b,
            collection: this.collection
        });
        $("#options-table-works tbody").append(a.render().el)
    }
});
var WorksView = Backbone.View.extend({
    tagName: "tr",
    template: $("#works-list-item").html(),
    render: function () {
        var a = _.template(this.template);
        this.$el.html(a(this.model.toJSON()));
        return this
    }
});
var WorksCollection = Backbone.Paginator.requestPager.extend({
    model: WorksModel,
    crew_id: 0,
    paginator_core: {
        type: "GET",
        dataType: "json",
        url: BASE_URL + "api/crew_work_historys?"
    },
    paginator_ui: {
        firstPage: 1,
        currentPage: 1,
        perPage: 50,
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
    parse: function (a) {
        var b = a.data;
        this.totalPages = Math.floor(a._count / this.perPage);
        this.totalRecords = a._count;
        return b
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
        "click .sortcolumn": "updateSortBy"
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
            $("#options-table-remarks tbody").empty()
        }
        this.collection.each(this.renderremarksView, this)
    },
    renderremarksView: function (c) {
        var d = new RemarksView({
            model: c,
            collection: this.collection
        });
        $("#options-table-remarks tbody").append(d.render().el)
    }
});
var RemarksView = Backbone.View.extend({
    tagName: "tr",
    template: $("#remarks-list-item").html(),
    render: function () {
        var b = _.template(this.template);
        this.$el.html(b(this.model.toJSON()));
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

var RegModel = Backbone.Model.extend({
    idAttribute: 'id',
    defaults: {
        firstname   : '',
        lastname    : '',
        photo       : '',
    },
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/crew'; 
        } else {
            return BASE_URL + 'api/crew/id/' + this.get('id'); 
        }
    },
    validate: function (attrs) {
        // if (attrs.lastname == '') {
        //     return 'This field must not be left blank.';
        // }
    }
});

var Regcollection = Backbone.Collection.extend({    
    url: function () {
        return BASE_URL + 'api/crew/id/' + this.id;
    },
    id: 0,
    model: RegModel
}); 

var PersonalView = Backbone.View.extend({
    el: $('#personal-info'),
    initialize: function () {    
        this.collection.on('add', this.renderPersonalForm, this);
        this.collection.on('reset', this.render, this);    
        if(this.collection.size() == 0){
            e_model = new RegModel({remarks: ''});
            this.collection.push(e_model);
        }
    },
    events: {
        "click .btn-checklist": "viewChecklist",
        "focus .idate": "entryDate",
    }, 
    viewChecklist: function (e) {

        var that = this;
        var d = Array;
		
		$('#addGenerate').live('show', function () {            
        })
        .modal();              
    },
    render: function () {        
        var that = this;        
        this.collection.each(this.renderPersonalForm, this);   
    },   
    renderPersonalForm: function (item) {
        var personalForm = new PersonalForm({
            model: item
        });
        $('#container-personal-add').append(personalForm.render().el);
    },
    entryDate: function() {
        $('.idate').datepicker({
            yearRange: "-10y:+5y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" 
        });
    } 
});

var PersonalForm = Backbone.View.extend({
    template: $('#container-personal-add'),
    addTemplate: _.template($("#personal-add-template").html()),
    render: function () { 
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this;
    }
});
