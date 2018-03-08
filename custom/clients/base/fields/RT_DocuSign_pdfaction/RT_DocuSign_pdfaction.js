/*
 // RT_DocuSign
 // Author : Rolustech
 // Sep 2015
 */
({
    extendsFrom: 'RowactionField',
    events: {
        'click [data-action=link]': 'linkClicked',
        'click [data-action=send_pdf_to_docusign]': 'SendPDFToDocuSign'
    },
    templateCollection: null,
    fetchCalled: false,
    initialize: function (options) {
        this._super('initialize', [options]);
        this.templateCollection = app.data.createBeanCollection('PdfManager');
    },
    _render: function () {
        var emailClientPreference = app.user.getPreference('email_client_preference');
        if (this.def.action === 'email' && emailClientPreference.type !== 'sugar') {
            this.hide();
        } else {
            this._super('_render');
        }
    },
    _fetchTemplate: function () {
        this.fetchCalled = true;
        var collection = this.templateCollection;
        collection.filterDef = {
            '$and': [{
                    'base_module': this.module
                }, {
                    'published': 'yes'
                }]
        };
        collection.fetch();
    },
    _buildDownloadLink: function (templateId) {
        var urlParams = $.param({
            'action': 'sugarpdf',
            'module': this.module,
            'sugarpdf': 'pdfmanager',
            'record': this.model.id,
            'pdf_template_id': templateId
        });
        return '?' + urlParams;
    },
    linkClicked: function (evt) {
        evt.preventDefault();
        evt.stopPropagation();
        if (this.templateCollection.dataFetched) {
            this.fetchCalled = !this.fetchCalled;
        } else {
            this._fetchTemplate();
        }
        this.render();
    },
    bindDataChange: function () {
        this.templateCollection.on('reset', this.render, this);
        this._super('bindDataChange');
    },
    unbindData: function () {
        this.templateCollection.off(null, null, this);
        this.templateCollection = null;
        this._super('unbindData');
    },
    hasAccess: function () {
        var pdfAccess = app.acl.hasAccess('view', 'PdfManager');
        return pdfAccess && this._super('hasAccess');
    },
    SendPDFToDocuSign: function (evt) {
        app.alert.show('getting-docs-contacts', {
            level: 'process',
            title: app.lang.get('LBL_CONVERTING_EMAIL_TO_PDF', 'RT_DocuSign'),
        });
        var templateId = this.$(evt.currentTarget).data('id');
        check = false;
        app.api.call('GET', app.api.buildURL('RT_DocuSign/retrieve/'), null, {
            success: _.bind(function (data) {
                if (data != '')
                {
                    if ((data.integrator_key) && (data.password) && (data.email) && (data.notificationurl)) {


                        var licenseURL = app.api.buildURL('RT_DocuSign/prefs/', null, null, {oauth_token: app.api.getOAuthToken()});
                        app.api.call('GET', licenseURL, null, {
                            success: _.bind(function (result) {
                                if (JSON.parse(result.data))
                                {

                                    pdf_link = this._buildDownloadLink(templateId);
                                    parent_module = this.module;
                                    parent_id = this.model.id;

                                    // first we login into sugar to access it.
                                    app.bwc.login(null, _.bind(function () {

                                        // Note: Due to some limitations we have to use XMLHttpRequest. And we can not Send Blob(Document Contents) and other params through XMLHttpRequest in single request.
                                        // So first we send  other parameter like parent module, record id and templete id to server and save them in session. then we send documents contents and create document in sugar.

                                        // Sending parameter to save in session.
                                        var http = new XMLHttpRequest();
                                        var params = "func=saveValues&template_id=" + templateId + "&parent_module=" + parent_module + "&parent_record_id=" + parent_id;
                                        http.open("POST", "index.php?module=RT_DocuSign&action=savevaluestosession", true);
                                        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                        http.onload = function (evnt) {//Call a function when the state changes.
                                            if (http.readyState == 4 && http.status == 200) {

                                                // Now Parameter are saved in session we have to download PDF from url into Blob variable.
                                                var xhr = new XMLHttpRequest();
                                                xhr.open('GET', pdf_link, true);
                                                xhr.responseType = 'blob';
                                                xhr.onload = function (e) {
                                                    if (this.status == 200) {

                                                        // this will download pdf from url and save it into blob. 
                                                        // Finally we send Blob to server containing Documents Contents in binary from.
                                                        var blob = new Blob([this.response], {type: 'application/pdf'});
                                                        var oReq = new XMLHttpRequest();
                                                        oReq.open("POST", "index.php?module=RT_DocuSign&action=savepdfdocument", true);

                                                        oReq.onload = function (oEvent) {

                                                            ajaxresult = oReq.responseText;
                                                            // PDF is created in Documents module Now we have to open Drawer with attached PDF.								 
                                                            pdf_doc_rev_id = '';
                                                            pdf_doc_name = '';
                                                            if (ajaxresult)
                                                            {
                                                                temp = ajaxresult.toString().split('|');
                                                                if (temp.length == 2)
                                                                {
                                                                    pdf_doc_rev_id = temp[0];
                                                                    pdf_doc_name = temp[1];
                                                                }
                                                            }
                                                            app.alert.dismiss('getting-docs-contacts');
                                                            app.drawer.open({layout: 'rt-send-to-docusign', context: {ParentID: parent_id, Module: parent_module, PdfDocID: pdf_doc_rev_id, PdfDocName: pdf_doc_name}});
                                                        };
                                                        oReq.send(blob);// this will send the downloaded pdf in the form of blob to create its record in sugarcrm as a document.
                                                    }
                                                };
                                                xhr.send();
                                            }
                                        }
                                        http.send(params);

                                    }, this));
                                }
                                else if (!result.data)
                                {
                                    app.alert.dismiss('getting-docs-contacts');
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

                                //app.router.navigate("RT_DocuSign/layout/dsconfig",{trigger: true});
                            }, this)
                        });
                        check = true;
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
                                app.alert.show("ER10232", {
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
                    app.alert.show("ER10232", {
                        level: 'error',
                        messages: app.lang.get('LBL_RT_DOCUSIGN_ADMIN_CONFIG_NOT_SET_MSG', 'RT_DocuSign'),
                        autoClose: true
                    });
                }
                return false;
            }, this)
        });
    }
})