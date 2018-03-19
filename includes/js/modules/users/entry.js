var RegModel = Backbone.Model.extend({
    idAttribute: 'id',
    defaults: {
        firstname   : '',
        lastname    : '',
        photo       : '',
    },
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/user'; 
        } else {
            return BASE_URL + 'api/user/id/' + this.get('id'); 
        }
    },
    validate: function (attrs) {
        // if (attrs.lastname == '') {
        //     return 'This field must not be left blank.';
        // }
    }
});

var Reg2Model = Backbone.Model.extend({
    idAttribute: 'id',
    defaults: {
        password   : '',
    },
    url: function () {
        return BASE_URL + 'api/user_pass/id/' + this.get('id'); 
    }
});

var Regcollection = Backbone.Collection.extend({    
    url: function () {
        return BASE_URL + 'api/user/id/' + this.id;
    },
    id: 0,
    model: RegModel
}); 

var AboutView = Backbone.View.extend({
    el: $('#user-module'),
    events: {
        "click #submit-btn": "saveAbout",
        "click .change-password": "changePassword",
    },
    changePassword: function(e) {
        e.preventDefault();
        var that = this;
        var d = Array;
        $('#changePass').live('show', function () {
            $(this).find('#change-pass').die().live('click', function () { 
                d['password'] = $('#inputpassword').val();

                options = new Reg2Model();

                if(that.collection) {
                    options.set('id', that.collection.id);
                }

                options.save(d, {
                    success: function (model, response) {                        
                        this.$el = $('#changePass');
                        this.$el.modal('hide');
                        alert = new AlertView({type: 'success', message: 'Record succesfully updated.'}); 
                        alert.render();                    
                    },
                    error: function (model, response) {
                        alert = new AlertView({type: 'error', message: response['message']});
                        alert.render();
                    }  
                });
            });
        })
        .modal();
    },
    saveAbout: function (e) {
        e.preventDefault();
        var that = this;
        var d = Array;

        $("#form-modal").validationEngine(); 

        if($('#form-modal').validationEngine('validate')){

            $.map($('.inopts input, .inopts select, .inopts hidden').serializeArray(), function(n, i) {
                d[n['name']] = n['value'];
            });

            options = new RegModel();

            if(this.collection) {
                options.set('id', this.collection.id);
            }

            options.save(d, {
                success: function (model, response) {
                    if(response['status'] == 'success'){
                        if(response['mode'] === 'post'){
                            alert = new AlertView({type: 'success', message: 'New record succesfully save.'});
                        } else if(response['mode'] === 'put') {
                            alert = new AlertView({type: 'success', message: 'Record succesfully updated.'});
                        } 
                    } else {
                        alert = new AlertView({type: 'error', message: response['message']});  
                    }   
                    alert.render();                    
                },
                error: function (model, response) {
                    alert = new AlertView({type: 'error', message: response['message']});
                    alert.render();
                }  
            });
        }        
    }
});

var AlertView = Backbone.View.extend({
    el: $('#alert-div'),    
    template: $('#alertTemplate').html(),
    render: function () {
        var tmpl = _.template(this.template);
        var p = Array;
        p['type'] = this.options.type;
        p['message'] = this.options.message;
        this.$el.html(tmpl(p));

        return this;
    }
});