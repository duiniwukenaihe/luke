({
    extendsFrom: 'RecordView',
    initialize: function (options) {
        this._super("initialize", arguments);
        this.context.on('button:send_to_docusign:click', this.SendToDocuSign, this);
    },
    SendToDocuSign: function () {
        app.alert.show('getting-docs-contacts', {
            level: 'process',
            title: app.lang.get('LBL_GETTING_ATTACHMENTS_CONTACTS', 'RT_DocuSign'),
        });
        app.api.call('GET', app.api.buildURL('RT_DocuSign/retrieve/'), null, {
            success: _.bind(function (data) {
                if (data != '')
                {
                    if ((data.integrator_key) && (data.password) && (data.email) && (data.notificationurl)) {

                        var licenseURL = app.api.buildURL('RT_DocuSign/prefs/', null, null, {oauth_token: app.api.getOAuthToken()});
                        app.api.call('GET', licenseURL, null, {
                            success: _.bind(function (result) {
                                app.alert.dismiss('getting-docs-contacts');
                                if (JSON.parse(result.data))
                                {
                                    var object_id = this.model.get('id');
                                    var object_name = this.model.attributes._module;
                                    data = object_id + "|" + object_name;
                                    app.drawer.open({layout: 'rt-send-to-docusign', context: {PM_Data: data}});
                                }
                                else if (!result.data)
                                {
                                    app.alert.show("ERR0015", {
                                        level: 'error',
                                        messages: app.lang.get('LBL_RT_DOCUSGIN_SUGAR_LICENCE_KEY_INVALID', 'RT_DocuSign'),
                                        autoClose: true
                                    });
                                    if (result.is_admin == '1') {
                                        app.router.navigate("RT_DocuSign/layout/dsconfig", {trigger: true});
                                    }
                                }

                            }, this),
                            error: _.bind(function (e) {
                                app.alert.dismiss('getting-docs-contacts');
                                app.alert.show("ERR0012", {
                                    level: 'error',
                                    messages: app.lang.get('LBL_RT_DOCUSGIN_SUGAR_LICENCE_KEY_FAILED', 'RT_DocuSign'),
                                    autoClose: true
                                });
                            }, this)
                        });
                    }
                    else {
                        app.alert.dismiss('getting-docs-contacts');
                        // setting current module and id in cookie.
                        module = this.model.get('id');
                        id = this.model.attributes._module;
                        document.cookie = 'module=' + module + '&recid=' + id;

                        if (data.config_status == app.lang.get('LBL_RT_DOCUSIGN_USER_CONFIG_NOT_SET', 'RT_DocuSign'))
                        {
                            if (data.Is_current_user_admin == '1')
                            {
                                app.router.navigate("RT_DocuSign/layout/dsconfig", {trigger: true});
                            }
                            else if (data.Is_current_user_admin == '0') {
                                app.router.navigate("RT_DocuSign/layout/dsconfig-user", {trigger: true});
                            }
                        }
                        else if (data.config_status == app.lang.get('LBL_RT_DOCUSIGN_ADMIN_CONFIG_NOT_SET', 'RT_DocuSign')) {

                            if (data.Is_current_user_admin == "1")
                            {
                                app.router.navigate("RT_DocuSign/layout/dsconfig", {trigger: true});
                            }
                            else
                            {
                                app.alert.show("ERR0232", {
                                    level: 'error',
                                    messages: app.lang.get('LBL_RT_DOCUSIGN_ADMIN_CONFIG_NOT_SET_MSG', 'RT_DocuSign'),
                                    autoClose: true
                                });
                            }
                        }
                    }
                }
                else {
                    app.alert.dismiss('getting-docs-contacts');
                    app.alert.show("ER4232", {
                        level: 'error',
                        messages: app.lang.get('LBL_RT_DOCUSIGN_ADMIN_CONFIG_NOT_SET_MSG', 'RT_DocuSign'),
                        autoClose: true
                    });
                }
                return false;
            }, this)
        });
    },
    /*
     * Remove smartsheet row id when
     * a record is duplicated
     */
    setupDuplicateFields: function(prefill) {
        prefill.unset('smartsheet_row_id');
	prefill.unset('has_synchronized');
	prefill.unset('smartsheet_sync_logs');
	prefill.unset('sync_cam_to_smartsheet'); 

    }
    
})
