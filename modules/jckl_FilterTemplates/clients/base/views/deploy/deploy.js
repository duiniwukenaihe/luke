

({
    className: 'jckl-filtertemplate-deploy',
    currentStep: 1,

    events:
        {
            'click .nextStep':'nextStep',
            'click .previousStep':'previousStep',
            'click .goToStep':'goToStep',
            'click .selectCategory':'selectCategory',
            'click .selectRecords':'selectRecords',
            'click .deployFilter':'deployTemplates',
            'click .setupComplete':'setupComplete',
            'click .howtoListToggleLink':'howtoListToggleLink',
        },
    initialize: function(opts) {
        app.alert.dismissAll();
        Handlebars.registerPartial('deploy.header', app.template.get('deploy.header.jckl_FilterTemplates'));
        Handlebars.registerPartial('deploy.footer', app.template.get('deploy.footer.jckl_FilterTemplates'));
        app.view.View.prototype.initialize.call(this, opts);
        var current_template = app.user.get('jckl_template');
        console.log('current_template: ' + current_template);
        this.setStep(1);
        this.jckl_category = '';
    },
    _render: function () {
        app.view.View.prototype._render.call(this);

        //initialize any data is required for this step
        if(this.steps[this.currentStep].initializeStep) {
            this.steps[this.currentStep].initializeStep();
        } else {
            this.initializeStep();
        }

        //update display for current step
        $('#jckl-filtertemplate-deploy-status').html(this.steps[this.currentStep].message);

        $('.deploy-steps a.current span').removeClass('badge-inverse');
        $('.deploy-steps a.current').removeClass('current');
        $('#jckl-filtertemplate-deploy-step'+this.getCurrentStep()).addClass('current');
        $('.deploy-steps a.current span').addClass('badge-inverse');

        return this;
    },
    setStep: function(step) {
        this.currentStep = step;
        this.template = app.template.getView('deploy.step'+this.currentStep, 'jckl_FilterTemplates');

        if (!this.template) {
            app.error.handleRenderError(this, 'view_render_denied');
        }
    },
    previousStep: function(e) {
        if (this.isFirstStep()) return;

        if(this.steps[this.currentStep].previousStep) {
            this.setStep(this.steps[this.currentStep].previousStep(e));
        } else {
            this.setStep(this.currentStep - 1);
        }

        this.render();
    },
    nextStep: function(e) {
        if (this.isLastStep()) return;

        if(this.steps[this.currentStep].nextStep) {
            this.setStep(this.steps[this.currentStep].nextStep(e));
        } else {
            this.setStep(this.currentStep + 1);
        }

        this.render();
    },
    goToStep: function(e) {
        var $currentTarget = $(e.currentTarget);

        this.setStep($currentTarget.data('step'));
        this.render();
    },
    getCurrentStep: function() {

        if(this.steps[this.currentStep].getCurrentStep) {
            return this.steps[this.currentStep].getCurrentStep();
        } else {
            return this.currentStep;
        }
    },
    isFirstStep: function() {
        if(this.steps[this.currentStep].isFirstStep) {
            return this.steps[this.currentStep].isFirstStep();
        } else {
            return (this.currentStep <= 1);
        }
    },
    isLastStep: function() {
        if(this.steps[this.currentStep].isLastStep) {
            return this.steps[this.currentStep].isLastStep();
        } else {
            return (this.currentStep == Object.keys(this.steps).length);
        }
    },
    initializeStep: function() {
    },
    setupComplete: function() {
        //redirect to somewhere that gets the user using the add-on immediately
        //for this example we are just going to go to the home page
        app.router.navigate('#Home', {trigger: true});
    },
    steps: {
        1 : {
            message : "Filter Deploy Wizard. Step 1 ...",
            initializeStep : function() {
                app.alert.dismissAll();

            }
        },
        2 : {
            message : "Next ... select records to deploy to",
            initializeStep : function() {
                app.alert.show('jckl_FilterTemplates_loading', {level: 'process', title: app.lang.get('STATUS_RETRIEVING_OPTIONS', 'jckl_FilterTemplates'), autoClose: false});

                // $('#jckl_FilterTemplate_selections').hide();
                var payload = {
                        category: jckl_category
                    },
                    callbacks = {
                        success: function(data,response) {
                            app.alert.dismiss('jckl_FilterTemplate_retrieve_category');
                            if(data.success) {
                                app.alert.show('jckl_FilterTemplate_retrieve_success', {
                                    level: 'info',
                                    title: app.lang.get('SUCCESS_CATEGORY_RETRIEVE_TITLE', 'jckl_FilterTemplates'),
                                    messages: [app.lang.get('SUCCESS_SELECT_RECORDS', 'jckl_FilterTemplates')],
                                    autoClose: true
                                });
                                //console.log(data);
                                $.each(data.options, function (i, item) {
                                    $('#jckl_FilterTemplate_selections').append($('<option>', {
                                        value: item.id,
                                        text : item.name
                                    }));
                                });
                                // $('#jckl_FilterTemplate_selections').show();
                                app.alert.dismissAll();

                            } else {
                                var errorMessages = [app.lang.get('ERR_CATEGORY_RETRIEVE', 'jckl_FilterTemplates')];
                                if(data.message) {
                                    errorMessages.push('<br/><br/>');
                                    errorMessages.push(data.message);
                                }
                                app.alert.show('jckl_FilterTemplate_retrieve_success', {
                                    level: 'error',
                                    title: app.lang.get('ERR_RETRIEVE_FAILED', 'jckl_FilterTemplates'),
                                    messages: errorMessages,
                                    autoClose: false
                                });

                                app.logger.error('Failed to save the api key. ' + error);
                            }
                        }
                    };

                app.api.call('GET', app.api.buildURL('jckl_FilterTemplates/getCategoryData/'+jckl_category), payload, callbacks, {});



            }
        },
        3 : {
            message : "Finally deploy filters...",
            nextStep : function(e) {
                var $currentTarget = $(e.currentTarget);

                var customNextStep = $currentTarget.data('nextstep');
                if (customNextStep == undefined) {
                    return 4;
                } else {
                    return customNextStep;
                }
            },

        },
        4 : {
            message : "That is it...enjoy!",
            getCurrentStep : function() { return 4; },
            initializeStep : function() {
            }
        }

    },

    selectRecords : function() {
        var deploy_records = $('#jckl_FilterTemplate_selections').val();
        var current_template = app.user.get('jckl_template');
        // console.log('selected:' + deploy_records);
        // console.log(current_template);
        // console.log(jckl_category);
        debugger;
        if(!$.trim(deploy_records).length || !$.trim(current_template).length || !$.trim(jckl_category).length ) {
            app.alert.show('jckl_FilterTemplates_validation_error', {
                level: 'error',
                title: app.lang.get('ERR_DATA_MISSING_TITLE', 'jckl_FilterTemplates'),
                messages: [app.lang.get('ERR_DATA_MISSING_MESSAGE', 'jckl_FilterTemplates')],
                autoClose: false
            });

            $('#category-group').addClass('error');
            $('#category-group .help-block').show();
            return;
        }
        app.user.set('jckl_deploy_records', deploy_records);
        var self = this;
        self.nextStep();


    },
    selectCategory : function() {
        app.alert.dismissAll();
        $('#category-group').removeClass('error');
        $('#category-group .help-block').hide();


        app.alert.show('jckl_FilterTemplate_retrieve_category', {level: 'process', title: 'LBL_PROCESSING_REQUEST', autoClose: false});

        //check to see if category is set
        jckl_category = $('#jckl_FilterTemplate_category').val();

        if(!$.trim(jckl_category).length) {
            app.alert.show('jckl_FilterTemplates_validation_error', {
                level: 'error',
                title: app.lang.get('ERR_NO_CATEGORY_TITLE', 'jckl_FilterTemplates'),
                messages: [app.lang.get('ERR_NO_CATEGORY_MESSAGE', 'jckl_FilterTemplates')],
                autoClose: false
            });

            $('#category-group').addClass('error');
            $('#category-group .help-block').show();
            return;
        }

        var self = this;
        self.nextStep();

    },
    deployTemplates: function(e) {
        app.alert.dismissAll();
        $('#category-group').removeClass('error');
        $('#category-group .help-block').hide();

        var current_template = app.user.get('jckl_template');
        var deploy_records = app.user.get('jckl_deploy_records');


        app.alert.show('jckl_FilterTemplates_deploying', {level: 'process', title: app.lang.get('STATUS_DEPLOYING_FILTERS', 'jckl_FilterTemplates'), autoClose: false});

        var payload = {
                category          : jckl_category,
                template_id       : current_template,
                deploy_records    : deploy_records,
            },
            callbacks = {
                success: function(data,response) {
                    app.alert.dismissAll();
                    if(data.success) {
                        app.alert.dismissAll();
                        app.alert.show('jckl_FilterTemplate_deploy_success', {
                            level: 'info',
                            title: app.lang.get('SUCCESS_DEPLOY_TITLE', 'jckl_FilterTemplates'),
                            messages: [app.lang.get('SUCCESS_DEPLOY_RECORDS', 'jckl_FilterTemplates') + data.count],
                            autoClose: true
                        });
                        app.router.navigate('#jckl_FilterTemplates/' + current_template,{trigger: true})

                    } else {
                        var errorMessages = [app.lang.get('ERR_CATEGORY_RETRIEVE', 'jckl_FilterTemplates')];
                        if(data.message) {
                            errorMessages.push('<br/><br/>');
                            errorMessages.push(data.message);
                        }
                        app.alert.show('jckl_FilterTemplate_retrieve_success', {
                            level: 'error',
                            title: app.lang.get('ERR_RETRIEVE_FAILED', 'jckl_FilterTemplates'),
                            messages: errorMessages,
                            autoClose: false
                        });

                        app.logger.error('Failed to deploy the filters. ' + error);
                    }
                }
            };
        debugger;

        app.api.call('create', app.api.buildURL('jckl_FilterTemplates/deployTemplate'), payload, callbacks, {});
    },
    howtoListToggleLink: function() {
        $('.howtoListToggle').toggle();
    }

})
