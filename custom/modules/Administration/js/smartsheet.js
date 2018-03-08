
$(document).ready(function () {
    console.log('ready');
    //getOptions();
    //saveSmartSheetConfigurations();
});

function cancel_clicked() {
    window.location = "index.php?module=Administration&action=index";
}
function saveSheetData() {


    app.alert.dismissAll();
    app.alert.show('get-field-mapping-in-progress', {
        level: 'process',
        title: 'Loading'
    });

    var callback = {
        success: function (response) {
            if (response != 'false') {
                $('#sheet_field_mappings').html(response);
                app.alert.show('get-field-mapping-status', {
                    level: 'success',
                    messages: 'Fields fetched successfully.',
                    autoClose: true
                });
            } else {
                app.alert.dismissAll();
                app.alert.show('get-field-mapping-status', {
                    level: 'error',
                    messages: 'An error occurred, while fetching fields mapping.',
                    autoClose: false
                });
            }


        },
        error: function (error) {
            app.alert.dismissAll();
            app.alert.show('get-field-mapping-status', {
                level: 'error',
                messages: 'An error occurred, while fetching fields mapping.',
                autoClose: false
            });
        },
        complete: function () {
            $('[name="save"],[name="cancel"]').prop('disabled', false);
            app.alert.dismiss('get-field-mapping-in-progress');
        }
    }

    var sheet_id = $('#sheet_dropdown').val();
    app.api.call('create', app.api.buildURL('getsmartsheetfieldmapping'), {sheet_id: sheet_id}, callback);




    /*SUGAR.ajaxUI.showLoadingPanel();
     $.ajax({
     url: 'index.php?action=callForAjax&module=Administration&sugar_body_only=true',
     type: "POST",
     data: {
     'sheet_dropdown': $('#sheet_dropdown option:selected').val(),
     'csrf_token': $("input[name=csrf_token]").val(),
     },
     success: function (data, textStatus, jqXHR)
     {
     $("#sheet_field_mappings").html(data);
     SUGAR.ajaxUI.hideLoadingPanel();
     },
     error: function (jqXHR, textStatus, errorThrown)
     {
     SUGAR.ajaxUI.hideLoadingPanel();
     }
     });*/





}
function getOptions(field_name, module, id_name_count, selected) {

    if (typeof (field_name) != "undefined" && typeof (module) != "undefined") {

        app.alert.show('api-in-progress', {
            level: 'process',
            title: 'Loading'
        });

        var params = {};
        params.c_field_name = field_name;
        params.c_module = module;
        params.c_id_name_count = id_name_count;
        params.c_selected = selected;

        var callback = {
            success: function (response) {

                $('#hidden_options_div_' + id_name_count).html(response);
                $('#hidden_options_div_' + id_name_count).css('visibility', '');
                app.alert.dismiss('api-in-progress');

            },
            error: function (error) {
                app.alert.dismiss('api-in-progress');
                app.alert.show('api-status', {
                    level: 'error',
                    messages: 'An error occurred, while saving Api ley.',
                    autoClose: false
                });
                app.router.navigate('#bwc/index.php?module=Administration&action=index', {trigger: true});
            },
            complete: function () {

                app.alert.dismiss('api-in-progress');
            }
        }
        app.api.call('create', app.api.buildURL('getfieldoptions'), params, callback);
    }
}
function handleModuleFieldOnchange(id) {

    if (typeof (id) !== "undefined" && $('#' + id).length > 0) {
        var field_extra_dropdown = ['construction_stage'];
        var params = {};
        var self = this;
        $(field_extra_dropdown).each(function (key, value) {
            if ($('#' + id).val() == value) {
                params.field_name = value;
                params.module = 'm_CAMS';
                params.id_name_count = id.match(/\d+/)[0];
                params.selected = '';
                self.getOptions(params.field_name, params.module, params.id_name_count, params.selected);
            } else {
                var count = id.match(/\d+/)[0];
                $('#hidden_options_div_' + count).css('visibility', 'hidden');
            }
        });
    }

}

