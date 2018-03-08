$(function() {
    var address_sub_fields = {
        "addr1": "Street Address",
        "addr2": "Address Line 2",
        "city": "City",
        "state": "State/Prov/Region",
        "zip": "Postal/Zip",
        "country": "Country"
    };
    $('[name="save"],[name="cancel"]').prop('disabled', true);
    app.alert.dismissAll();
    app.alert.show('loading-lists-in-progress', {
        level: 'process',
        title: 'Loading'
    });
    var params = {
        'type': 'mailchimp-lists'
    };
    var lists_options = modules_options = '';
    var callback = {
        success: function(data) {
            if(!_.isUndefined(data)) {
                if(!_.isUndefined(data.lists) && _.isArray(data.lists) && data.lists.length > 0) {
                    _.each(data.lists, function(list) {
                        lists_options += '<option value="'+list.id+'">'+list.name+'</option>';
                    });
                }
                if(!_.isUndefined(data.modules) && _.isObject(data.modules)) {
                    _.each(data.modules, function(value, key) {
                        modules_options += '<option value="'+key+'">'+value+'</option>';
                    });
                }
            }
            $('#sync_mailchimp_list').html(lists_options);
            $('#sync_module').html(modules_options);
        },
        error: function(error) {
            app.alert.show('loading-lists-status', {
                level: 'error',
                messages: app.lang.get('LBL_AN_ERROR_OCCURRED_DETAILS', 'Administration') + error,
                autoClose: false
            });
        },
        complete: function() {
            $('[name="save"],[name="cancel"]').prop('disabled', false);
            app.alert.dismiss('loading-lists-in-progress');
        }
    }
    app.api.call('create', app.api.buildURL('mailchimp'), params, callback);

    $('#mailChimpFieldsMapping').on('submit', function(e) {
        e.preventDefault();
        if(!_.isEmpty($('#sync_mailchimp_list').val())) {
            app.alert.dismissAll();
            app.alert.show('save-field-mapping-in-progress', {
                level: 'process',
                title: 'Loading'
            });
            $('[name="save"],[name="cancel"]').prop('disabled', true);
            var form_data = {};
            _.each($(this).serializeArray(), function(v) {
                var names = v.name.split("[");
                if(!_.isUndefined(names[1])) {
                    n = names[1].substr(0, names[1].length-1);
                    v = v.value;
                    switch(names[0]){
                        case 'leads':
                            if(!_.isObject(form_data.leads)){
                                form_data.leads = {};
                            }
                            form_data.leads[n] = v;
                        break;
                        case 'contacts':
                            if(!_.isObject(form_data.contacts)){
                                form_data.contacts = {};
                            }
                            form_data.contacts[n] = v;
                        break;
                        case 'prospects':
                            if(!_.isObject(form_data.prospects)){
                                form_data.prospects = {};
                            }
                            form_data.prospects[n] = v;
                        break;
                    }
                } else {
                    form_data[v.name] = v.value;
                }
            });
            var url = app.api.buildURL('mailchimpAdmin');
            var params = _.extend(form_data, {'action': 'save-fields-mapping'});
            var callback = {
                success: function(response) {
                    app.alert.show('save-field-mapping-status', {
                        level: 'success',
                        messages: app.lang.get('LBL_SUCCESS_FIELDS_SAVING', 'Administration'),
                        autoClose: true
                    });
                },
                error: function(error) {
                    app.alert.show('save-field-mapping-status', {
                        level: 'error',
                        messages: app.lang.get('LBL_ERROR_FIELDS_SAVING', 'Administration'),
                        autoClose: false
                    });
                },
                complete: function() {
                    $('[name="save"],[name="cancel"]').prop('disabled', false);
                    app.alert.dismiss('save-field-mapping-in-progress');
                }
            }
            app.api.call('create', url, params, callback);
        }
    });

    $('#sync_mailchimp_list').on('change', function() {
        if(_.isEmpty($(this).val())){
            var email_address_label = app.lang.get('LBL_FIELDS_EMAIL_ADDRESS_LOWER', 'Administration');
            var rows = '<tr><td>'+app.lang.get('LBL_FIELDS_EMAIL_ADDRESS', 'Administration')+'</td><td style="font-style: italic;">'+email_address_label+'</td><td style="font-style: italic;">'+email_address_label+'</td><td style="font-style: italic;">'+email_address_label+'</td></tr>';
            $('#module_fields').html(rows);
            $('#sync_module').val('');
        } else {
            $('#mailchimp_list_name').val($(this).find(':selected').text());
            $('[name="save"],[name="cancel"]').prop('disabled', true);
            app.alert.dismissAll();
            app.alert.show('get-field-mapping-in-progress', {
                level: 'process',
                title: 'Loading'
            });
            var url = app.api.buildURL('mailchimpAdmin');
            var params = {
                'action': 'get-fields-mapping',
                'mailchimp_list_id': $(this).val()
            };
            var callback = {
                success: function(data) {
                    var mailchimp = data.mailchimp;
                    var contacts = data.contacts;
                    var leads = data.leads;
                    var prospects = data.prospects;
                    var old = data.old;

                    var email_address_label = app.lang.get('LBL_FIELDS_EMAIL_ADDRESS_LOWER', 'Administration');
                    var rows = '<tr><td>'+app.lang.get('LBL_FIELDS_EMAIL_ADDRESS', 'Administration')+'</td><td style="font-style: italic;">'+email_address_label+'</td><td style="font-style: italic;">'+email_address_label+'</td><td style="font-style: italic;">'+email_address_label+'</td></tr>';
            
                    _.each(mailchimp, function(list) {
                        rows += '<tr>';
                        _.each(list, function(value, key) {
                            rows += '<td>';
                            var label = value.split('.');
                            var name = key.split('.');
                            if(label.length === 2 && name.length === 2 && _.has(address_sub_fields, label[1])) {
                                rows += label[0] + ' ('+name[0] + '.' + address_sub_fields[name[1]] +')';
                            } else {
                                rows += value + ' ('+key+')';
                            }
                            rows += '</td>';
                            rows += '<td>';
                            rows += '<select name="contacts['+key+']" id="contacts_'+key+'">';
                            _.each(contacts, function(contact, ci) {
                                if(!_.isUndefined(old) && !_.isUndefined(old.contacts) && !_.isUndefined(old.contacts[key]) && old.contacts[key] == ci) {
                                    rows += '<option value="'+ci+'" selected="selected">'+contact+'</option>';
                                } else {
                                    rows += '<option value="'+ci+'">'+contact+'</option>';
                                }
                            });
                            rows += '</select></td>';

                            rows += '<td>';
                            rows += '<select name="leads['+key+']" id="leads_'+key+'">';
                            _.each(leads, function(lead, li) {
                                if(!_.isUndefined(old) && !_.isUndefined(old.leads) && !_.isUndefined(old.leads[key]) && old.leads[key] == li) {
                                    rows += '<option value="'+li+'" selected="selected">'+lead+'</option>';
                                } else {
                                    rows += '<option value="'+li+'">'+lead+'</option>';
                                }
                            });
                            rows += '</select></td>';

                            rows += '<td>';
                            rows += '<select name="prospects['+key+']" id="prospects_'+key+'">';
                            _.each(prospects, function(prospect, pi) {
                                if(!_.isUndefined(old) && !_.isUndefined(old.prospects) && !_.isUndefined(old.prospects[key]) && old.prospects[key] == pi) {
                                    rows += '<option value="'+pi+'" selected="selected">'+prospect+'</option>';
                                } else {
                                    rows += '<option value="'+pi+'">'+prospect+'</option>';
                                }
                            });
                            rows += '</select></td>';
                        });
                        rows += '</tr>';
                    });
                    
                    $('#module_fields').html(rows);
                    
                    if(!_.isUndefined(old) && !_.isUndefined(old.sync_module) && !_.isEmpty(old.sync_module)) {
                        $('#sync_module').val(old.sync_module);
                    } else {
                        $('#sync_module').val('');
                    }
                },
                error: function(error) {
                    app.alert.show('get-field-mapping-status', {
                        level: 'error',
                        messages: app.lang.get('LBL_ERROR_FIELDS_GETTING', 'Administration'),
                        autoClose: false
                    });
                },
                complete: function() {
                    $('[name="save"],[name="cancel"]').prop('disabled', false);
                    app.alert.dismiss('get-field-mapping-in-progress');
                }
            }
            app.api.call('create', url, params, callback);
        }
    });
});
