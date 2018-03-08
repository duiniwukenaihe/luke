({
    titleSelectedValues: '',
    titleViewNameTitle: '',
    titleMessage: '',
    events: {
        'click [name="cancel_button"]': 'cancelButton',
        'click [name="test_button"]': 'testButton',
        'click [name="save_button"]': 'saveButton'
    },
    initialize: function (options) {
        this._super('initialize', [options]);

        app.api.call('GET', app.api.buildURL('RT_DocuSign/testschedular/'), null, {
            success: _.bind(function (data) {
            }, this)
        });

        app.api.call('GET', app.api.buildURL('RT_DocuSign/retrieve/'), null, {
            success: _.bind(function (data) {
                if (data != '')
                {
                    if (data.integrator_key) {
                        this.model.set('docusign_integrationkey', data.integrator_key);
                    }
                    if (data.password) {
                        this.model.set('docusign_password', data.password);
                    }
                    if (data.email)
                    {
                        this.model.set('docusign_username', data.email);
                    }
                    if (data.notificationurl) {
                        this.model.set('docusign_notification_url', data.notificationurl);
                    }
                    else {
                        url = window.location.href;
                        url = url.substr(0, url.indexOf('#'));
                        url = url + 'index.php?entryPoint=docusignNotification';
                        this.model.set('docusign_notification_url', url);
                    }
                    if (data.environment)
                    {
                        this.model.set('docusign_connection_envoirnment', data.environment);
                    }
                    else {
                        this.model.set('docusign_connection_envoirnment', 'demo');
                    }
                }
                return false;
            }, this)


        });
        this._super('initialize', [options]);
    },
    cancelButton: function () {
        this.navigateback();
    },
    saveButton: function () {

        this.showLoading("loading1");
        // removing error class
        $('[name="docusign_username"]').removeClass('error input');
        $('[name="docusign_password"]').removeClass('error input');
        $('[name="docusign_integrationkey"]').removeClass('error input');
        $('[name="docusign_connection_envoirnment"]').removeClass('error input');

        username = this.model.get('docusign_username');
        password = this.model.get('docusign_password');
        integrationkey = this.model.get('docusign_integrationkey');
        notifications = this.model.get('docusign_notification_url');
        envoirnment = this.model.get('docusign_connection_envoirnment');

        var ds_auth_type = "user";
        error = false;

        // checking if user have entered values for required fields.
        if ((username == '' || username == undefined || username == 'undefined'))
        {
            $('[name="docusign_username"]').addClass('error input');
            error = true;
        }
        if ((password == '' || password == undefined || password == 'undefined'))
        {
            $('[name="docusign_password"]').addClass('error input');
            error = true;
        }
        if ((integrationkey == '' || integrationkey == undefined || integrationkey == 'undefined'))
        {
            $('[name="docusign_integrationkey"]').addClass('error input');
            error = true;
        }
        if ((envoirnment == '' || envoirnment == undefined || envoirnment == 'undefined'))
        {
            $('[name="docusign_connection_envoirnment"]').addClass('error input');
            error = true;
        }

        if (error)
        {
            this.closeAlert('loading1');
            this.showErrorAlert('Error001', app.lang.get('LBL_RT_DOCUSIGN_REQUIRED_FIELDS_ERROR', 'RT_DocuSign'));
            return false;
        }

        // Api call to save configurations.
        app.api.call('GET', app.api.buildURL('RT_DocuSign/save?email=' + username + '&password=' + password + '&integrationkey=' + integrationkey + '&envoirnment=' + envoirnment + '&notifications=' + notifications + '&dsauthtype=' + ds_auth_type), null, {
            success: _.bind(function (data) {
                if (data != '')
                {
                    if (data.toString().toLowerCase().indexOf("success") > 0)
                    {
                        save_call_results = data;
                        this.closeAlert('loading1');
                        this.showSuccessAlert('MSG023b', save_call_results);
                        this.navigateback();

                    }
                    else {
                        this.closeAlert('loading1');
                        this.showErrorAlert('ERR023', data);
                    }
                }
                else {
                    this.closeAlert('loading1');
                    this.showErrorAlert('ERR024', app.lang.get('LBL_RT_DOCUSIGN_SAVE_CRED_CONNECTION_ERROR', 'RT_DocuSign'));
                }
            }, this)
        });


    },
    testButton: function () {
        this.showLoading("loading2");

        // removing error class
        $('[name="docusign_username"]').removeClass('error input');
        $('[name="docusign_password"]').removeClass('error input');
        $('[name="docusign_integrationkey"]').removeClass('error input');
        $('[name="docusign_connection_envoirnment"]').removeClass('error input');

        username = this.model.get('docusign_username');
        password = this.model.get('docusign_password');
        integrationkey = this.model.get('docusign_integrationkey');
        notifications = this.model.get('docusign_notification_url');
        envoirnment = this.model.get('docusign_connection_envoirnment');
        error = false;

        if ((username == '' || username == undefined || username == 'undefined'))
        {
            $('[name="docusign_username"]').addClass('error input');
            error = true;
        }
        if ((password == '' || password == undefined || password == 'undefined'))
        {
            $('[name="docusign_password"]').addClass('error input');
            error = true;
        }
        if ((integrationkey == '' || integrationkey == undefined || integrationkey == 'undefined'))
        {
            $('[name="docusign_integrationkey"]').addClass('error input');
            error = true;
        }
        if ((envoirnment == '' || envoirnment == undefined || envoirnment == 'undefined'))
        {
            $('[name="docusign_connection_envoirnment"]').addClass('error input');
            error = true;
        }
        if (error)
        {
            this.closeAlert('loading2');
            this.showErrorAlert('Error011', app.lang.get('LBL_RT_DOCUSIGN_REQUIRED_FIELDS_ERROR', 'RT_DocuSign'));
            return false;
        }
        app.api.call('GET', app.api.buildURL('RT_DocuSign/test?email=' + username + '&password=' + password + '&integrationkey=' + integrationkey + '&envoirnment=' + envoirnment + '&notifications=' + notifications), null, {
            success: _.bind(function (data) {
                if (data != '')
                {
                    if (data.toString().toLowerCase().indexOf("success") > 0)
                    {
                            this.closeAlert('loading2');
                            this.showSuccessAlert('MSG001', app.lang.get('LBL_RT_DOCUSGIN_TEST_CONNECTION_SUCCESS', 'RT_DocuSign'));
                                
                    }
                    else {
                        this.closeAlert('loading2');
                        this.showErrorAlert('ERR002', data);
                    }
                }
                else
                {
                    this.closeAlert('loading2');
                    this.showErrorAlert('ERR003', app.lang.get('LBL_RT_DOCUSIGN_TEST_CONNECTION_ERROR', 'RT_DocuSign'));
                }
            }, this)
        });
    },
    showErrorAlert: function (msgno, msg) {
        app.alert.show(msgno, {
            level: 'error',
            messages: msg,
            autoClose: true
        });
    },
    showSuccessAlert: function (msgno, msg) {
        app.alert.show(msgno, {
            level: 'success',
            messages: msg,
            autoClose: true
        });
    },
    closeAlert: function (msgno) {
        if (msgno == 'all')
        {
            app.alert.dismissAll();
        }
        else {
            app.alert.dismiss(msgno);
        }
    },
    showLoading: function (msgno) {
        app.alert.show(msgno, {
            level: 'process',
            messages: app.lang.getAppString('LBL_LOADING'),
            autoClose: false
        });
    },
    readCookie: function (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0)
                return c.substring(nameEQ.length, c.length);
        }
        return null;
    },
    navigateback: function () {
        // getting values from cookie.
        allcookies = document.cookie;
        if (allcookies)
        {
            // clear cookie
            document.cookie = 'module=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            temp = allcookies.split(';');
            check = false;
            for (j = 0; j < temp.length; j++) {

                if (temp[j].indexOf('&') >= 0)
                {
                    temp2 = temp[j].split('&');
                    if (temp2.length > 1)
                    {
                        temp3 = temp2[0].split('=');
                        temp4 = temp2[1].split('=');
                        if ((temp3.length > 1) && (temp4.length > 1))
                        {
                            if ((temp3[0].trim() == 'module') && (temp4[0].trim() == 'recid'))
                            {
                                check = true;
                                app.router.navigate(app.router.buildRoute(temp4[1], temp3[1]), {trigger: true});
                            }
                            else {
                                app.router.navigate(app.router.buildRoute('Home'), {trigger: true});
                            }
                        }
                        else {
                            app.router.navigate(app.router.buildRoute('Home'), {trigger: true});
                        }
                    }
                    else
                    {
                        app.router.navigate(app.router.buildRoute('Home'), {trigger: true});
                    }
                }
            }
            if (check == false)
            {
                app.router.navigate(app.router.buildRoute('Home'), {trigger: true});
            }
        }
        else {
            app.router.navigate(app.router.buildRoute('Home'), {trigger: true});
        }
    }
})