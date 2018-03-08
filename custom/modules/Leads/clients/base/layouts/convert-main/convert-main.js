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
	extendsFrom: 'LeadsConvertMainLayout',
	
    /**
    * @inheritdoc
    */
     initialize: function(options) {
        this._super("initialize", [options]);
    },
    
	/**
	* When save button is clicked, call the Lead Convert API
	*/
    handleSave: function() {
        var self = this,
        convertModel, myURL;
        
        //disable the save button to prevent double click
        this.context.trigger('lead:convert-save:toggle', false);
        app.alert.show('processing_convert', {level: 'process', title: app.lang.get('LBL_SAVING')});
        convertModel = new Backbone.Model(_.extend(
            {'modules' : this.parseEditableFields(this.associatedModels)},
            this.getTransferActivitiesAttributes()
        ));
        myURL = app.api.buildURL('Leads', 'convert', {id: this.context.get('leadsModel').id});
        
        // Set field_duplicateBeanId for fields implementing FieldDuplicate
        _.each(this.convertPanels, function(view, module) {
            if (view && view.createView && convertModel.get('modules')[module]) {
                view.createView.model.trigger('duplicate:field:prepare:save', convertModel.get('modules')[module]);
            }
        }, this);  
        
		app.api.call('create', myURL, convertModel, {
            success: _.bind(function(data){var contactModel;_.each(data,function(key,value){_.each(key,function(k,v){
						if(k._module =="Contacts"){this.contactModel = k;}},this);},this);this.convertSuccess();},this),
            error: _.bind(this.convertError, this)
			});
    },
    
	/** @BHEA
     * Based on success of lead conversion, display the appropriate messages and optionally close the drawer
     * @param {string} level
     * @param {string} message
     * @param {boolean} doClose
     */
    convertComplete: function(level, message, doClose) {
        var leadsModel = this.context.get('leadsModel');
        app.alert.dismiss('processing_convert');
        app.alert.show('convert_complete', {
            level: level,
            messages: app.lang.get(message, this.module, {leadName: app.utils.getRecordName(leadsModel)}),
            autoClose: (level === 'success')
        });
        if (!this.disposed && doClose) {
            this.context.trigger('lead:convert:exit');
            app.drawer.close();
            app.router.navigate('Contacts/' + this.contactModel.id, {trigger: true});
        }
    },
})
