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
/**
 * @class View.Fields.Base.FileField
 * @alias SUGAR.App.view.fields.BaseFileField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'FileField',
    
    downloadLink: null,

    newTabLink: null,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.events = _.extend(this.events, {
        	'mousedown [data-action=custom]': 'customHandler'
        });
    },

	customHandler: function(event) {
        switch (event.which) {
            case 1:
                $(event.target).attr('href', this.newTabLink);
            break;
            case 3:
                $(event.target).attr('href', this.downloadLink);
            break;
        }
	},
	
    /**
     * Creates a file object
     * @param {string} value The file name
     * @param {Object} urlOpts URL options
     * @return {Object} The created file object
     * @return {string} return.name The file name
     * @return {string} return.docType The document type
     * @return {string} return.mimeType The file's MIME type
     * @return {string} return.url The file resource url
     * @private
     */
    _createFileObj: function (value, urlOpts) {
        var isImage = this._isImage(this.model.get('file_mime_type')),
                forceDownload = !isImage,
                mimeType = isImage ? 'image' : '',
                docType = this.model.get('doc_type');
        file_mime_type = '';
        file_ext = '';
        filename = '';
        if (!_.isUndefined(this.model.get('file_mime_type'))) {
            file_mime_type = this.model.get('file_mime_type');
        }
        if (!_.isUndefined(this.model.get('file_ext'))) {
            file_ext = this.model.get('file_ext');
        }
        if (!_.isUndefined(this.model.get('filename'))) {
            filename = this.model.get('filename');
        }
        var viewName = this.view.name;
        
        this.downloadLink = app.api.buildFileURL(urlOpts, {htmlJsonFormat: false, passOAuthToken: false, cleanCache: true, forceDownload: forceDownload});
        this.newTabLink = '#bwc/index.php?entryPoint=openpdf&id=' + this.model.get('id')
        
        if ((!_.isEqual(file_mime_type.indexOf('pdf'), -1) ||
                !_.isEqual(file_ext.indexOf('pdf'), -1) ||
                !_.isEqual(filename.indexOf('.pdf'), -1))
                ) {
            mimeType = 'application/pdf';
            return {
                name: value,
                mimeType: mimeType,
                docType: docType,
                url: this.newTabLink,
            };
        } else {
            return {
                name: value,
                mimeType: mimeType,
                docType: docType,
                url: this.downloadLink
            };
        }
    },
})
