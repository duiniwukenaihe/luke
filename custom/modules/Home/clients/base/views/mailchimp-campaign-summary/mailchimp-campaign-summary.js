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

    className: 'mailchimp-dashlet campaign-summary',

    campaigns: [],

    summary: null,

    campaign_id: null,
    
    /**
     * @inheritDoc
     */
    bindDataChange: function() {
        this.settings.on('change', function(model) {
            this.summary = null;
            this.campaign_id = model.get('mailchimp_campaigns');
            this.loadCampaignSummary();
        }, this);
    },

    /**
     * @inheritDoc
     */
    loadCampaignSummary: function() {
        if(!_.isEmpty(this.campaign_id)) {
            app.alert.dismissAll();
            app.alert.show('loading-campaign-summary-in-progress', {
                level: 'process',
                title: 'Loading'
            });
            var url = app.api.buildURL('mailchimp');
            var params = {
                'type': 'dashlet',
                'activity_type': 'campaign',
                'campaign_id': this.campaign_id
            };
            var callback = {
                success: _.bind(function(campaignsSummary) {
                   if(!_.isUndefined(campaignsSummary) && !_.isEmpty(campaignsSummary)) {
                       this.summary = campaignsSummary;
                       if(!_.isUndefined(this.summary.send_time) && !_.isEmpty(this.summary.send_time)) {
                           this.summary.send_time = this._formatDateTime(this.summary.send_time);
                       }
                       if(!_.isUndefined(this.summary.opens) && !_.isEmpty(this.summary.opens) && !_.isUndefined(this.summary.opens.last_open) && !_.isEmpty(this.summary.opens.last_open)) {
                           this.summary.opens.last_open = this._formatDateTime(this.summary.opens.last_open);
                       }
                       if(!_.isUndefined(this.summary.clicks) && !_.isEmpty(this.summary.clicks) && !_.isUndefined(this.summary.clicks.last_click) && !_.isEmpty(this.summary.clicks.last_click)) {
                           this.summary.clicks.last_click = this._formatDateTime(this.summary.clicks.last_click);
                       }
                       if(!_.isUndefined(this.summary.industry_stats) && !_.isEmpty(this.summary.industry_stats) && !_.isUndefined(this.summary.industry_stats.open_rate) && !_.isEmpty(this.summary.industry_stats.open_rate)) {
                           this.summary.industry_stats.open_rate = this._formatNumber(this.summary.industry_stats.open_rate, 1);
                       }
                       if(!_.isUndefined(this.summary.industry_stats) && !_.isEmpty(this.summary.industry_stats) && !_.isUndefined(this.summary.industry_stats.click_rate) && !_.isEmpty(this.summary.industry_stats.click_rate)) {
                           this.summary.industry_stats.click_rate = this._formatNumber(this.summary.industry_stats.click_rate, 1);
                       }
                       if(!_.isUndefined(this.summary.recipient_count) && !_.isEmpty(this.summary.recipient_count)) {
                           this.summary.recipient_count = this._formatNumber(this.summary.recipient_count);
                       }
                   }
                   this.render();
               }, this),
                error: function(error) {
                    app.alert.show('loading-campaign-summary-status', {
                        level: 'error',
                        messages: app.lang.get('LBL_AN_ERROR_OCCURRED_DETAILS') + error,
                        autoClose: false
                    });
                },
                complete: function() {
                    app.alert.dismiss('loading-campaign-summary-in-progress');
                }
            }
            app.api.call('create', url, params, callback);   
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
        format = format || 'MM/DD/YYYY hh:mma';
        return moment(date).isValid() ? moment(date).format(format) : null;
    },

    /**
     * _formatNumber
     * @param  Number number  Number to be formatted
     * @param  integer decimal decimal places to show
     * @return Number         formatted number
     */
    _formatNumber: function(number, decimal) {
        decimal = decimal || 0;
        return new Intl.NumberFormat('en-IN').format(Number(number).toFixed(decimal));
    }
})
