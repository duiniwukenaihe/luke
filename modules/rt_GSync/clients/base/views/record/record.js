({
    events: {'click #save_button': 'handleSave'},
    className: 'customMainPane',
    loaded: null,
    isOnsite: null,
    archive_email: true,
    initialize: function (options) {
        this._super('initialize', [options]);
        this.action = 'edit';
        this.isOnsite = true;

    },
    loadData: function (options) {
        //populate your data
        this.LBL_SAVE_BUTTON_LABEL = app.lang.get('LBL_SAVE_BUTTON_LABEL', this.module);
        this.LBL_CALENDAR_FIELDSET = app.lang.get('LBL_CALENDAR_FIELDSET', this.module);
        this.LBL_CALENDAR_GOOGLE = app.lang.get('LBL_CALENDAR_GOOGLE', this.module);
        this.LBL_CALENDAR_SUGAR = app.lang.get('LBL_CALENDAR_SUGAR', this.module);
        this.LBL_ACTIVATE_JOB = app.lang.get('LBL_ACTIVATE_JOB', this.module);
        this.LBL_CONTACTS_FIELDSET = app.lang.get('LBL_CONTACTS_FIELDSET', this.module);
        this.LBL_DOCUMENTS_FIELDSET = app.lang.get('LBL_DOCUMENTS_FIELDSET', this.module);
        this.LBL_ARCHIVE_EMAILS_FIELDSET = app.lang.get('LBL_ARCHIVE_EMAILS_FIELDSET', this.module);
        this.LBL_JOB_NOT_AVAILABLE = app.lang.get('LBL_JOB_NOT_AVAILABLE', this.module);
        this.title = app.lang.get('LBL_GSYNC_USERS_PREFERENCES', this.module);
        this.LBL_CALENDAR_MEETINGS = app.lang.get('LBL_CALENDAR_MEETINGS', this.module);
        this.LBL_CALENDAR_CALLS = app.lang.get('LBL_CALENDAR_CALLS', this.module);
        this.LBL_CALENDAR_TASKS = app.lang.get('LBL_CALENDAR_TASKS', this.module);
        if (app.user.get('type') == 'admin') {
            this.isAdmin = true;
        }
        this.getPreferences();
    },
    handleSave: function () {
        app.alert.show('rtGSync_config', {level: 'process', title: 'Saving'})
        this.calendar_google = true;
        this.calendar_sugar = true;
        this.calendar_meetings = true;
        this.calendar_calls = $("[data-fieldname=calendar_calls] input").is(':checked');
        this.calendar_tasks = $("[data-fieldname=calendar_tasks] input").is(':checked');

        this.contacts_google = $("[data-fieldname=contacts_google] input").is(':checked');
        this.contacts_sugar = $("[data-fieldname=contacts_sugar] input").is(':checked');
        this.documents_google = $("[data-fieldname=documents_google] input").is(':checked');
        this.documents_sugar = $("[data-fieldname=documents_sugar] input").is(':checked');
        this.activate_calendar = $("[data-fieldname=activate_calendar] input").is(':checked');
        this.activate_contacts = $("[data-fieldname=activate_contacts] input").is(':checked');
        this.activate_documents = $("[data-fieldname=activate_documents] input").is(':checked');
        this.activate_archive_emails = $("[data-fieldname=activate_archive_emails] input").is(':checked');
        this.setPreferences();
    },
    setPreferences: function () {
        var prefsURL = app.api.buildURL('rt_GSyncConfig/prefs/', null, null, {
            oauth_token: app.api.getOAuthToken(),
            user_id: app.user.get('id'),
            method: 'setPreferences',
            contacts_google: this.contacts_google,
            contacts_sugar: this.contacts_sugar,
            documents_google: this.documents_google,
            documents_sugar: this.documents_sugar,
            activate_calendar: this.activate_calendar,
            activate_contacts: this.activate_contacts,
            activate_documents: this.activate_documents,
            activate_archive_emails: this.activate_archive_emails,
            calendar_meetings: this.calendar_meetings,
            calendar_calls: this.calendar_calls,
            calendar_tasks: this.calendar_tasks,
        });
        app.api.call('POST', prefsURL, null, {
            success: _.bind(function (result) {
                this.setPreferencesSuccess(result);
            }, this),

            error: _.bind(function (e) {
                this.prefsError(e);
            }, this)
        });
    },
    setPreferencesSuccess: function (response) {
        app.alert.dismiss('rtGSync_config');
        if (response && response.data && response.data.id) {
            app.alert.show('rtGSync_config', {autoClose: true, level: 'success', messages: 'saved'});
        } else {
            app.alert.show('rtGSync_config', {autoClose: false, level: 'error', messages: 'Unable to save'});
        }
    },
    getPreferences: function () {
        app.alert.dismissAll();
        app.alert.show('rtGSync_config', {level: 'process', title: 'Processing'});
        var prefsURL = app.api.buildURL('rt_GSyncConfig/prefs/', null, null, {
            oauth_token: app.api.getOAuthToken(),
            user_id: app.user.get('id'),
            method: 'getPreferences',
        });
        app.api.call('POST', prefsURL, null, {
            success: _.bind(function (result) {
                this.getPreferencesSuccess(result);
            }, this),

            error: _.bind(function (e) {
                this.prefsError(e);
            }, this)
        });
    },
    getPreferencesSuccess: function (response) {
        app.alert.dismissAll();
        if (response && response.data) {
            if (response.data.calendar_google) {
                this.calendar_google = response.data.calendar_google;
            }
            if (response.data.calendar_sugar) {
                this.calendar_sugar = response.data.calendar_sugar;
            }
            if (response.data.calendar_meetings) {
                this.calendar_meetings = response.data.calendar_meetings;
            }
            if (response.data.calendar_calls) {
                this.calendar_calls = response.data.calendar_calls;
            }
            if (response.data.calendar_tasks) {
                this.calendar_tasks = response.data.calendar_tasks;
            }
            if (response.data.contacts_google) {
                this.contacts_google = response.data.contacts_google;
            }
            if (response.data.contacts_sugar) {
                this.contacts_sugar = response.data.contacts_sugar;
            }
            if (response.data.documents_google) {
                this.documents_google = response.data.documents_google;
            }
            if (response.data.documents_sugar) {
                this.documents_sugar = response.data.documents_sugar;
            }
            //job status
            if (response.data.activate_calendar) {
                this.activate_calendar = response.data.activate_calendar;
            }
            if (response.data.activate_contacts) {
                this.activate_contacts = response.data.activate_contacts;
            }
            if (response.data.activate_documents) {
                this.activate_documents = response.data.activate_documents;
            }
            if (response.data.activate_archive_emails) {
                this.activate_archive_emails = response.data.activate_archive_emails;
            }
            //jobs created or not
            if (response.data.activate_calendar_created) {
                this.activate_calendar_created = response.data.activate_calendar_created;
            }
            if (response.data.activate_contacts_created) {
                this.activate_contacts_created = response.data.activate_contacts_created;
            }
            if (response.data.activate_documents_created) {
                this.activate_documents_created = response.data.activate_documents_created;
            }
            if (response.data.activate_archive_emails_created) {
                this.activate_archive_emails_created = response.data.activate_archive_emails_created;
            }
        }
        // we need to check if the sugar version is 7.10 or above, we need to prevent archive email view from rendering
        if (app.user.get('type') == 'admin') {
            this.checkSugarVersion();
        } else {
            //for regular user we don't show archive email panel, so no need to check sugar_version
            this.loaded = true;
            this.render();
        }
    },

    /**
     * Check current sugar version from Config table using Administration bean
     * if version is 7.10 or greater, we don't need archive email functionality
     *
     * @return {String} SugarCRM version
     */
    checkSugarVersion: function()
    {
        var url = app.api.buildURL('sugar_version');
        app.api.call('read', url, null, {
            success: _.bind(function (sugar_version) {
                if (!_.isEmpty(sugar_version)) {
                    var ver_split = sugar_version.split('.');
                    var base_version = ver_split[0];
                    var sub_version = ver_split[1];
                    if ((parseInt(base_version) == 7 && parseInt(sub_version) >= 10) || 
                        parseInt(base_version) > 7) {
                        //the sugar version is 7.10 or above
                        this.archive_email = false;
                    }
                }
            }, this),
            complete: _.bind(function() {
                this.loaded = true;
                this.render();
            }, this)
        });
    },

    prefsError: function (error) {
        var msg = {autoClose: false, level: 'error'};
        if (error && _.isString(error.message)) {
            msg.messages = error.message;
        }
        if (error.status == 412 && !error.request.metadataRetry) {
            msg.messages = 'If this page does not reload automatically, please try to reload manually';
        }
        app.alert.dismissAll();
        app.alert.show('rtGSync_config', msg);
        app.logger.error('Failed: ' + error);
    },
})