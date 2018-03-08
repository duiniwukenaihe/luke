/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * View for the filter dropdown.
 *
 * Part of {@link View.Layouts.Base.FilterLayout}.
 *
 * @class View.Views.Base.FilterFilterDropdownView
 * @alias SUGAR.App.view.views.BaseFilterFilterDropdownView
 * @extends View.View
 */
({
    tagName: "span",
    className: "table-cell",
    extendsFrom: "FilterFilterDropdownView",

    events: {
        "click .choice-filter.choice-filter-clickable": "handleEditFilter",
        "click .choice-filter-close": "handleClearFilter",
        "click .choice-filter-share": "handleShareFilter",
    },


    labelShareFilter: 'LBL_SHARE_FILTER',
    /**
     * @override
     * @param {Object} opts
     */
    initialize: function(opts) {
        this._super('initialize',[opts]);
    },


    /**
     * Update the text for the selected filter and returns template
     * @param {Object} item
     * @return {string}
     */
    formatSelection: function(item) {
        var ctx = {}, safeString;

        //Don't remove this line. We want to update the selected filter name but don't want to change to the filter
        //name displayed in the dropdown
        item = _.clone(item);

        this.toggleFilterCursor(this.isFilterEditable(item.id));

        if (item.id === 'all_records') {
            item = this.formatAllRecordsFilter(item);
        }

        //Escape string to prevent XSS injection
        safeString = Handlebars.Utils.escapeExpression(item.text);
        // Update the text for the selected filter.
        this.$('.choice-filter-label').html(safeString);

        if (item.id !== 'all_records') {
            this.$('.choice-filter-close').show();
            this.$('.choice-filter-share').show();
        } else {
            this.$('.choice-filter-close').hide();
            this.$('.choice-filter-share').hide();
        }

        ctx.label = app.lang.get(this.labelDropdownTitle);
        ctx.enabled = this.filterDropdownEnabled;

        return this._select2formatSelectionTemplate(ctx);
    },




    /**
     * When a click happens on the close icon, clear the last filter and trigger reinitialize
     * @param {Event} evt
     */
    handleClearFilter: function(evt) {
        //This event is fired within .choice-filter and another event is attached to .choice-filter
        //We want to stop propagation so it doesn't bubble up.
        evt.stopPropagation();
        this.layout.clearLastFilter(this.layout.layout.currentModule, this.layout.layoutType);
        var filterId;
        if (this.context.get('currentFilterId') === this.layout.filters.collection.defaultFilterFromMeta) {
            filterId = 'all_records';
        } else {
            filterId = this.layout.filters.collection.defaultFilterFromMeta;
        }
        this.layout.trigger('filter:select:filter', filterId);
    },

    /**
     * Handle Share Filter Event
     * @param evt
     */
    handleShareFilter: function (evt) {
        evt.stopPropagation();
        var self = this;
        var filterId;
        if (this.context.get('currentFilterId') === this.layout.filters.collection.defaultFilterFromMeta) {
            filterId = 'all_records';
            return;
        } else {
            filterId = this.context.get('currentFilterId');
        }

        app.drawer.open({layout: 'multi-selection-list',
            context: {
                module: 'Users',
                isMultiSelect: true,

            }}, function(models){
            console.log(models);
            self.copyFilterToUsers(models, filterId);
        });


        /**
         * App.drawer.open({layout: 'multi-selection-list',
            context: {
                module: 'Users',
                isMultiSelect: true,

            }}, function(models){
                console.log(models);
            });
         */

    },

    copyFilterToUsers: function (users, filterId) {

        var user_ids = [];
        debugger;
        _.each(users, function(user){
           user_ids.push(user.id);
        });

        if (user_ids.length > 0) {

            app.alert.show('jckl_FilterTemplates_deploying', {level: 'process', title: app.lang.get('STATUS_DEPLOYING_FILTERS', 'jckl_FilterTemplates'), autoClose: false});


            var url = app.api.buildURL('jckl_FilterTemplates/deployFilter');
            var params = {'users': user_ids, 'filter_id': filterId};
            app.api.call('create', url, params, {
               success: function (data) {
                    if (data.success) {
                        app.alert.dismissAll();
                        app.alert.show('jckl_FilterTemplate_deploy_success', {
                            level: 'info',
                            title: app.lang.get('SUCCESS_DEPLOY_TITLE', 'jckl_FilterTemplates'),
                            messages: [app.lang.get('SUCCESS_DEPLOY_RECORDS', 'jckl_FilterTemplates') + data.count],
                            autoClose: true
                        });
                    }
               }
            });
        }

    },

    /**
     * @override
     * @private
     */
    _dispose: function(){
        this._super('_dispose');
    }
})