$(function () {
    $('#form_smartsheet_config').on('submit', function (e) {
        e.preventDefault();
        console.log('default prevented');

        app.alert.dismissAll();
        app.alert.show('save-field-mapping-in-progress', {
            level: 'process',
            title: 'Loading'
        });

        $('[name="save"],[name="cancel"]').prop('disabled', true);
        var form_data = [];
        var row_data_direction = [];
        var row_data_smartsheet_field = [];
        var row_data_sugarfield = [];
        var row_data_sugarfield_option = [];
        var selected_sheet_id = '';
        //console.log('v is',$(this).serializeArray());
        _.each($(this).serializeArray(), function (v) {


            if (v.name.indexOf('sugar_field_direction') !== -1) {
                row_data_direction.push(v.value);
            }
            else if (v.name.indexOf('smart_sheet_field') !== -1) {
                row_data_smartsheet_field.push(v.value);
            }
            else if (v.name.indexOf('sugar_field') !== -1) {
                row_data_sugarfield.push(v.value);
            }
            else if (v.name.indexOf('sugar_option') !== -1) {
                row_data_sugarfield_option.push(v);
            }
            else if (v.name.indexOf('sheet_dropdown') !== -1) {
                selected_sheet_id = v.value;
            } else {
                form_data.push(v);
            }


        });

        console.log('row_data_direction', row_data_direction);
        console.log('row_data_smartsheet_field', row_data_smartsheet_field);
        console.log('row_data_sugarfield', row_data_sugarfield);
        console.log('row_data_sugar_option', row_data_sugarfield_option);

        var params = {};
        params.row_data_direction = row_data_direction;
        params.row_data_smartsheet_field = row_data_smartsheet_field;
        params.row_data_sugarfield = row_data_sugarfield;
        params.sugar_option = row_data_sugarfield_option;
        params.selected_sheet_id = selected_sheet_id;


        var callback = {
            success: function (response) {
                app.alert.show('save-field-mapping-status', {
                    level: 'success',
                    messages: 'Fields mapping saved successfully.',
                    autoClose: true
                });
            },
            error: function (error) {
                app.alert.show('save-field-mapping-status', {
                    level: 'error',
                    messages: 'An error occurred, while saving fields mapping.',
                    autoClose: false
                });
            },
            complete: function () {
                $('[name="save"],[name="cancel"]').prop('disabled', false);
                app.alert.dismiss('save-field-mapping-in-progress');
            }
        }

        app.api.call('create', app.api.buildURL('savesmartsheetconfig'), params, callback);

    });
});

function saveSmartSheetConfigurations() {

}

$(function () {
    $('#SmartSheet_connection_error').hide();
    $('#SmartSheet_connection_success').hide();
    $('#test_connection').on('click', function () {

        app.alert.dismissAll();
        app.alert.show('validate-in-progress', {
            level: 'process',
            title: 'Loading'
        });

        var api_key = $('#ss_api_key').val();

        var callback = {
            success: function (response) {
                app.alert.dismissAll();

                if (response) {
                    $('#SmartSheet_connection_success').show();
                    $('#SmartSheet_connection_error').hide();
                } else {
                    $('#SmartSheet_connection_error').show();
                    $('#SmartSheet_connection_success').hide();
                }

            },
            error: function (error) {
                app.alert.show('validate-status', {
                    level: 'error',
                    messages: 'An error occurred, while saving fields mapping.',
                    autoClose: false
                });
            },
            complete: function () {
                $('[name="save"],[name="cancel"]').prop('disabled', false);
                app.alert.dismiss('validate-in-progress');
            }
        }

        var params = {};
        params.ss_api_key = api_key;

        app.api.call('create', app.api.buildURL('testsmartsheetapi'), params, callback);

    });

    //form_validate_smartsheet_key

    $('#form_validate_smartsheet_key').on('submit', function (e) {
        e.preventDefault();
        app.alert.dismissAll();
        app.alert.show('api-in-progress', {
            level: 'process',
            title: 'Loading'
        });

        var params = {};
        params.ss_api_key = $('#ss_api_key').val();
        params.ss_webhook_id = $('#ss_webhook_id').val();
        params.ss_id = $('#ss_id').val();
        params.ss_email_id = $('#ss_email_id').val();

        var callback = {
            success: function (response) {
                app.alert.dismiss('api-in-progress');
                app.alert.show('api-status', {
                    level: 'success',
                    messages: 'Api saved successfully.',
                    autoClose: true
                });
                app.router.navigate('#bwc/index.php?module=Administration&action=index', {trigger: true});
                app.alert.dismissAll();
            },
            error: function (error) {
                app.alert.dismiss('api-in-progress');
                app.alert.show('api-status', {
                    level: 'error',
                    messages: 'An error occurred, while saving Api ley.',
                    autoClose: false
                });
                app.router.navigate('#bwc/index.php?module=Administration&action=index', {trigger: true});
            },
            complete: function () {

                app.alert.dismiss('api-in-progress');
            }
        }
        app.api.call('create', app.api.buildURL('savesmartsheetapikey'), params, callback);

    });
});

