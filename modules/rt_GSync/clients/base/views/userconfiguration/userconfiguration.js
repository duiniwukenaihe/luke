({
    className: 'customMainPane',
    events: {
        'click #save_button': 'handleSave',
        'click #cancel_button': 'handleCancel',
        'click .refreshPAGE': 'refreshPAGE',
        'click #enable_all_users': 'enable_all_users'
    },
    title: null,
    isRepaired: null,
    active_users: null,
    enabled_active_users: null,
    continueURL: null,
    usersObject: null,
    users_mulitiselect: [],
    selected: [],
    select2Onchange: true,
    initialize: function (options) {
        if (app.user.get('type') == 'admin') {
            this._super('initialize', [options]);
            this.isAdmin = true;
        } else {
            app.router.navigate('#rt_GSync', {trigger: true});
        }
        this.continueURL = "#Administration";
        this.usersObject = {active: {}, enabled: {}, disabled: {}};
        this.title = app.lang.get('LBL_GSYNC_USERS_CONFIGURATION', this.module);
        this.LBL_GSYNC_ENABLED_USERS = app.lang.get('LBL_GSYNC_ENABLED_USERS', this.module);
        this.LBL_ALL_USERS = app.lang.get('LBL_ALL_USERS', this.module);
        this.LBL_SAVE_BUTTON_LABEL = app.lang.get('LBL_SAVE_BUTTON_LABEL');
        this.LBL_CANCEL_BUTTON_LABEL = app.lang.get('LBL_CANCEL_BUTTON_LABEL');
        this.LBL_BOOST_LABEL = app.lang.get('LBL_BOOST_LABEL', this.module);
    },
    _render: function () {
        var self = this;
        var data = [];
        _.each(this.usersObject.active, function (value, key) {
            var item = {};
            item.id = key;
            item.text = value;
            if (self.usersObject.enabled && self.usersObject.enabled[key]) {
                item.checked = true;
                self.usersObject.enabled[key] = item;
            } else {
                self.usersObject.disabled[key] = item;
            }
            data.push(item);
        });
        this.users_mulitiselect = data;
        app.view.View.prototype._render.call(this);
        $("#disabled, #enabled").sortable({
            connectWith: ".connectedSortable",
            stop: function (event, ui) {
                self.selectionChanged();

            }
        }).disableSelection();

    },
    selectionChanged: function () {
        this.enabled_active_users = $('#enabled li').length;
        $('#enabled_active_users').html(this.enabled_active_users);
    },
    loadData: function (options) {
        this.getUserConfig();
    },
    getUserConfig: function () {
        app.alert.dismissAll();
        app.alert.show('rtGSync_config', {level: 'process', title: 'Processing'});
        var prefsURL = app.api.buildURL('rt_GSyncConfig/prefs/', null, null, {
            oauth_token: app.api.getOAuthToken(),
            user_id: app.user.get('id'),
            method: 'getUserConfig',
        });
        app.api.call('POST', prefsURL, null, {
            success: _.bind(function (result) {
                this.getUserConfigSuccess(result);
            }, this),

            error: _.bind(function (e) {
                this.configError(e);
            }, this)
        });
    },
    getUserConfigSuccess: function (response) {
        app.alert.dismiss('rtGSync_config');
        if (response && response.data) {
            if (response.data.isRepaired) {
                    this.isRepaired = response.data.isRepaired;
            } else {
                // app.alert.show('rtGSync_config', {autoClose: false, level: 'error',messages:'Do quick repair and rebuild first'});
            }
            if (response.data.active_users) {
                this.active_users = Object.keys(response.data.active_users).length;
                this.usersObject.active = response.data.active_users;
            }
            if (response.data.enabled_active_users) {
                this.enabled_active_users = Object.keys(response.data.enabled_active_users).length;
                this.usersObject.enabled = response.data.enabled_active_users;
            }
        } else {
            app.alert.show('rtGSync_config', {autoClose: false, level: 'error', messages: 'Unable to load'});
        }
        this.isLoaded = true;
        this.render();
    },

    isNumber: function (n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    },
    handleSave: function () {
        app.alert.dismiss('rtGSync_config');

        app.alert.show('rtGSync_config', {level: 'process', title: 'Saving'});
        var selections = $('#enabled li');
        var selectedUserIDS = [];
        _.each(selections, function (value, key) {
            selectedUserIDS.push(value.id);
        });
        var prefsURL = app.api.buildURL('rt_GSyncConfig/prefs/', null, null, {
            oauth_token: app.api.getOAuthToken(),
            selectedUserIDS: selectedUserIDS,
            method: 'setUserConfig',
        });
        app.api.call('POST', prefsURL, null, {
            success: _.bind(function (result) {
                this.saveConfigSuccess(result);
            }, this),

            error: _.bind(function (e) {
                this.configError(e);
            }, this)
        });
    },
    configError: function (error) {
        var msg = {autoClose: false, level: 'error'};
        if (error && _.isString(error.message)) {
            msg.messages = error.message;
        }
        if (error.status == 412 && !error.request.metadataRetry) {
            msg.messages = 'If this page does not reload automatically, please try to reload manually';
        } else {
            app.alert.show('rtGSync_config', msg);
        }
        app.alert.dismiss('rtGSync_config');
        app.logger.error('Failed: ' + error);
    },
    saveConfigSuccess: function (response) {
        app.alert.dismiss('rtGSync_config');
        var self = this;
        if (response && response.data) {
            if (response.data.isRepaired) {
                if (response.data.enabled_active_users) {
                    app.alert.show('rtGSync_config', {autoClose: true, level: 'success', messages: 'Save'});
                } else {
                    app.alert.show('rtGSync_config', {autoClose: false, level: 'error', messages: 'Unable to save'});
                }
            } else {
                app.alert.show('rtGSync_config', {
                    autoClose: false,
                    level: 'error',
                    messages: 'Do quick repair and rebuild first'
                });
                this.isRepaired = false;
            }
            // self.render();
        } else {
            app.alert.show('rtGSync_config', {autoClose: false, level: 'error', messages: 'Unable to save'});
        }
    },

    handleCancel: function () {
        app.router.navigate(this.continueURL, {trigger: true});
    },
    refreshPAGE: function () {
        this.getUserConfig();
    },
    enable_all_users: function () {
        var selections = $('#disabled li');
        _.each(selections, function (value, key) {
            $('#enabled').append(value);
        });
        if (selections && selections.length) {
            this.selectionChanged();
        }
    },
})