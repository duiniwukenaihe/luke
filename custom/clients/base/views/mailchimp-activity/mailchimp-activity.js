/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    plugins: ['Dashlet'],

    className: 'mailchimp-dashlet activity',

    activities: [],

    list_id: null,

    subscriber_hash: null,

    /**
     * @inheritDoc
     */
    bindDataChange: function() {
        this.settings.on('change', function(model) {
            this.activities = [];
            this.list_id = model.get('mailchimp_lists');
            this.loadActivity();
        }, this);
    },

    /**
     * @inheritDoc
     */
    loadActivity: function() {
        if(!_.isEmpty(this.list_id)) {
            app.alert.dismissAll();
            app.alert.show('loading-list-activity-in-progress', {
                level: 'process',
                title: 'Loading'
            });
            this.subscriber_hash = this.model.get('subscriber_hash');
            if(!_.isUndefined(this.list_id) && !_.isEmpty(this.list_id) && !_.isUndefined(this.subscriber_hash) && !_.isEmpty(this.subscriber_hash)) {
                var url = app.api.buildURL('mailchimp');
                var params = {
                    'type': 'dashlet',
                    'activity_type': 'subscriber',
                    'list_id': this.list_id,
                    'subscriber_hash': this.subscriber_hash
                };
                var callback = {
                    success: _.bind(function(activities) {
                        if(!_.isUndefined(activities) && !_.isEmpty(activities)) {
                            this.activities = activities;
                            _.map(this.activities, _.bind(function(activity) {
                                if(!_.isUndefined(activity)) {
                                    if(!_.isUndefined(activity.timestamp)) {
                                        activity.date = this._formatDateTime(activity.timestamp);
                                        activity.time = this._formatDateTime(activity.timestamp, 'HH:mm');
                                        delete activity.timestamp;
                                    }
                                    if(!_.isUndefined(activity.action)) {
                                        activity.action = activity.action.charAt(0).toUpperCase() + activity.action.slice(1).toLowerCase();
                                        activity.action_class = activity.action == 'Sent' ? 'fa-send-o' : (activity.action == 'Click' ? 'fa-hand-o-up' : 'fa-folder-open');
                                    }
                                }
                            }, this));
                        }
                        this.render();
                    }, this),
                    error: function(error) {
                        app.alert.show('loading-list-activity-status', {
                            level: 'error',
                            messages: app.lang.get('LBL_AN_ERROR_OCCURRED_DETAILS') + error,
                            autoClose: false
                        });
                    },
                    complete: function() {
                        app.alert.dismiss('loading-list-activity-in-progress');
                    }
                }
                app.api.call('create', url, params, callback);
            }
        } else {
            this.render();
        }
    },

    /**
     * _formatDateTime
     * @param  Date date   Date to be formatted
     * @param  String format date format
     * @return Date        formated date
     */
    _formatDateTime: function(date, format) {
        format = format || 'MMM YY';
        return moment(date).isValid() ? moment(date).format(format) : null;
    },

})
