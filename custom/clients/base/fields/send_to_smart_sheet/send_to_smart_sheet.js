({
    extendsFrom: "RowactionField",
    /**
     * @inheritDoc
     */
    events: {
        'click [name=send_to_smart_sheet]': 'syncThisRecord',
    },
    syncThisRecord: function () {

        var SyncRecord = app.api.buildURL('synccamrecord');
        app.alert.show('sync-loading-message', {
            level: 'process',
            title: app.lang.get('LBL_LOADING_SYNC_MSG', 'm_CAMS'),
        });


        app.api.call('create', SyncRecord, {'job_number': this.model.get('job_number')}, {
            success: _.bind(function (data) {
                console.log('success called');
                app.alert.show('sync-message-id', {
                    level: 'success',
                    messages: app.lang.get('LBL_SUCCESS_SYNC_MSG', 'm_CAMS'),
                    autoClose: true
                });

                app.alert.dismiss('sync-loading-message');

            }, this),
            /*error: _.bind(function () {
                app.alert.dismiss('sync-loading-message');
                app.alert.show('sync-message-id', {
                    level: 'error',
                    messages: app.lang.get('LBL_FAILED_SYNC_MSG', 'm_CAMS'),
                    autoClose: true
                });
            }, this),*/
        });
    },
})
