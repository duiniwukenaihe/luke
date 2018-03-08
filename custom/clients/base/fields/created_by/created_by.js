/*
 * Customize for Created By User
 */
({
    custom_href: null,
    initialize: function (options) {
        this._super('initialize', [options]);
        this.updateLink();
    },
    updateLink: function () {
        this.custom_href = '#Users/' + this.model.get('created_by_id');
        
    },
})