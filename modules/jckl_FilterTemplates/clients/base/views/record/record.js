/**
 * Created by shad on 5/18/17.
 */
({
    extendsFrom: 'RecordView',

    initialize: function(options) {
        this.plugins.push('LinkedModel');
        this._super('initialize', [options]);

        this.on("render", this.updateIcon, this);

        this.context.on('button:deploy:click', this.deploy_tempate, this);
        this.context.on('button:add_filter:click', this.addFilterSelection,this);
    },

    updateIcon: function() {
        $('.label-jckl_FilterTemplates').css('background-color', '#e0cf05');
        $('.label-jckl_FilterSelections').css('background-color', '#e0a705');
        $('.label-jckl_FilterDeployments').css('background-color', '#e0a705');
    },


    deploy_tempate: function() {
        var self = this;
        //Check for related filters.
        var filters = self.model.getRelatedCollection('jckl_filtertemplates_jckl_filterselections');
        debugger;
        if (filters.length > 0) {
            app.user.set('jckl_template', self.model.get('id'));
            app.router.navigate('#jckl_FilterTemplates/layout/deploy', {trigger: true});
        } else {
            app.alert.show('no_filters_selected', {
                level: 'error',
                title: app.lang.get('LBL_NO_FILTERS_ON_TEMPLATE_TITLE', self.module),
                messages: app.lang.get('LBL_NO_FILTERS_ON_TEMPLATE_MESSAGE', self.module),
                autoClose: true,
            });
        }
    },
    addFilterSelection: function () {
        debugger;
        this.openCreateDrawer('jckl_FilterSelections','jckl_filtertemplates_jckl_filterselections');

    },


})
