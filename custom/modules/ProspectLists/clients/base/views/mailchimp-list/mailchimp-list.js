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
    
    className: 'mailchimp-dashlet list',

    listStats: {},

    /**
     * @inheritDoc
     */
    loadData: function() {
        app.alert.dismissAll();
        app.alert.show('loading-list-in-progress', {
            level: 'process',
            title: 'Loading'
        });
        var list_id = this.model.get('mailchimp_list');
        var url = app.api.buildURL('mailchimp');
        var params = {
            'type': 'dashlet',
            'activity_type': 'targetlist',
            'list_id': list_id
        };
        var callback = {
            success: _.bind(function(listStats) {
                if(!_.isUndefined(listStats) && !_.isEmpty(listStats)) {
                    this.listStats = {
                        name: listStats.name,
                        subscribers: !_.isUndefined(listStats.stats) && !_.isUndefined(listStats.stats.member_count) ? listStats.stats.member_count : '',
                        open_rate: !_.isUndefined(listStats.stats) && !_.isUndefined(listStats.stats.open_rate) ? listStats.stats.open_rate : '',
                        click_rate: !_.isUndefined(listStats.stats) && !_.isUndefined(listStats.stats.click_rate) ? listStats.stats.click_rate : '',
                        list_rating: listStats.list_rating,
                        star_one_class: 'fa-star-o',
                        star_two_class: 'fa-star-o',
                        star_three_class: 'fa-star-o',
                        star_four_class: 'fa-star-o',
                        star_five_class: 'fa-star-o'
                    };
                    if(!_.isUndefined(this.listStats.list_rating)) {
                        if(this.listStats.list_rating == 5) {
                            this.listStats.star_five_class = 'fa-star';
                            this.listStats.star_four_class = 'fa-star';
                            this.listStats.star_three_class = 'fa-star';
                            this.listStats.star_two_class = 'fa-star';
                            this.listStats.star_one_class = 'fa-star';
                        } else if(this.listStats.list_rating > 4 && this.listStats.list_rating < 5) {
                            this.listStats.star_five_class = 'fa-star-half-full';
                            this.listStats.star_four_class = 'fa-star';
                            this.listStats.star_three_class = 'fa-star';
                            this.listStats.star_two_class = 'fa-star';
                            this.listStats.star_one_class = 'fa-star';
                        } else if(this.listStats.list_rating == 4) {
                            this.listStats.star_four_class = 'fa-star';
                            this.listStats.star_three_class = 'fa-star';
                            this.listStats.star_two_class = 'fa-star';
                            this.listStats.star_one_class = 'fa-star';
                        } else if(this.listStats.list_rating > 3 && this.listStats.list_rating < 4) {
                            this.listStats.star_four_class = 'fa-star-half-full';
                            this.listStats.star_three_class = 'fa-star';
                            this.listStats.star_two_class = 'fa-star';
                            this.listStats.star_one_class = 'fa-star';
                        } else if(this.listStats.list_rating == 3) {
                            this.listStats.star_three_class = 'fa-star';
                            this.listStats.star_two_class = 'fa-star';
                            this.listStats.star_one_class = 'fa-star';
                        } else if(this.listStats.list_rating > 2 && this.listStats.list_rating < 3) {
                            this.listStats.star_three_class = 'fa-star-half-full';
                            this.listStats.star_two_class = 'fa-star';
                            this.listStats.star_one_class = 'fa-star';
                        } else if(this.listStats.list_rating == 2) {
                            this.listStats.star_two_class = 'fa-star';
                            this.listStats.star_one_class = 'fa-star';
                        } else if(this.listStats.list_rating > 1 && this.listStats.list_rating < 2) {
                            this.listStats.star_two_class = 'fa-star-half-full';
                            this.listStats.star_one_class = 'fa-star';
                        } else if(this.listStats.list_rating == 1) {
                            this.listStats.star_one_class = 'fa-star';
                        } else if(this.listStats.list_rating > 0 && this.listStats.list_rating < 1) {
                            this.listStats.star_one_class = 'fa-star-half-full';
                        }
                    }
                }
                this.render();
            }, this),
            error: function(error) {
                app.alert.show('loading-list-status', {
                    level: 'error',
                    messages: app.lang.get('LBL_AN_ERROR_OCCURRED_DETAILS') + error,
                    autoClose: false
                });
            },
            complete: function() {
                app.alert.dismiss('loading-list-in-progress');
            }
        }
        app.api.call('create', url, params, callback);
    }
})
