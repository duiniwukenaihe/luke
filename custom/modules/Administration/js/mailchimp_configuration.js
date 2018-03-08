$(function() {
    var url = app.api.buildURL('mailchimpAdmin');
    app.alert.dismissAll();
    app.alert.show('get-api-key-in-progress', {
        level: 'process',
        title: 'Loading'
    });
    $('[name="save"],[name="cancel"], #test_connection').prop('disabled', true);
    var params = {
        'action': 'get-api-key'
    };
    var callback = {
        success: function(response) {
            if(!_.isUndefined(response.mailchimp_key)) {
                $('#mc_api_key').val(response.mailchimp_key);
            }
            if(!_.isUndefined(response.connected) && response.connected) {
                $('#mailchimp_connection_success').show();
                $('#mailchimp_connection_error').hide();
            } else {
                $('#mailchimp_connection_success').hide();
                $('#mailchimp_connection_error').show();
            }
        },
        error: function(error) {
            app.alert.show('get-api-key-status', {
                level: 'error',
                messages: app.lang.get('LBL_AN_ERROR_OCCURRED_DETAILS', 'Administration') + error,
                autoClose: false
            });
            $('#mc_api_key').val('');
            $('#mailchimp_connection_success').hide();
            $('#mailchimp_connection_error').show();
        },
        complete: function() {
            $('[name="save"],[name="cancel"], #test_connection').prop('disabled', false);
            app.alert.dismiss('get-api-key-in-progress');
        }
    }
    app.api.call('create', url, params, callback);

    $('#test_connection').on('click', function() {
        app.alert.dismissAll();
        app.alert.show('test-connection-in-progress', {
            level: 'process',
            title: 'Loading'
        });
        $('[name="save"],[name="cancel"], #test_connection').prop('disabled', true);
        var params = {
            'action': 'test-connection',
            'mc_api_key': $('#mc_api_key').val()
        };
        var callback = {
            success: function(response) {
                if(response) {
                    app.alert.show('test-connection-status', {
                        level: 'success',
                        messages: app.lang.get('LBL_TEST_CONNECTION_SUCCESS', 'Administration'),
                        autoClose: true
                    });
                } else {
                    app.alert.show('test-connection-status', {
                        level: 'error',
                        messages: app.lang.get('LBL_TEST_CONNECTION_ERROR', 'Administration'),
                        autoClose: false
                    });
                }
            },
            error: function(error) {
                app.alert.show('test-connection-status', {
                    level: 'error',
                    messages: app.lang.get('LBL_AN_ERROR_OCCURRED_DETAILS', 'Administration') + error,
                    autoClose: false
                });
            },
            complete: function() {
                $('[name="save"],[name="cancel"], #test_connection').prop('disabled', false);
                app.alert.dismiss('test-connection-in-progress');
            }
        }
        app.api.call('create', url, params, callback);
    });

    $('#mailChimpConfiguration').on('submit', function(e) {
        e.preventDefault();
        app.alert.dismissAll();
        app.alert.show('save-api-key-in-progress', {
            level: 'process',
            title: 'Loading'
        });
        $('[name="save"],[name="cancel"], #test_connection').prop('disabled', true);
        var params = {
            'action': 'save-api-key',
            'mc_api_key': $('#mc_api_key').val()
        };
        var callback = {
            success: function(response) {
                if(response) {
                    $('#mailchimp_connection_success').show();
                    $('#mailchimp_connection_error').hide();
                    app.alert.show('save-api-key-status', {
                        level: 'success',
                        messages: app.lang.get('LBL_MAILCHIMP_SAVE_API_KEY_SUCCESS', 'Administration'),
                        autoClose: true
                    });
                } else {
                    app.alert.show('save-api-key-status', {
                        level: 'error',
                        messages: app.lang.get('LBL_MAILCHIMP_SAVE_API_KEY_ERROR', 'Administration'),
                        autoClose: false
                    });
                }
            },
            error: function(error) {
                app.alert.show('save-api-key-status', {
                    level: 'error',
                    messages: app.lang.get('LBL_AN_ERROR_OCCURRED_DETAILS', 'Administration') + error,
                    autoClose: false
                });
            },
            complete: function() {
                $('[name="save"],[name="cancel"], #test_connection').prop('disabled', false);
                app.alert.dismiss('save-api-key-in-progress');
            }
        }
        app.api.call('create', url, params, callback);
    });
});
