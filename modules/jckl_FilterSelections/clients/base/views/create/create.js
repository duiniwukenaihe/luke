/**
 * Created by shad on 5/6/17.
 */
({

    extendsFrom: 'CreateView',

    initialize: function(options) {

        this._super('initialize', [options]);

        if (_.isEmpty(this.model.get('user_id_c'))) {
            this.model.setDefault({
                'user_id_c': app.user.id,
                'selected_from_user': app.user.get('full_name')
            });
        }

    },


    /*populateFilterOptions: function () {

     var self = this;

     var user_id = this.model.get('user_id_c');

     debugger;
     if (!_.isEmpty(user_id)) {

     app.alert.show('jckl_loading_filters', {level: 'process', title: app.lang.get('LBL_RETRIEVING_FILTERS', this.module), autoClose: false});


     var params = {
     'filters': 'created_by=' + user_id,
     }
     var url = app.api.buildURL('Filters',null,null, params);

     callbacks = {
     success: function(data,response) {

     if(data) {

     self.populateFilterList(data);

     app.alert.dismiss('jckl_loading_filters');
     } else {
     console.log(data);
     }
     }
     };

     app.api.call('read',url, null,callbacks, {});


     }
     },

     populateFilterList: function (options) {

     var meta = app.metadata.getModule(this.module);
     var filter_id_field = meta.fields.filter_options;

     var filter_options = this.model.fields['filter_options'];
     // filter_options.options =  {'1': '1', '2':'2'};
     $("[data-fieldname=filter_options] input").select2('enable');
     filter_options._render();
     // filter_id_field.options =
     // callback.call(filter_id_field);
     // filter_id_field.render();
     // filter_id_field._render();
     // this._renderField(filter_id_field);
     debugger;
     },*/
    _render: function() {

        this._super('_render');

    },

    _dispose: function() {
        this._super('_dispose');
        app.controller.context.trigger( 'subpanel:reload', {links: ['jckl_filtertemplates_jckl_filterselections']}, null);
    },
})