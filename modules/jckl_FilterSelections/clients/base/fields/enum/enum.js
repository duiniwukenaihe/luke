/**
 * Created by shad on 5/10/17.
 */
({

    extendsFrom: 'EnumField',

    list_options: {},

    initialize: function (options) {

        this._super('initialize',[options]);

        this._initEvents();
        var selected_user = this.model.get('user_id_c');
        if ( !_.isEmpty(selected_user)) {
            this.populateFilterOptions();

        }


    },

    _initEvents: function() {

        this._changeSelectedFromUser();
    },

    _changeSelectedFromUser: function () {

        this.model.on('change:user_id_c', this.populateFilterOptions, this);
        this.model.on('change:filter_options', this.jcklFilterOptionsChanged, this);
    },

    jcklFilterOptionsChanged: function () {


        var self = this;
        this.model.set('filter_name',this.$el.context.innerText)
        // console.log(this.$el.context.innerText);
        var filter_id = self.model.get('filter_options');
        self.model.set('filter_id',filter_id);

        _.each(this.list_options, function(item) {

            if (item.id == filter_id) {
                var definitions = item.filter_definition;
                var textstring = JSON.stringify(definitions);

                self.model.set('description', textstring);
                _.each(definitions, function(value,key) {
                    textstring = textstring + ' ' + key + ':' + value;
                });

            }

        });

    },

    populateFilterOptions: function () {

        var self = this;

        var user_id = this.model.get('user_id_c');

        if (!_.isEmpty(user_id)) {

            app.alert.show('jckl_loading_filters', {level: 'process', title: app.lang.get('LBL_RETRIEVING_FILTERS', this.module), autoClose: false});


            var params = {
                filter:[{'created_by':user_id}],
            }
            var url = app.api.buildURL('Filters',null,null, params);

            callbacks = {
                success: function(data,response) {

                    if(data) {

                        self.populateFilterList(data);
                        self.model.fields['filter_options']['readonly'] = false;
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

        var self = this;
        var new_list = {};
        var records = options.records;
        this.list_options = records;
        debugger;
        if (records.length > 0) {
            _.each(records, function(record) {
                // Only work on key => value pairs that are not both blank

                new_list[record.id] = record.name;

            });
        } else {
            new_list[0] = 'No Filters for User'
        }
        self.items = new_list;
    },
})