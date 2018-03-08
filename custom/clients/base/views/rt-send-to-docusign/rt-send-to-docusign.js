({
    className: 'rtdocusign',
    signed_attachment_type: null,
    docusign_templates: null,
    templete_roles: {},
    signed_attachment_name: '',
    documents_type: 'Sugar Attachments',
    events: {
        'click [name="cancel_button"]': 'closeDrawer',
        'click [name="remove_document"]': 'removeDocument',
        'click [name="remove_contact"]': 'removeContact',
        'click [name="add_document"]': 'addDocument',
        'click [name="add_contact"]': 'addContact',
        'click [name="send_to_ds"]': 'SendToDocuSign',
        'change [name="documents_type"]': 'setDocumentsType',
        'change [name="docusign_templates"]': 'getDocuSignTemplate',
    },
    loadData: function (options) {
        ParentID = this.context.get('ParentID');
        Module = this.context.get('Module');
        PdfDocID = this.context.get('PdfDocID');
        PdfDocName = this.context.get('PdfDocName');

        parenturl = window.location.href;
        authtoken = SUGAR.App.api.getOAuthToken();
        this.sugarUrl = new this.getUrlObject(parenturl); // parsing and creating object of current url.
        this.authtoken = authtoken;
        this.contacts = this.AttachedContacts();
        if (PdfDocID)// if PDF is sent for signature
        {
            this.documents = [];
            this.documents.push({
                name: PdfDocName,
                revisionId: PdfDocID
            });

        } else { // we will fetch the attached documents of with Current Record.
            this.documents = this.getAttachedDocuments(this.sugarUrl, this.authtoken);
        }
        this.parent_id = this.sugarUrl.RecordId;
        this.module = this.sugarUrl.ModuleName;
        this.parent_module = this.modulePlural;
        this.name = this.getRecordName(this.sugarUrl, this.authtoken, this.module, this.parent_id);
        this.parenturl = parenturl;

    },
    _render: function () {
        this._super('_render');
        ds = document.getElementById("myIframe");
        if (ds) { // hiding iframe on laod.
            $("#myIframe").hide();
            $("#spinner").hide();
        }
        $("#doc_attachedcontacts_c-0").remove();
        $("#cntct_attacheddocuments_c-0").remove();
        app.alert.dismiss('getting_docs_and_contacts_id');
        this.model.set("signed_attachment_type", this.signed_attachment_type);
        var file_name = this.signed_attachment_name;
        var dot_postion = file_name.lastIndexOf('.');
        if (dot_postion > 0) {
            file_name = file_name.substr(0, dot_postion);
        }
        //$('#signed_attachment_name').val(file_name);
        this.model.set("documents_type", this.documents_type);
        this.populateTemplates();
        this.populateInitials();
    },
    populateInitials: function (contact_id, initial) {
        var selecter = '.select_initial';
        var remove_selecter = 'div.select_initial';
        if (contact_id) {
            selecter = '#row_' + contact_id + ' .select_initial';
            remove_selecter = '#row_' + contact_id + ' div.select_initial';
        }
        $(selecter).html('<option value=""></option>');
        var initials_list = this.templete_roles;
        $.each(initials_list, function (index, role) {
            $(selecter).append('<option value="' + role + '">' + role + '</option>');
        });
        if (initial) {
            $(selecter).val(initial);
        }
        $(remove_selecter).remove();
        $(selecter).select2({
            allowClear: true,
        });
        $(".send_docs_main .controls-one").css("padding-bottom","10px");
    },
    populateInitialsInAllContacts: function () {
        var self = this;
        $('#contacts_grid div').each(function () {
            if (this.id)
            {
                temp = this.id;
                var contct_id = temp.replace("row_", "");
                if (contct_id) {
                    self.populateInitials(contct_id);
                }
            }
        });
    },
    populateTemplates: function () {
        var sugarUrl = this.sugarUrl;
        var auth = this.authtoken;
        var self = this;
        $.ajax({
            type: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'OAuth-Token': auth
            },
            url: sugarUrl.apiRootURL + '/RT_DocuSign/docuSignTemplates/',
            data: '',
            success: function (data) {
                self.docusign_templates = data;
                var options = new Object();
                options[""] = "";
                _.each(data, function (item, index) {
                    options[item.id] = item.name;
                });
                var docusign_templates = self.getField('docusign_templates', this.model);
                if (docusign_templates !== null) {
                    docusign_templates.def.setOptions = options;
                    docusign_templates.items = options;
                    docusign_templates.def.required = false;
                    docusign_templates.render();
                    $(".docusign_templates .record-label b").text("Docusign Templates");
                }
            }
        });
    },
    getDocuSignTemplate: function () {
        var self = this;
        var template_id = this.model.get("docusign_templates");
        if (template_id) {
            $(".template_details").show();
            $(".template_msg").text("Getting template roles. Please wait...");
            $(".template_roles").html("");
            var sugarUrl = this.sugarUrl;
            var auth = this.authtoken;
            var params = {
                template_id: template_id
            };
            $.ajax({
                type: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'OAuth-Token': auth
                },
                url: sugarUrl.apiRootURL + '/RT_DocuSign/docuSignTemplate/',
                data: params,
                success: function (data) {
                    $("div.select_initial").remove();
                    self.templete_roles = data.roles;
                    self.populateInitials();
                    self.populateInitialsInAllContacts();
                    var total_roles = 0;
                    var roles_html = '';
                    _.each(data.roles, function (role, index) {
                        total_roles++;
                        roles_html += '<span class= "role"><b>' + total_roles + '.</b> ' + role + '</span><br>';
                    });
                    if (total_roles) {
                        $(".template_msg").text("Following roles are added in this template,");
                    } else {
                        $(".template_msg").text("No role is added in this template,");
                    }
                    $(".template_roles").html(roles_html);
                }
            });
        } else {
            $(".template_details").hide();
            $("div.select_initial").remove();
            self.templete_roles = {};
            self.populateInitials();
            self.populateInitialsInAllContacts();
        }
    },
    setDocumentsType: function () {
        this.documents_type = $('[name="documents_type"]').val();

        if (this.documents_type == 'Sugar Attachments') {
            $('#docusign_templates').hide();
            $('#sugar_attachments').show();
            $("div.select_initial").remove();
            $(".template_details").hide();
        } else {
            $('#sugar_attachments').hide();
            $('#docusign_templates').show();
        }
        $("div.select_initial").remove();
        this.templete_roles = {};
        this.populateInitials();
        this.populateInitialsInAllContacts();
        this.model.set("docusign_templates", "");
    },
    SendToDocuSign: function () {
        var template_id = this.model.get("docusign_templates");
        var signed_attachment_type = $('[name="signed_attachment_type"]').val();
        var signed_attachment_name = $('#signed_attachment_name').val();
        if (signed_attachment_type == '')
        {
            app.alert.show('error00201', {
                level: 'error',
                messages: app.lang.get('LBL_RT_DOCUSIGN_RESOLVE_ERRORS_BEFORE_PROCEED', 'RT_DocuSign'),
                autoClose: true
            });
            $('.signed_attachment_type').addClass('error');
            return;
        } else {
            $('.signed_attachment_type').removeClass('error');
        }
        if (signed_attachment_name == '')
        {
            app.alert.show('error00201', {
                level: 'error',
                messages: app.lang.get('LBL_RT_DOCUSIGN_RESOLVE_ERRORS_BEFORE_PROCEED', 'RT_DocuSign'),
                autoClose: true
            });
            $('.signed_attachment_name').addClass('error');
            return;
        } else {
            $('.signed_attachment_name').removeClass('error');
        }

        var cntctid = 0;
        while ($("#cntct_" + cntctid).length != 0) {
            $("#cntct_" + cntctid).trigger("click");
            cntctid++;
        }
        // function to create envelope from data and open docusign iframe.
        $("#maindiv").hide();
        $("#record").hide();

        $('#documents_grid').removeClass('error input');
        $('#contacts_grid').removeClass('error input');

        // getting notifications url from RT_DocuSign through api.
        url = encodeURI(this.sugarUrl.apiRootURL + "/RT_DocuSign/");
        var notififcation_url = "";
        $.ajax({
            type: 'GET',
            url: url,
            headers: {
                'Content-Type': 'application/json',
                'OAuth-Token': this.authtoken
            },
            async: false,
            success: function (ajaxresult) {
                notififcation_url = ajaxresult.records[0].docusign_notification_url;
                if (notififcation_url)
                {
                    //notififcation_url=notififcation_url+'index.php?entryPoint=docusignNotification';
                    notififcation_url = notififcation_url;
                }
            }
        });


        sugarUrl = this.sugarUrl;
        auth = this.authtoken;
        var added_roles = 0;
        var returnUrlParams = {
            urlRoot: sugarUrl.rootURL,
            parentRecord: sugarUrl.ModuleName,
            parentId: sugarUrl.RecordId,
            token: auth,
            bwc: sugarUrl.isbwc,
            nofificationurl: notififcation_url
        };

        var documents = [];
        var contacts = [];
        $('#contacts_grid div').each(function () {
            if (this.id)
            {
                temp = this.id;
                contct_id = temp.replace("row_", "");
                val = $(this).find('input').val(); // we have got contact in following format:  Name(email)
                val = val.toString().slice(0, -1);	// removing ')' from end.
                temp = val.toString().split('('); // splitting name and email on basis of '('
                if ((temp[0]) && (temp[1]) && (contct_id)) // now we have name on 0 index and email on 1 index.
                {
                    var initial = $("#select_initial_" + contct_id).val();
                    contacts.push({
                        id: contct_id,
                        name: temp[0],
                        email: temp[1],
                        initial: initial
                    });
                    if (initial) {
                        added_roles++;
                    }
                }
            }
        });

        $('#documents_grid div').each(function () {
            if ((this.id) && (this.id != 'doc_attacheddocuments_c-0'))
            {
                val = this.id;
                revid = val.replace("row_", "");
                doc_name = $(this).find('input').val();
                if ((doc_name) && (revid))
                {
                    documents.push({
                        name: doc_name,
                        revisionId: revid
                    });
                }
            }
        });


        // Adding the last contact if not attached
        selected_contact_name = $('[name="attachedcontacts_c"]').val(); // getting contact name
        contactID = $('[name="attachedcontacts_c"]').attr('data-id');

        if ((selected_contact_name) && (contactID)) {

            pid = "#cntct_attachedcontacts_c-0";
            //this.insertContact(pid,contactname,contactID,false);
            if ((selected_contact_name) && (contactID))
            {
                url = encodeURI(this.sugarUrl.apiRootURL + "/Contacts/" + contactID);
                var email = "";
                var cid = "";
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {'name': selected_contact_name},
                    headers: {
                        'Content-Type': 'application/json',
                        'OAuth-Token': this.authtoken
                    },
                    async: false,
                    success: function (ajaxresult) {
                        email = ajaxresult.email1;
                        cid = ajaxresult.id;
                    }
                });

                check = false;
                // checking if selected contact is already attached.
                $.each(contacts, function (index, value) {
                    if (value.id == cid)
                    {
                        check = true;
                    }
                });

                if (check)
                {// if attached display error.

                }
                else
                {// if not attached insert row if contact has email

                    if (email) {

                        var initial_0 = $("#select_initial_0").val();
                        contacts.push({
                            id: contactID,
                            name: selected_contact_name,
                            email: email,
                            initial: initial_0

                        });
                        if (initial_0) {
                            added_roles++;
                        }
                    }
                    else {

                        app.alert.show('message-id5', {
                            level: 'error',
                            messages: app.lang.get('LBL_RT_DOCUSIGN_CONTACT_MUST_EMAIL', 'RT_DocuSign'),
                            autoClose: true
                        });
                    }
                }
            }

        }
        //attaching last document if not exists

        documentID = $('[name="attacheddocuments_c"]').val(); //selected document name
        documentname = this.model.get('attacheddocuments_c');

        if ((documentname) && (documentID)) {
            pid = "#doc_attacheddocuments_c-0";

            url = encodeURI(this.sugarUrl.apiRootURL + "/mv_Attachments/" + documentID);
            var revid = "";
            // getting document revision id of selected document through api call.
            $.ajax({
                type: 'GET',
                url: url,
                data: {'name': documentname},
                headers: {
                    'Content-Type': 'application/json',
                    'OAuth-Token': this.authtoken
                },
                async: false,
                success: function (ajaxresult) {
                    revid = ajaxresult.id;
                }
            });
            check = false;
            // checking if selected document is already attached.
            $.each(documents, function (index, value) {

                if ((value.name == documentname) && (value.revisionId == revid))
                {
                    check = true;
                }
            });

            if (check)
            {// if attached display error.

            }
            else
            {
                documents.push({
                    name: documentname,
                    revisionId: revid
                });
            }
        }

        $('.template_roles').removeClass('error');
        if ((contacts.length == 0) && (documents.length == 0 && this.documents_type == 'Sugar Attachments')) {
            app.alert.show('error00201', {
                level: 'error',
                messages: app.lang.get('LBL_RT_DOCUSIGN_RESOLVE_ERRORS_BEFORE_PROCEED', 'RT_DocuSign'),
                autoClose: true
            });
            $("#maindiv").show();
            $("#record").show();
            $('#contacts_grid').addClass('error input');
            $('#documents_grid').addClass('error input');
        } else if (contacts.length == 0) {
            app.alert.show('error0001', {
                level: 'error',
                messages: app.lang.get('LBL_RT_DOCUSIGN_ATTACH_CONTACT_ERROR', 'RT_DocuSign'),
                autoClose: true
            });
            $("#maindiv").show();
            $("#record").show();
            $('#contacts_grid').addClass('error input');
        } else if (documents.length == 0 && this.documents_type == 'Sugar Attachments') {
            app.alert.show('error0002', {
                level: 'error',
                messages: app.lang.get('LBL_RT_DOCUSIGN_ATTACH_DOCUMENT_ERROR', 'RT_DocuSign'),
                autoClose: true
            });
            $("#maindiv").show();
            $("#record").show();
            $('#documents_grid').addClass('error input');

        } else if (!template_id && this.documents_type == 'DocuSign Templates') {
            app.alert.show('error00201', {
                level: 'error',
                messages: app.lang.get('LBL_RT_DOCUSIGN_RESOLVE_ERRORS_BEFORE_PROCEED', 'RT_DocuSign'),
                autoClose: true
            });
            $("#maindiv").show();
            $("#record").show();
            $('.template_roles').addClass('error');

        } else if (added_roles < this.templete_roles.length) {
            app.alert.show('error00201', {
                level: 'error',
                messages: app.lang.get('LBL_RT_DOCUSIGN_TEMPLATE_ROLE_IS_MISSING', 'RT_DocuSign'),
                autoClose: false
            });
            $("#maindiv").show();
            $("#record").show();

            $('.template_roles').addClass('error');
        } else {
            $("#spinner").show();
            app.alert.show('sending-to-docusign', {
                level: 'process',
                title: app.lang.get('LBL_SENDING_TO_DOCUSIGN', 'RT_DocuSign'),
            });
            var params = {
                sugarRoot: sugarUrl.rootURL,
                returnUrl: sugarUrl.rootURL + 'index.php?module=RT_DocuSign&action=envelopeinfo&' + $.param(returnUrlParams),
                contacts: contacts,
                documents: documents,
                notificationsurl: notififcation_url,
                signed_attachment_type: signed_attachment_type,
                signed_attachment_name: signed_attachment_name,
                template_id: template_id,
                documents_type: this.documents_type
            };
            var data;
            $.ajax({
                type: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'OAuth-Token': auth
                },
                url: sugarUrl.apiRootURL + '/RT_DocuSign/sendforsign/',
                data: params,
                success: function (data) {
                    app.alert.dismiss('sending-to-docusign');
                    $("#spinner").hide();
                    data = JSON.parse(data);
                    $('#myIframe').attr('src', data.url);
                    $("#myIframe").show();
                }
            });
        }
    },
    insertDocument: function (pid, selected_document_name, documentID, displayError) {
        if ((selected_document_name) && (documentID))
        {
            url = encodeURI(this.sugarUrl.apiRootURL + "/mv_Attachments/" + documentID);
            var revid = "";
            // getting document revision id of selected document through api call.
            $.ajax({
                type: 'GET',
                url: url,
                data: {'name': selected_document_name},
                headers: {
                    'Content-Type': 'application/json',
                    'OAuth-Token': this.authtoken
                },
                async: false,
                success: function (ajaxresult) {
                    revid = ajaxresult.id;
                }
            });
            check = false;
            // checking if selected document is already attached.
            $('#documents_grid div').each(function () {
                compareid = "row_" + revid;
                if (compareid == this.id)
                {
                    check = true;
                }
            });

            if (check)
            {// if attached display error.
                if (displayError)
                {
                    app.alert.show('message-id', {
                        level: 'info',
                        messages: 'Document: \"' + selected_document_name + '\" is Already Attached !',
                        autoClose: true
                    });
                }
            }
            else
            {// if not attached insert row.
                row = '<div id="row_' + revid + '" class="controls controls-one btn-fit"> <input type="text" value="' + selected_document_name + '" id="cust_doc_" class="span12"> <a href="javascript:void(0)" class="btn first" rel="tooltip" title="Primary" track="click:remove_document" name="remove_document"><i class="icon-minus fa fa-minus" id="' + revid + '"></i></a><br/><br/></div>';
                $(pid).before(row);
            }
        }
    },
    getUrlObject: function (urlstring) {
        if (urlstring.indexOf("/#bwc/") > -1) { // for BWC modules
            this.isbwc = true;
            this.rootURL = urlstring.substring(0, urlstring.indexOf("/#bwc/"));
            paramstring = urlstring.slice(urlstring.indexOf("?") + 1);
            params = paramstring.split('&');
            var modulename = "";
            var recid = "";
            $.each(params, function (index, value) {
                temp = value.split("=");
                if (temp[0] == 'record') {
                    recid = temp[1];
                }
                if (temp[0] == 'module') {
                    modulename = temp[1];
                }
            });
            this.ModuleName = modulename;
            this.RecordId = recid;
            this.apiRootURL = this.rootURL + '/rest/v10';
            this.currentRecordApiURL = this.apiRootURL + '/' + this.ModuleName + '/' + this.RecordId;
            if (this.RecordId == '') {
                this.isListview = true;
            }
            if (this.ModuleName == 'Home') {
                this.isAtHome = true;
            }
        } else {
            this.isbwc = false;
            this.rootURL = urlstring.substring(0, urlstring.indexOf("#"));
            this.rootURL = this.rootURL.replace('index.php', '');
            paramstring = urlstring.slice(urlstring.indexOf("#") + 1);
            if (paramstring.indexOf("/") > -1) {
                this.ModuleName = paramstring.slice(0, paramstring.indexOf("/"));
                this.RecordId = paramstring.slice(paramstring.indexOf("/") + 1);
            } else {
                this.ModuleName = paramstring;
                this.RecordId = "";
            }
            this.apiRootURL = this.rootURL + 'rest/v10';
            this.currentRecordApiURL = this.apiRootURL + '/' + this.ModuleName + '/' + this.RecordId;
            ;
            if (this.RecordId == '') {
                this.isListview = true;
            }
            if (this.ModuleName == 'Home') {
                this.isAtHome = true;
            }
        }
    },
    closeDrawer: function () {
        app.drawer.close();
    },
    getContactsURL: function (sugarUrl, authenticationToken) {
        var SugarcontactsUrl;
        if (sugarUrl.ModuleName === 'Quotes') {
            var accountID = "";
            $.ajax({
                type: 'GET',
                url: sugarUrl.currentRecordURL,
                headers: {
                    'Content-Type': 'application/json',
                    'OAuth-Token': authenticationToken
                },
                success: function (ajaxresult) {
                    accountID = ajaxresult.account_id;
                    SugarcontactsUrl = sugarUrl.apiRootURL + '/Accounts/' + accountID + '/link/contacts';
                }
            });
        } else if (sugarUrl.ModuleName === 'Leads' || sugarUrl.ModuleName === 'Contacts') {
            SugarcontactsUrl = sugarUrl.currentRecordApiURL;
        } else {
            SugarcontactsUrl = sugarUrl.currentRecordApiURL + '/link/contacts';
        }
        return SugarcontactsUrl;
    },
    fetchContacts: function (cntcts_url, authenticationToken) {
        var contact = [];
        $.ajax({
            url: cntcts_url,
            headers: {
                'Content-Type': 'application/json',
                'OAuth-Token': authenticationToken
            },
            async: false,
            success: function (ajaxresult) {
                if ((ajaxresult.email1) && (ajaxresult.name)) {
                    contact = [{
                            id: ajaxresult.id,
                            name: ajaxresult.name,
                            email1: ajaxresult.email1
                        }];
                }
                else if (ajaxresult.email1 == "")
                {
                    contact = [{
                            id: ajaxresult.id,
                            name: ajaxresult.name,
                            email1: ajaxresult.email1
                        }];
                }
                else {
                    contact = ajaxresult.records;
                }
            }
        });
        return contact;
    },
    AttachedContacts: function () {
        cntcts_url = this.getContactsURL(this.sugarUrl, this.authtoken);
        cnts = this.fetchContacts(cntcts_url, this.authtoken);
        var contacts = [];
        cntct_id = 1;
        $.each(cnts, function (index, cntctrecord) {
            if ((cntctrecord.name) && (cntctrecord.email1))
            {
                contacts.push({
                    id: cntctrecord.id,
                    name: cntctrecord.name,
                    email: cntctrecord.email1
                });
            }
            cntct_id = cntct_id + 1;
        });
        return contacts;
    },
    getAttachedDocuments: function (sugarUrl, auth) {
        var self = this;
        // this function will fetch attached document of current record.
        var related_attachements_link = this.module.toLowerCase() + '_mv_attachments';
        var documentsUrl = sugarUrl.currentRecordApiURL + '/link/' + related_attachements_link;
        var documentRecords = [];
        $.ajax({
            url: documentsUrl,
            headers: {
                'Content-Type': 'application/json',
                'OAuth-Token': auth
            },
            async: false,
            success: function (data) {
                documentRecords = data.records;
            }
        });
        var docs = [];

        $.each(documentRecords, function (index, documentRecord) {
            $.ajax({
                type: 'GET',
                url: sugarUrl.apiRootURL + '/mv_Attachments/' + documentRecord.id,
                async: false,
                headers: {
                    'Content-Type': 'application/json',
                    'OAuth-Token': auth
                },
                success: function (data) {
                    var docName = (data.name === '') ? data.filename : data.name;
                    if (!data.signed_copy) {
                        docs.push({
                            name: docName.replace("'", '_'),
                            revisionId: data.id
                        });
                        self.signed_attachment_type = data.category_id;
                        self.signed_attachment_name = docName.replace("'", '_');
                    }
                }
            });

        });

        return docs;

    },
    getRecordName: function (sugarUrl, auth, module, recid) {

        var record_name;
        $.ajax({
            type: 'GET',
            url: sugarUrl.apiRootURL + '/' + module + '/' + recid,
            async: false,
            headers: {
                'Content-Type': 'application/json',
                'OAuth-Token': auth
            },
            success: function (data) {
                record_name = data.name;
            }
        });
        return record_name;
    },
    removeDocument: function (e) {
        this.removeElement(e);
    },
    removeContact: function (e) {
        this.removeElement(e);
    },
    removeElement: function (e)
    {
        /* we have followed here a convention. we have assigned id to each row containing document or contact
         in this format row_DocumentRevisionID or row_ID respectively, and assigned id to remove button  ' - '  as Document_revision or id respectively.
         so when ever remove button ( - ) is clicked we generate its row id using above format and remove that row.
         */

        id = "";
        if (e.target.type == '')// if button is clicked. we have to get id of its child <i> tag.
        {
            temp = e.target.innerHTML;
            id = temp.substring(temp.indexOf("id=") + 4, temp.indexOf("\">"));
            id = "#row_" + id; // creating id of row using above mentioned format
        }
        else // if <i> is clicked we get its id and create row id.
        {
            id = "#row_" + e.target.id;	// creating id of row using above mentioned format
        }
        $(id).remove();
    },
    addDocument: function (e) {
        documentID = $('[name="attacheddocuments_c"]').val(); //selected document name
        documentname = this.model.get('attacheddocuments_c');

        id = "";
        if (e.target.type == '')// if button is clicked. we have to get id of its child <i> tag.
        {
            temp = e.target.innerHTML;
            id = temp.substring(temp.indexOf("id=") + 4, temp.indexOf("\">"));
            id = id.substring(id.indexOf("_") + 1); // creating id of row using above mentioned format

        }
        else // if <i> is clicked we get its id and create row id.
        {
            id = e.target.id;
            id = id.toString().substring(id.toString().indexOf("_") + 1);
        }
        pid = "#doc_attacheddocuments_c-" + id; // getting <p> text where document relate field is attached to get its text.
        selected_document_name = $(pid).text().trim();
        var revid = "";
        if (selected_document_name == "Select Attachment...")// check if some document is selected.
        {
            app.alert.show('message-id2', {
                level: 'error',
                messages: 'Please select an attachment',
                autoClose: true
            });
        } else {
            this.insertDocument(pid, selected_document_name, documentID, true);
            $('#documents_grid').removeClass('error input');
        }
        this.model.set('attacheddocuments_c', '');

        $("#documents_grid .select2-container").select2('data', {});
        $("#documents_grid .select2-container").select2('val', '');
    },
    addContact: function (e) {
        selff = this;
        contactID = $('[name="attachedcontacts_c"]').val(); // getting contact name
        contactname = this.model.get('attachedcontacts_c');
        id = "";
        if (e.target.type == '')// if button is clicked. we have to get id of its child <i> tag.
        {
            temp = e.target.innerHTML;
            id = temp.substring(temp.indexOf("id=") + 4, temp.indexOf("\">"));
            id = id.substring(id.indexOf("_") + 1); // creating id of row using above mentioned format

        }
        else // if <i> is clicked we get its id and create row id.
        {
            id = e.target.id;
            id = id.toString().substring(id.toString().indexOf("_") + 1);
        }

        pid = "#cntct_attachedcontacts_c-" + id;
        selected_contact_name = $(pid).text().trim();
        var emial = "";
        var cid = "";

        if (selected_contact_name != "Select contact...")
        {
            var initial = $("#select_initial_0").val();
            this.insertContact(pid, contactname, contactID, true, initial);
        }
        this.model.set('attachedcontacts_c', '');
    },
    insertContact: function (pid, selected_contact_name, contactID, displayError, initial)
    {
        if ((selected_contact_name) && (contactID))
        {
            url = encodeURI(this.sugarUrl.apiRootURL + "/Contacts/" + contactID);
            var email = "";
            var cid = "";
            $.ajax({
                type: 'GET',
                url: url,
                data: {'name': selected_contact_name},
                headers: {
                    'Content-Type': 'application/json',
                    'OAuth-Token': this.authtoken
                },
                async: false,
                success: function (ajaxresult) {
                    email = ajaxresult.email1;
                    cid = ajaxresult.id;
                }
            });

            check = false;
            // checking if selected contact is already attached.
            $('#contacts_grid div').each(function () {
                compareid = "row_" + cid;
                if (compareid == this.id)
                {
                    check = true;
                }
            });

            if (check)
            {// if attached display error.
                if (displayError)
                {
                    app.alert.show('message-id', {
                        level: 'info',
                        messages: '\"' + selected_contact_name + '\"' + app.lang.get('LBL_RT_DOCUSIGN_CONTACT_ALREADY_ATTACHED', 'RT_DocuSign'),
                        autoClose: true
                    });
                }
            }
            else
            {// if not attached insert row if contact has email

                if (email) {
                    row = '<div id="row_' + cid + '" class="controls controls-one btn-fit"> <input type="text" value="' + selected_contact_name + '(' + email + ')" class="span12" name="' + selected_contact_name + '"></input>  <select class="element select2 select_initial" id="select_initial_' + cid + '" data-placeholder="Initials"></select> <a href="javascript:void(0)" class="btn first" rel="tooltip" title="Primary" track="click:remove_contact" name="remove_contact"><i class="icon-minus  fa fa-minus" id="' + cid + '"></i></a><br/><br/></div> ';
                    $(pid).before(row);
                    $('#contacts_grid').removeClass('error input');
                    this.populateInitials(cid, initial);
                    $("#select_initial_0").val("");
                    $("#select_initial_0").select2({allowClear: true, });
                }
                else {

                    app.alert.show('message-id2', {
                        level: 'error',
                        messages: app.lang.get('LBL_RT_DOCUSIGN_CONTACT_MUST_EMAIL', 'RT_DocuSign'),
                        autoClose: true
                    });
                }
            }
        }
    }
})
