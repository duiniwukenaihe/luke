$(function() {
    var account_types = lists = null, url = app.api.buildURL('mailchimpAdmin');
    $('[name="save"],[name="cancel"]').prop('disabled', true);
    app.alert.dismissAll();
    app.alert.show('get-module-mapping-in-progress', {
        level: 'process',
        title: 'Loading'
    });
    var params = {
        'action': 'get-modules-mapping',
        'mailchimp_list_id': $(this).val()
    };
    var callback = {
        success: function(data) {
            account_types = data.account_types;
            lists = data.lists;
            var admins = data.admins;
            var old = data.old;

            var admins_options = '';
            _.each(admins, function(name, id) {
                if(!_.isUndefined(old) && !_.isUndefined(old.user_id) && id === old.user_id) {
                    admins_options += '<option value="'+id+'" selected="selected">'+name+'</option>';
                } else {
                    admins_options += '<option value="'+id+'">'+name+'</option>';
                }
            });
            $('#user_id').html(admins_options);

            var leads_list_options = '';
            _.each(lists, function(name, id) {
                if(!_.isUndefined(old) && !_.isUndefined(old.Leads) && id === old.Leads) {
                    leads_list_options += '<option value="'+id+'" selected="selected">'+name+'</option>';
                } else {
                    leads_list_options += '<option value="'+id+'">'+name+'</option>';
                }
            });
            $('#Leads').html(leads_list_options);

            var contacts_lists_data = '';
            if(!_.isUndefined(old) && !_.isUndefined(old.Contacts) && !_.isEmpty(old.Contacts) && _.isObject(old.Contacts)) {
                _.each(old.Contacts, function(old_lists, type) {
                    _.each(old_lists, function(list) {
                        contacts_lists_data += '<tr class="contacts-list-row">';
                        contacts_lists_data += '<td>';
                        contacts_lists_data += '<label>'+app.lang.get('LBL_SELECT_ACCOUNT_TYPE', 'Administration')+'</label>';
                        contacts_lists_data += '<select name="account_type[]">';
                        _.each(account_types, function(value, key) {
                            if(!_.isUndefined(type) && key === type) {
                                contacts_lists_data += '<option value="'+key+'" selected="selected">'+value+'</option>';
                            } else {
                                contacts_lists_data += '<option value="'+key+'">'+value+'</option>';
                            }
                        });
                        contacts_lists_data += '</select>';
                        contacts_lists_data += '</td>';
                        contacts_lists_data += '<td>';
                        contacts_lists_data += '<label>'+app.lang.get('LBL_SELECT_TARGET_LIST_FOR_CONTACTS', 'Administration')+'</label>';
                        contacts_lists_data += '<select name="Contacts[]">';
                        _.each(lists, function(name, id) {
                            if(!_.isUndefined(list) && id === list) {
                                contacts_lists_data += '<option value="'+id+'" selected="selected">'+name+'</option>';
                            } else {
                                contacts_lists_data += '<option value="'+id+'">'+name+'</option>';
                            }
                        });
                        contacts_lists_data += '</select>';
                        contacts_lists_data += '</td>';
                        contacts_lists_data += '<td style="font-size:30px;font-weight:bold;"><span id="remove_row">-</span></td>';
                        contacts_lists_data += '</tr>';
                    });
                });
            } else {
                contacts_lists_data += '<tr class="contacts-list-row">';
                contacts_lists_data += '<td>';
                contacts_lists_data += '<label>'+app.lang.get('LBL_SELECT_ACCOUNT_TYPE', 'Administration')+'</label>';
                contacts_lists_data += '<select name="account_type[]">';
                _.each(account_types, function(value, key) {
                    contacts_lists_data += '<option value="'+key+'">'+value+'</option>';
                });
                contacts_lists_data += '</select>';
                contacts_lists_data += '</td>';
                contacts_lists_data += '<td>';
                contacts_lists_data += '<label>'+app.lang.get('LBL_SELECT_TARGET_LIST_FOR_CONTACTS', 'Administration')+'</label>';
                contacts_lists_data += '<select name="Contacts[]">';
                _.each(lists, function(name, id) {
                    contacts_lists_data += '<option value="'+id+'">'+name+'</option>';
                });
                contacts_lists_data += '</select>';
                contacts_lists_data += '</td>';
                contacts_lists_data += '<td style="font-size:30px;font-weight:bold;"><span id="remove_row">-</span></td>';
                contacts_lists_data += '</tr>';
            }
            $('#Contacts').html(contacts_lists_data);
        },
        error: function(error) {
            app.alert.show('get-module-mapping-status', {
                level: 'error',
                messages: 'An error occurred, while getting modules mapping.',
                autoClose: false
            });
        },
        complete: function() {
            $('[name="save"],[name="cancel"]').prop('disabled', false);
            app.alert.dismiss('get-module-mapping-in-progress');
        }
    }
    app.api.call('create', url, params, callback);

    $('#remove_row').live('click', function() {
        $(this).closest('.contacts-list-row').remove();
    });

    $('#add_more').live('click', function() {
        var contacts_lists_data = '<tr class="contacts-list-row">';
        contacts_lists_data += '<td>';
        contacts_lists_data += '<label>'+app.lang.get('LBL_SELECT_ACCOUNT_TYPE', 'Administration')+'</label>';
        contacts_lists_data += '<select name="account_type[]">';
        _.each(account_types, function(value, key) {
            contacts_lists_data += '<option value="'+key+'">'+value+'</option>';
        });
        contacts_lists_data += '</select>';
        contacts_lists_data += '</td>';
        contacts_lists_data += '<td>';
        contacts_lists_data += '<label>'+app.lang.get('LBL_SELECT_TARGET_LIST_FOR_CONTACTS', 'Administration')+'</label>';
        contacts_lists_data += '<select name="Contacts[]">';
        _.each(lists, function(name, id) {
            contacts_lists_data += '<option value="'+id+'">'+name+'</option>';
        });
        contacts_lists_data += '</select>';
        contacts_lists_data += '</td>';
        contacts_lists_data += '<td style="font-size:30px;font-weight:bold;"><span id="remove_row">-</span></td>';
        contacts_lists_data += '</tr>';
        $('#Contacts').append(contacts_lists_data);
    });

    $('#mailChimpModulesMapping').on('submit', function(e) {
        e.preventDefault();
        app.alert.dismissAll();
        app.alert.show('save-module-mapping-in-progress', {
            level: 'process',
            title: 'Loading'
        });
        $('[name="save"],[name="cancel"]').prop('disabled', true);
        var form_data = {};
        if(!_.isObject(form_data.Contacts)){
            form_data.Contacts = {};
        }
        var type_value = null;
        _.each($(this).serializeArray(), function(v) {
            var names = v.name.split("[");
            if(!_.isUndefined(names[1])) {
                n = names[0];
                v = v.value;
                if(n == 'account_type') {
                    type_value = v;
                    if(!_.isArray(form_data.Contacts[type_value])){
                        form_data.Contacts[type_value] = [];
                    }
                } else if(n == 'Contacts') {
                    form_data.Contacts[type_value].push(v);
                }
            } else {
                form_data[v.name] = v.value;
            }
        });
        var params = _.extend(form_data, {'action': 'save-modules-mapping'});
        var callback = {
            success: function(data) {
                app.alert.show('save-module-mapping-status', {
                    level: 'success',
                    messages: app.lang.get('LBL_SUCCESS_MODULE_SAVING', 'Administration'),
                    autoClose: true
                });
            },
            error: function(error) {
                app.alert.show('save-module-mapping-status', {
                    level: 'error',
                    messages: app.lang.get('LBL_ERROR_MODULE_SAVING', 'Administration'),
                    autoClose: false
                });
            },
            complete: function() {
                $('[name="save"],[name="cancel"]').prop('disabled', false);
                app.alert.dismiss('save-module-mapping-in-progress');
            }
        }
        app.api.call('create', url, params, callback);
    });
});
