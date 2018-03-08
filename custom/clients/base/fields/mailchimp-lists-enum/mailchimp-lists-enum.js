/**
 * @class View.Fields.Base.CustomMailchimpListsEnumField
 * @alias SUGAR.App.view.fields.BaseCustomMailchimpListsEnumField
 * @extends View.Fields.Base.EnumField
 */
({
    extendsFrom: "EnumField",
    
    dataFetched: false,

    /**
     * Overriddedn to get dropdown options from custom API call
     * @override
     */
    loadEnumOptions: function (fetch, callback) {
        this._super('loadEnumOptions', [fetch, callback]);
        if (!this.dataFetched) {
            this.dataFetched = true;
            this.getMailChimpLists();
        }
    },

    /**
     * Function: getMailChimpLists
     * @returns {Array}
     */
    getMailChimpLists: function() {
        app.alert.dismissAll();
        app.alert.show('loading-lists-in-progress', {
            level: 'process',
            title: 'Loading'
        });
        var model = this.context.get('parentModel') || this.context.get('model');        
        var url = app.api.buildURL('get_mailchimp_lists/'+this.module+'/'+model.id);
        app.api.call('read', url, null, {
            success: _.bind(function (items) {
                var keys = {};
                if (!_.isEmpty(items)) {
                    _.each(items, function(value, key) {
                        keys[key] = value;
                    });
                }
                this.items = _.extend(this.items, keys);
                this.render();
            }, this),
            error: function (e) {
                app.alert.show('loading-lists-status', {
                    level: 'error',
                    messages: 'An error occurred, Details: ' + e.message,
                    autoClose: false
                });
            },
            complete: function() {
                app.alert.dismiss('loading-lists-in-progress');
            }
        });
    }
    
})
