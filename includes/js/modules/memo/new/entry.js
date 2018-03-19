
// --------------------------------------------------------------------
// Relational
var MemoModel = Backbone.Model.extend({
    idAttribute: 'id',
    url: function () {
        if (this.isNew()) {
             return BASE_URL + 'api/memo'; 
        } else {
            return BASE_URL + 'api/memo/id/' + this.get('id'); 
        }
    },  
    defaults: {
        title           : 0,
        type            : '',
        description     : '',
        file_docs       : ''
    }
});

var UserModel = Backbone.Model.extend({
    idAttribute: 'id',
    defaults: {
        user_id     : 0,
        memo_id     : 0
    },
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/memo_user'; 
        } else {
            return BASE_URL + 'api/memo_user/id/' + this.get('id'); 
        }
    }
});

var MemoCollection = Backbone.Collection.extend({    
    url: function () {
        return BASE_URL + 'api/memo/id/' + this.id;
    },
    id: 0,
    model: MemoModel
}); 

var MemoMasterView = Backbone.View.extend({
    el: $("#download-module"),  
    events: {
        "click #save-btn": "saveAbout",
        'change input[type!="radio"], input[type!="file"], select': 'change',
        "change #userfile" : "fileselect"
    },
    change: function (e) {
        change = {};
        change[$(e.target).attr('name')] = $(e.target).val();               
        this.model.set(change, {silent:true});
    },
    fileselect: function (e) {
        $('#filename').text($('#userfile').val());
    },
    saveAbout: function (e) {
        e.preventDefault();
        var d = Array;
        var that = this;
        $.map($('.ab input[type="text"], .ab input[type="hidden"], .ab select').serializeArray(), function(n, i) {
            d[n['name']] = n['value'];
        });  

        d['description'] = tinymce.get('elm1').getContent();

        options = new MemoModel();

        if(this.collection) options.set('id', this.collection.id);

        options.save(d, {
            success: function (model, response) {
                if($('#userfile').val() != '') {                   
                    $.ajaxFileUpload({
                        url             : BASE_URL + 'upload/upload_files', 
                        secureuri       : false,
                        fileElementId   :'userfile',
                        dataType        : 'json',
                        data            : {
                            //'title'           : $('#title').val()
                        },
                        success  : function (data, status) {
                            var label = 'label-important';
                            if(data.status != 'error') {  
                                options.set('id', response['id']);                             
                                options.set('file_docs', data.name).save();
                                label = 'label-success';
                            } 
                        }
                    });
                } 

                options2 = new UserModel();
                options2.set('memo_id', response['id']); 

                var msg = 'New record successfully added.';
                if(options.id) {
                    msg = 'Record successfully updated.';

                    options2.set('id', response['id']); 
                    options2.destroy();
                }

                var d = Array;
                $.map($('.ab input[type="checkbox"]').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];

                    options2.set('user_id', n['value']).save();
                }); 

                $(".ab input, .ab select").find('input:text').val('');

                alert = new AlertView({type: 'success', message: msg});
                alert.render();                
            },
            error: function (model, response) {
                alert = new AlertView({type: 'error', message: response});
                alert.render();
            }
        });
    },
    selectdate: function() {
        $('.jrdate').datepicker({
            yearRange: "-80y:+10y",
            changeMonth: true,
            changeYear: true,
            showAnim: "clip" 
        });
    }
});

var AlertView = Backbone.View.extend({
    el: $('#alert0-div'),    
    template: $('#alert0Template').html(),
    render: function () {
        var tmpl = _.template(this.template);
        var p = Array;
        p['type'] = this.options.type;
        p['message'] = this.options.message;
        this.$el.html(tmpl(p));

        return this;
    }
});