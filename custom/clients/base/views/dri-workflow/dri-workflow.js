/**
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
(function (app) {

    return {

        plugins: [
            'Tooltip',
            'ToggleMoreLess',
            'CssLoader'
        ],

        css: [ 'custom/clients/base/views/dri-workflow/dri-workflow.css' ],

        /**
         * Status values.
         *
         * @property
         */
        MORE_LESS_STATUS: {
            MORE: 'more',
            LESS: 'less'
        },

        events: {
            "click .dri-workflow-info .name": "nameClicked",
            "click .blocked .fa-ban": "blockedActivityClicked",
            "click .well": "activeCycleClicked",
            "click .dri-subworkflow-activity .activity-preview-icon-name": "previewActivityClicked",
            "click .dri-subworkflow-activity .activity-preview-icon": "previewActivityClicked",
            "click .dri-activity-hide-children": "hideActivityChildrenClicked",
            "click .dri-activity-show-children": "showActivityChildrenClicked"
        },

        tplErrorMap: {
            ERROR_INVALID_LICENSE: 'invalid-license'
        },

        className: "dri-workflow-wrapper",

        stageModule: "DRI_SubWorkflows",
        stageLink: "dri_subworkflows",
        activityStageId: "dri_subworkflow_id",
        parentActivityId: "customer_journey_parent_activity_id",
        activitySortOrder: "dri_workflow_sort_order",

        stagesSortable: false,
        activitiesSortable: false,
        modelLinks: true,

        /**
         * {@inheritdoc}
         */
        initialize: function (options) {
            this._super("initialize", [options]);
            this.model.on("change:state", this._setStateClass, this);
            this.model.on("sync", this.reloadViewData, this);
            this._setStateClass();

            this.context.on("workflow:add_stage_button:click", this.addStageClick, this);
            this.context.on("workflow:configure_template_button:click", this.configureTemplateClick, this);
            this.context.on("workflow:delete_button:click", this.deleteCycleClicked, this);

            this.context.on("stage:edit_button:click", this.editStageClick, this);
            this.context.on("stage:delete_button:click", this.deleteModelClick, this);

            this.context.on("stage:add_task_button:click", this.addTask, this);
            this.context.on("stage:add_meeting_button:click", this.addMeeting, this);
            this.context.on("stage:add_call_button:click", this.addCall, this);

            this.context.on("stage:add_sub_task_button:click", this.addSubTask, this);
            this.context.on("stage:add_sub_meeting_button:click", this.addSubMeeting, this);
            this.context.on("stage:add_sub_call_button:click", this.addSubCall, this);

            this.context.on("activity:complete_button:click", this.completeActivityClick, this);
            this.context.on("activity:edit_button:click", this.editActivityClick, this);
            this.context.on("activity:start_button:click", this.startActivityClick, this);
            this.context.on("activity:assign_me_button:click", this.assignMeActivityClick, this);
            this.context.on("activity:delete_button:click", this.deleteModelClick, this);
            this.context.on("activity:not_applicable_button:click", this.notApplicableActivityClick, this);
            this.context.on("activity:preview_button:click", this.previewModel, this);

            var parentContext = this.getParentContext();

            if (parentContext) {
                parentContext.on("change:moreLess", this.toggleParentMoreLess, this);
                parentContext.on("change:moreLess", this.hideWhenParentMoreLessChanged, this);

                this.on("render", this.toggleParentMoreLess, this);

                parentContext.get("parentModel").on("sync", function () {
                    parentContext.set('customer_journey_fetching_parent_model', false);
                }, this);
            }
        },

        /**
         * event handler when clicking on the preview eye icon on a activity
         */
        previewActivityClicked: function (ev) {
            var id = $(ev.currentTarget).data("id");
            var activity = this.activities[id];
            this.previewModel(activity);
        },

        /**
         * Opens the preview view in the intelligence pane
         */
        previewModel: function (activity) {
            app.events.trigger("preview:render", activity, app.data.createBeanCollection(activity.module, [activity]), true);
        },

        /**
         * event handler when clicking on the Configure Template button
         */
        configureTemplateClick: function () {
            var template = app.data.createBean(
                "DRI_Workflow_Templates",
                { id: this.model.get("dri_workflow_template_id") }
            );

            var context = this.context.getChildContext({
                module: "DRI_Workflow_Templates",
                model: template,
                forceNew: true
            });

            app.navigate(context, template);
        },

        /**
         * Sets the current journey as the active one on the record,
         * the active journey is the one that are displayed in the chart dashlet.
         */
        activeCycleClicked: function () {
            var parentModel = this.context.parent && this.context.parent.get("parentModel");
            parentModel && parentModel.trigger("customer_journey:active-cycle:click", this.model.id);
        },

        /**
         * event handler when clicking on the Delete Journey button
         *
         * @param {object} model
         */
        deleteCycleClicked: function (model) {
            app.alert.show('delete_model', {
                level: 'confirmation',
                messages: app.lang.get("NTC_DELETE_CONFIRMATION", model.module),
                onConfirm: _.bind(function () {
                    // we must retrieve the context here since the view
                    // will be disposed when the request is finished.
                    var parentContext = this.context.parent;
                    this.model.destroy({
                        success: _.bind(function () {
                            if (parentContext) {
                                parentContext.get("parentModel").trigger("customer_journey:active-cycle:click", null);
                                parentContext.get("collection").remove(this.model);
                                parentContext.trigger("reload_workflows");
                            }
                        }, this),
                        error: _.bind(function (result) {
                            if (parentContext) {
                                parentContext.get("parentModel").trigger("customer_journey:active-cycle:click", null);
                                parentContext.trigger("reload_workflows");
                            }

                            app.alert.show("error", {
                                level: "error",
                                messages: result.message,
                                autoClose: true
                            });
                        }, this)
                    });
                }, this)
            });
        },

        /**
         * @private
         */
        _setSubworkflowSpan: function () {
            var length = _.size(this.stages);
            if (length < 2) {
                this.subworkflowSpan = "span12";
            } else if (length === 2) {
                this.subworkflowSpan = "span6";
            } else if (length === 3) {
                this.subworkflowSpan = "span4";
            } else if (length > 3) {
                this.subworkflowSpan = "span3";
            }
        },

        /**
         * unbinds events
         */
        unbind: function () {
            this._super("unbind");

            if (this.context.parent) {
                this.context.parent.off(null, null, this);
            }

            if (this.model) {
                this.model.off(null, null, this);
            }
        },

        /**
         * Toggles the panel when the parent layour changes state
         */
        toggleParentMoreLess: function () {
            if (!this.disposed) {
                if (this.context && this.context.parent.get("moreLess") === this.MORE_LESS_STATUS.MORE) {
                    this.show();
                } else {
                    this.hide();
                }
            }
        },

        /**
         *
         */
        hideWhenParentMoreLessChanged: function () {
            if (!this.disposed) {
                this.toggleMoreLess(this.MORE_LESS_STATUS.LESS);
            }
        },

        /**
         * Toggles the panel when the name gets clicked
         */
        nameClicked: function () {
            if (this.hidePanel) {
                this.toggleMoreLess(this.MORE_LESS_STATUS.MORE);
            } else {
                this.toggleMoreLess(this.MORE_LESS_STATUS.LESS);
            }
        },

        /**
         * Highlights the activity that another activity is blocked by
         */
        blockedActivityClicked: function (ev) {
            var $el = $(ev.currentTarget);
            var id = $el.data("id");
            var model = this.activities[id];

            _.each(model.get("blocked_by"), function (blockedById) {
                if (id !== blockedById && this.activities[blockedById]) {
                    var blockedBy = this.activities[blockedById];

                    var $blockedBy = this.$('.dri-subworkflow-activity[data-id="' + blockedById + '"]');
                    $blockedBy.effect("highlight", { color: '#e61718' });

                    if (!_.isEmpty(blockedBy.get(this.parentActivityId))) {
                        this.showActivityChildren(blockedBy.get(this.parentActivityId));
                    }
                }
            }, this);
        },

        /**
         * event handler when clicking on the Assign Me on a activity
         *
         * @param {object} activity
         */
        assignMeActivityClick: function (activity) {
            var self = this;
            this.$el.children().fadeTo("slow", 0.7);
            activity.set("assigned_user_id", app.user.id);
            activity.save(null, {
                success: function () {
                    self.reloadData();
                },
                error: function (result) {
                    self.reloadData();
                    app.alert.show("error", {
                        level: "error",
                        messages: result.message,
                        autoClose: true
                    });
                }
            });
        },

        /**
         * Gets called when the Not Applicable button gets clicked.
         *
         * Updates the activity and reloads the data in the view
         *
         * @param {object} activity
         */
        notApplicableActivityClick: function (activity) {
            var self = this;
            this.$el.children().fadeTo("slow", 0.7);

            switch (activity.module) {
                case "Tasks":
                    activity.set("status", "Not Applicable");
                    break;
                case "Calls":
                    activity.set("status", "Not Held");
                    break;
                case "Meetings":
                    activity.set("status", "Not Held");
                    break;
            }

            activity.save(null, {
                success: function () {
                    self.reloadData();
                },
                error: function (result) {
                    self.reloadData();
                    app.alert.show("error", {
                        level: "error",
                        messages: result.message,
                        autoClose: true
                    });
                }
            });
        },

        /**
         * Deletes a model.
         *
         * @param {object} model
         */
        deleteModelClick: function (model) {
            var self = this;

            app.alert.show('delete_activity', {
                level: 'confirmation',
                messages: app.lang.get("NTC_DELETE_CONFIRMATION", model.module),
                onConfirm: _.bind(function () {
                    this.$el.children().fadeTo("slow", 0.7);
                    model.destroy({
                        success: function () {
                            self.reloadData();
                        },
                        error: function (result) {
                            self.reloadData();
                            app.alert.show("error", {
                                level: "error",
                                messages: result.message,
                                autoClose: true
                            });
                        }
                    });
                }, this)
            });
        },

        /**
         * Opens up the drawer in edit mode to edit a given stage
         *
         * @param {object} stage
         */
        editStageClick: function (stage) {
            var self = this;
            var context = this.getStageContextById(stage.get("id"));

            stage.fetch({
                success: function () {
                    context.set("create", true);
                    context.get("model").link = null;

                    app.drawer.open({
                        module: stage.module,
                        layout: 'create',
                        context: context
                    }, function (context, model) {
                        // only reload if the model was saved, if not - revert all attributes from last sync
                        if (model) {
                            self.reloadData();
                        } else {
                            stage.revertAttributes();
                        }
                    });
                }
            });
        },

        /**
         * Opens up the drawer in edit mode to edit a given activity
         *
         * @param {object} activity
         */
        editActivityClick: function (activity) {
            var self = this;
            var stageContext = this.getStageContextById(activity.get(this.activityStageId));

            activity.fetch({
                success: function () {
                    var context = stageContext.getChildContext({
                        module: activity.module,
                        model: activity,
                        forceNew: true,
                        create: true
                    });

                    app.drawer.open({
                        module: activity.module,
                        layout: 'create',
                        context: context
                    }, function (context, model) {
                        // only reload if the model was saved, if not - revert all attributes from last sync
                        if (model) {
                            self.reloadData();
                        } else {
                            activity.revertAttributes();
                        }
                    });
                }
            });
        },

        /**
         * Adds a task
         *
         * @param {object} stage
         */
        addTask: function (stage) {
            this.addActivity(stage, "Tasks");
        },

        /**
         * Adds a meeting
         *
         * @param {object} stage
         */
        addMeeting: function (stage) {
            this.addActivity(stage, "Meetings");
        },

        /**
         * Adds a call
         *
         * @param {object} stage
         */
        addCall: function (stage) {
            this.addActivity(stage, "Calls");
        },

        /**
         * Adds a activity of given type to a stage
         *
         * @param {object} stage
         * @param {string} module
         */
        addActivity: function (stage, module) {
            var self = this;
            var stageContext = this.getStageContextById(stage.get("id"));

            var parent = this.getParentModel();

            var activity = app.data.createBean(module, {
                dri_subworkflow_id: stageContext.get("model").get("id"),
                dri_subworkflow_name: stageContext.get("model").get("name"),
                parent_type: parent ? parent.module : "",
                parent_name: parent ? (parent.get("name") || parent.get("full_name")) : "",
                parent_id: parent ? parent.id : ""
            });

            var lastActivity = this.stages[stage.id] && _.last(_.toArray(this.stages[stage.id].activities));

            if (lastActivity) {
                activity.set(this.activitySortOrder, parseInt(lastActivity.data[this.activitySortOrder]) + 1);
            }

            var context = stageContext.getChildContext({
                module: module,
                model: activity,
                forceNew: true,
                create: true
            });

            app.drawer.open({
                module: module,
                layout: 'create',
                context: context
            }, function (context, model) {
                // only reload if the model was saved
                if (model) {
                    self.reloadData();
                }
            });
        },

        /**
         * Adds a task
         *
         * @param {object} activity
         */
        addSubTask: function (activity) {
            this.addSubActivity(activity, "Tasks");
        },

        /**
         * Adds a meeting
         *
         * @param {object} activity
         */
        addSubMeeting: function (activity) {
            this.addSubActivity(activity, "Meetings");
        },

        /**
         * Adds a call
         *
         * @param {object} activity
         */
        addSubCall: function (activity) {
            this.addSubActivity(activity, "Calls");
        },

        /**
         * Adds a activity of given type to a activity
         *
         * @param {object} activity
         * @param {string} module
         */
        addSubActivity: function (activity, module) {
            var self = this;
            var order = activity.get(this.activitySortOrder) + ".";
            var stageContext = this.getStageContextById(activity.get(this.activityStageId));

            var parent = this.getParentModel();

            var children = (this.stages[activity.get(this.activityStageId)] && this.stages[activity.get(this.activityStageId)].activities[activity.id])
                ? this.stages[activity.get(this.activityStageId)].activities[activity.id].children
                : {};

            var last = _.last(_.values(children));

            if (last) {
                order = activity.get(this.activitySortOrder) + "." + (parseInt(last.model.get(this.activitySortOrder).split(".")[1]) + 1);
            } else {
                order = activity.get(this.activitySortOrder) + ".1";
            }

            var child = app.data.createBean(module, {
                dri_subworkflow_id: activity.get("dri_subworkflow_id"),
                dri_subworkflow_name: activity.get("dri_subworkflow_name"),
                parent_type: parent ? parent.module : "",
                parent_name: parent ? (parent.get("name") || parent.get("full_name")) : "",
                parent_id: parent ? parent.id : "",
                customer_journey_parent_activity_type: activity.module,
                customer_journey_parent_activity_id: activity.id
            });

            child.set(this.activitySortOrder, order);

            var context = stageContext.getChildContext({
                module: module,
                model: child,
                forceNew: true,
                create: true
            });

            app.drawer.open({
                module: module,
                layout: 'create',
                context: context
            }, function (context, model) {
                // only reload if the model was saved
                if (model) {
                    self.reloadData();
                }
            });
        },

        /**
         * @param {object} ev
         */
        hideActivityChildrenClicked: function (ev) {
            var id = $(ev.currentTarget).data("id");
            this.hideActivityChildren(id);
        },

        /**
         * @param {string} id
         */
        hideActivityChildren: function (id) {
            this.$(".dri-activity-children[data-id=" + id + "]").addClass("hide");
            this.$(".dri-subworkflow-activity[data-id=" + id + "] .dri-activity-show-children").removeClass("hide");
            this.$(".dri-subworkflow-activity[data-id=" + id + "] .dri-activity-hide-children").addClass("hide");
            this.setActivityDisplayChildren(id, this.MORE_LESS_STATUS.LESS);
        },

        /**
         * @param {object} ev
         */
        showActivityChildrenClicked: function (ev) {
            var id = $(ev.currentTarget).data("id");
            this.showActivityChildren(id);
        },

        /**
         * @param {string} id
         */
        showActivityChildren: function (id) {
            this.$(".dri-activity-children[data-id=" + id + "]").removeClass("hide");
            this.$(".dri-subworkflow-activity[data-id=" + id + "] .dri-activity-show-children").addClass("hide");
            this.$(".dri-subworkflow-activity[data-id=" + id + "] .dri-activity-hide-children").removeClass("hide");
            this.setActivityDisplayChildren(id, this.MORE_LESS_STATUS.MORE);
        },

        /**
         * Retrieves a stage context by id
         *
         * @param {string} stageId
         * @returns {object}
         */
        getStageContextById: function (stageId) {
            var stages = this.model.getRelatedCollection(this.stageLink);
            var stage = stages.get(stageId);
            return this.getStageContext(stage);
        },

        /**
         * @param {string} id
         * @returns {string}
         */
        getActivityDisplayChildrenCacheKey: function (id) {
            return app.user.lastState.key('activity_display_children[' + id + ']', this);
        },

        /**
         * @param {string} id
         * @returns {string}
         */
        getActivityDisplayChildren: function (id) {
            var key = this.getActivityDisplayChildrenCacheKey(id);
            return app.user.lastState.get(key);
        },

        /**
         * @param {string} id
         * @param {string} value
         */
        setActivityDisplayChildren: function (id, value) {
            var key = this.getActivityDisplayChildrenCacheKey(id);
            app.user.lastState.set(key, value);
        },

        /**
         * Retrieves a stage context by stage model
         *
         * @param {object} stage
         * @returns {object}
         */
        getStageContext: function (stage) {
            var stageContext;

            stageContext = this.context.getChildContext({
                module: this.stageModule,
                model: stage,
                forceNew: true
            });

            return stageContext;
        },

        /**
         * Creates a new stage and opens up the drawer
         */
        addStageClick: function () {
            var self = this;

            var stage = app.data.createBean(this.stageModule, {
                dri_workflow_id: this.model.get("id"),
                dri_workflow_name: this.model.get("name")
            });

            var lastStage = this.model.getRelatedCollection(this.stageLink).last();

            if (lastStage) {
                stage.set("sort_order", lastStage.get("sort_order") + 1);
            }

            var context = this.context.getChildContext({
                module: this.stageModule,
                model: stage,
                forceNew: true,
                create: true
            });

            app.drawer.open({
                module: this.stageModule,
                layout: 'create',
                context: context
            }, function (context, model) {
                // only reload if the model was saved
                if (model) {
                    self.reloadData();
                }
            });
        },

        /**
         * {@inheritdoc}
         */
        render: function () {
            if (this.model.fields.progress) {
                // make sure to use the right type of progress bar
                this.model.fields.progress.type = 'cj_progress_bar';
            }

            this._super("render");
            this.toggleButtons();
        },

        /**
         * {@inheritdoc}
         */
        _render: function () {
            this._super("_render");

            if (this.stagesSortable) {
                this.initStageSortable();
            }

            if (this.activitiesSortable) {
                this.initActivitySortable();
            }
        },

        /**
         * initializes sortable stages
         */
        initStageSortable: function () {
            var $rows = this.$('.dri-workflow-details > .row-fluid');
            $rows.sortable({
                connectWith: $rows,
                update: _.bind(this.updateStageOrder, this)
            });
        },

        /**
         * initializes sortable activities
         */
        initActivitySortable: function () {
            var $activities = this.$('.dri-stage-activities');

            $activities.sortable({
                connectWith: $activities,
                update: _.bind(this.updateActivityOrder, this)
            });

            this.$('.dri-activity-children').sortable({
                update: _.bind(this.updateSubActivityOrder, this)
            });
        },

        /**
         * Updates the reordered stages
         */
        updateStageOrder: function () {
            var self = this, stages = {}, order = 1, save = [];

            this.$(".dri-workflow-details .dri-subworkflow").each(function () {
                var id = $(this).data("id");

                if (self.stages[id]) {
                    stages[id] = self.stages[id];
                    var model = stages[id].model;
                    if (model.get("sort_order") != order) {
                        model.set("sort_order", order);
                        save.push(function (callback) {
                            model.save(null, {
                                success: function () {
                                    callback(null);
                                }
                            });
                        });
                    }
                }

                order++;
            });

            if (save.length > 0) {
                this.stages = stages;
                this.rows = this.chunk(self.stages, 4);
                this.render();
                save.push(_.bind(function (callback) {
                    this.model.save(null, {
                        success: function () {
                            callback(null);
                        }
                    })
                }, this));

                this.startLoading();
                async.waterfall(save, _.bind(this.reloadData, this));
            }
        },

        /**
         * Updates the reordered activities
         */
        updateActivityOrder: function () {
            var self = this;
            var $activities = this.$('.dri-stage-activities');
            var save = [];

            $activities.each(function () {
                var $this = $(this);
                var stageId = $this.parent().data("id");
                var order = 1;

                $this.children().each(function () {
                    var childOrder = 1;
                    var $row = $(this);
                    var id = $row.data("id");
                    var activity = self.activities[id];

                    if (activity && (activity.get(self.activitySortOrder) != order || activity.get(self.activityStageId) != stageId)) {
                        var children = (self.stages[activity.get(self.activityStageId)] && self.stages[activity.get(self.activityStageId)].activities[activity.id])
                            ? self.stages[activity.get(self.activityStageId)].activities[activity.id].children
                            : [];

                        activity.set(self.activitySortOrder, order);
                        activity.set(self.activityStageId, stageId);

                        save.push(function (callback) {
                            activity.save(null, {
                                success: function () {
                                    callback(null);
                                }
                            });
                        });

                        _.each(children, function (child) {
                            var newOrder = order + "." + childOrder;
                            if (child.model.get(self.activitySortOrder) !== newOrder) {
                                child.model.set(self.activitySortOrder, newOrder);
                                save.push(function (callback) {
                                    child.model.save(null, {
                                        success: function () {
                                            callback(null);
                                        }
                                    });
                                });
                            }

                            childOrder++;
                        });
                    }

                    order++;
                });
            });

            if (save.length > 0) {
                save.push(_.bind(function (callback) {
                    this.model.save(null, {
                        success: function () {
                            callback(null);
                        }
                    })
                }, this));

                this.startLoading();
                async.waterfall(save, _.bind(this.reloadData, this));
            }
        },

        /**
         * Updates the reordered sub activities
         */
        updateSubActivityOrder: function (event, ui) {
            var self = this;
            var order = 1;
            var save = [];
            var $parent = ui.item.parent();
            var parentId = $parent.data("id");
            var parent = this.activities[parentId];
            var parentSortOrder = parent.get(self.activitySortOrder);

            $parent.children().each(function () {
                var $row = $(this);
                var id = $row.data("id");
                var activity = self.activities[id];
                var newOrder = parentSortOrder + "." + order;

                if (activity && activity.get(self.activitySortOrder) !== newOrder) {
                    activity.set(self.activitySortOrder, newOrder);
                    save.push(function (callback) {
                        activity.save(null, {
                            success: function () {
                                callback(null);
                            }
                        });
                    });
                }

                order++;
            });

            if (save.length > 0) {
                this.startLoading();
                async.waterfall(save, _.bind(this.reloadData, this));
            }
        },

        /**
         * Toggles the display of all buttons
         */
        toggleButtons: function () {
            _.each(this.fields, function (field) {
                if (field.def.type === "rowaction") {
                    switch (field.name) {
                        case "activity_not_applicable_button":
                        case "activity_complete_button":
                            if (!this.isClosable(field.model)) {
                                field.hide();

                                // this field may not have been rendered the first time here, make sure to hide it once it get rendered
                                field.on("render", function () {
                                    field.hide();
                                });
                            }
                            break;
                        case "activity_start_button":
                            if (!this.isStartable(field.model)) {
                                field.hide();

                                // this field may not have been rendered the first time here, make sure to hide it once it get rendered
                                field.on("render", function () {
                                    field.hide();
                                });
                            }
                            break;
                        case "activity_assign_me_button":
                            if (!this.isAssignable(field.model)) {
                                field.hide();

                                // this field may not have been rendered the first time here, make sure to hide it once it get rendered
                                field.on("render", function () {
                                    field.hide();
                                });
                            }
                            break;
                    }
                }
            }, this);
        },

        /**
         * Checks if a activity is startable
         *
         * @param activity
         * @returns {boolean}
         */
        isStartable: function (activity) {
            switch (activity.module) {
                case "Tasks":
                    return activity.get("status") !== "In Progress"
                        && activity.get("status") !== "Completed"
                        && activity.get("status") !== "Not Applicable"
                        && !activity.get("is_customer_journey_parent_activity")
                        && (!activity.get("blocked_by") || !activity.get("blocked_by").length);
                default:
                    return false;
            }
        },

        /**
         * Checks if a activity is closable
         *
         * @param activity
         * @returns {boolean}
         */
        isClosable: function (activity) {
            switch (activity.module) {
                case "Tasks":
                    return activity.get("status") !== "Completed"
                        && activity.get("status") !== "Not Applicable"
                        && (!activity.get("blocked_by") || !activity.get("blocked_by").length)
                        && !activity.get("is_customer_journey_parent_activity");
                case "Meetings":
                case "Calls":
                    return activity.get("status") !== "Held"
                        && activity.get("status") !== "Not Held"
                        && (!activity.get("blocked_by") || !activity.get("blocked_by").length)
                        && !activity.get("is_customer_journey_parent_activity");
                default: return false;
            }
        },

        /**
         * Checks if a activity is closable
         *
         * @param activity
         * @returns {boolean}
         */
        isClosed: function (activity) {
            switch (activity.module) {
                case "Tasks":
                    return activity.get("status") === "Completed" || activity.get("status") === "Not Applicable";
                case "Meetings":
                case "Calls":
                    return activity.get("status") === "Held" || activity.get("status") === "Not Held";
                default: return false;
            }
        },

        /**
         * Checks if a activity is assignable
         *
         * @param activity
         * @returns {boolean}
         */
        isAssignable: function (activity) {
            return activity.get("assigned_user_id") !== app.user.id;
        },

        /**
         * Starts a given activity
         *
         * @param {object} activity
         */
        startActivityClick: function (activity) {
            var self = this;
            switch (activity.module) {
                case "Tasks":
                    activity.set("status", "In Progress");
                    break;
                default:
                    return;
            }

            this.$el.children().fadeTo("slow", 0.7);

            activity.save(null, {
                success: function () {
                    self.reloadData();
                },
                error: function (result) {
                    self.reloadData();
                    app.alert.show("error", {
                        level: "error",
                        messages: result.message,
                        autoClose: true
                    });
                }
            });
        },

        /**
         * Completes a given activity
         *
         * @param {object} activity
         */
        completeActivityClick: function (activity) {
            var self = this;
            switch (activity.module) {
                case "Tasks":
                    activity.set("status", "Completed");
                    break;
                case "Meetings":
                case "Calls":
                    activity.set("status", "Held");
                    break;
                default:
                    return;
            }

            this.$el.children().fadeTo("slow", 0.7);

            activity.save(null, {
                success: function () {
                    self.reloadData();
                },
                error: function (result) {
                    self.reloadData();
                    app.alert.show("error", {
                        level: "error",
                        messages: result.message,
                        autoClose: true
                    });
                }
            });
        },

        /**
         * Sets the stateClass based on the state
         *
         * @private
         */
        _setStateClass: function () {
            switch (this.model.get("state")) {
                case "not_started":
                case "not_completed":
                    this.stateClass = "label-warning";
                    break;
                case "in_progress":
                    this.stateClass = "label-info";
                    break;
                case "ready_for_next_step":
                    this.stateClass = "label-pending";
                    break;
                case "completed":
                    this.stateClass = "label-success";
                    break;
                default:
                    this.stateClass = "";
                    break;
            }
        },

        /**
         * Reloads the parent model
         */
        reloadParentModel: function () {
            var parentContext = this.getParentContext();

            if (parentContext) {
                parentContext.set('customer_journey_fetching_parent_model', true);
                parentContext.get('parentModel').fetch();
            }
        },

        /**
         * Reloads the view data
         */
        reloadViewData: function () {
            var parentModel = this.getParentModel();

            if (parentModel) {
                parentModel.trigger("customer_journey_widget_reloading");
            }

            this.loadData();
        },

        /**
         * @returns {object}
         */
        getParentContext: function () {
            return this.context.parent;
        },

        /**
         * @returns {object}
         */
        getParentModel: function () {
            var parentContext = this.getParentContext();

            if (parentContext) {
                return parentContext.get("parentModel");
            }

            var models = [];

            _.each(this.getParentDefinitions(), function (def) {
                if (!_.isEmpty(this.model.get(def.id_name))) {
                    models.push(app.data.createBean(def.module, {
                        id: this.model.get(def.id_name),
                        name: this.model.get(def.name)
                    }));
                }
            }, this);

            return models.shift();
        },

        /**
         * @returns {Array}
         */
        getParentDefinitions: function () {
            var defs = {};

            _.each(this.model.fields, function (def) {
                if (def.customer_journey_parent && def.customer_journey_parent.enabled) {
                    if (!defs[def.customer_journey_parent.rank]) {
                        defs[def.customer_journey_parent.rank] = [];
                    }

                    defs[def.customer_journey_parent.rank].push(def);
                }
            });

            var keys = _.keys(defs).sort();
            var sorted = [];

            _.each(keys, function (k) {
                _.each(defs[k], function (def) {
                    sorted.push(def);
                });
            });

            return sorted;
        },

        /**
         * Reloads the view & parent model data
         */
        reloadData: function () {
            this.reloadViewData();
            this.reloadParentModel();
        },

        /**
         * {@inheritdoc}
         */
        loadData: function (options) {
            if (this.disposed || this.loading) {
                return;
            }

            this.loaded = false;
            this.loading = true;
            this.startLoading();

            var url = app.api.buildURL(this.model.module, 'widget-data', {
                id: this.model.get('id')
            });

            app.api.call('read', url, null, {
                success: _.bind(this.loadCompleted, this),
                error: _.bind(this.loadError, this),
                complete: options ? options.complete : null
            });
        },

        /**
         * start loading effect
         */
        startLoading: function () {
            this.$el.children().fadeTo("slow", 0.7);
        },

        /**
         * done loading effect
         */
        doneLoading: function () {
            this.$el.children().fadeTo("slow", 1);
        },

        /**
         * Processes the data returned from the api
         *
         * @param {object} response
         */
        loadCompleted: function (response) {
            this.loaded = true;
            this.loading = false;

            this.rows = [];
            this.stages = {};
            this.activities = {};

            // Make sure the component is not disposed before updating the model
            if (this.disposed) {
                return;
            }

            this.error = "";
            this.template = app.template.get("dri-workflow");

            this.model.set(response);
            this.model.setSyncedAttributes(this.model.attributes);

            // After we update the model with new status etc this widget may have been disposed..
            if (this.disposed) {
                return;
            }

            var stages = this.model.getRelatedCollection(this.stageLink);
            stages.comparator = 'sort_order';
            stages.reset();

            _.each(response.stages, function (data) {
                var row = this.formatStage(data);
                this.stages[row.model.id] = row;
                stages.add(row.model);
            }, this);

            _.each(this.stages, function (stage) {
                _.each(stage.activities, function (row) {
                    row.blockedBy = this.getBlockedByInfo(row.model);
                }, this);
            }, this);

            this._setSubworkflowSpan();

            this.rows = this.chunk(this.stages, 4);
            this.progress = parseFloat(this.model.get("progress")) * 100;

            this.doneLoading();
            this.render();

            if (this.model.get("state") === "completed") {
                this.toggleMoreLess(this.MORE_LESS_STATUS.LESS, true);
            }
        },

        /**
         * @param {object} data
         * @returns {object}
         */
        formatStage: function (data) {
            var order = 1;
            var stage = app.data.createBean(this.stageModule, data);
            var row = this.createStageData(stage);

            _.each(data.activities, function (data) {
                var activity = this.formatActivity(data, order);
                row.activities[activity.model.id] = activity;
                order++;
            }, this);

            return row;
        },

        /**
         * @param {object} stage
         * @returns {object}
         * @private
         */
        createStageData: function (stage) {
            return {
                data: stage.attributes,
                model: stage,
                stateClass: "",
                activities: {}
            };
        },

        /**
         * @param {object} data
         * @param {int} order
         * @returns {object}
         */
        formatActivity: function (data, order) {
            if (data[this.activitySortOrder] != order) {
                data[this.activitySortOrder] = order;
            }

            var activity = app.data.createBean(data._module, data);

            this.activities[activity.id] = activity;

            var row = this.createActivityData(activity, order);

            if (data.children && data.children.length) {
                var childOrder = 1;

                _.each(data.children, function (data) {
                    var childRow = this.formatActivityChild(data, order + "." + childOrder);
                    row.children[childRow.model.id] = childRow;
                    this.activities[childRow.model.id] = childRow.model;
                    childOrder++;
                }, this);
            }

            return row;
        },

        /**
         * @param {object} data
         * @param {string} order
         * @returns {object}
         */
        formatActivityChild: function (data, order) {
            if (data[this.activitySortOrder] !== order) {
                data[this.activitySortOrder] = order;
            }

            var child = app.data.createBean(data._module, data);
            return this.createActivityData(child, order);
        },

        /**
         * Builds the activity data for presentation
         *
         * @param {object} activity
         * @param {string|int} order
         * @returns {object}
         * @private
         */
        createActivityData: function (activity, order) {
            var picture = activity.get("assigned_user") && activity.get("assigned_user").picture;

            activity.set("pictureUrl", picture ? app.api.buildFileURL({
                module: "Users",
                id: activity.get("assigned_user").id,
                field: "picture"
            }, { cleanCache: false }) : '');

            return {
                data: activity.attributes,
                module: activity.module,
                model: activity,
                order: order,
                icon: this.getIcon(activity),
                iconTooltip: this.getIconTooltip(activity),
                statusLabel: this.getStatusLabel(activity),
                statusClass: this.getStatusClass(activity),
                dueDate: this.getDueDateInfo(activity),
                typeClass: this.getTypeClass(activity),
                isParent: activity.get("children") && activity.get("children").length > 0,
                showChildren: this.getActivityDisplayChildren(activity.id) === this.MORE_LESS_STATUS.MORE,
                children: {}
            };
        },

        /**
         * @param {object} activity
         * @return {object|boolean}
         */
        getBlockedByInfo: function (activity) {
            if (!activity.get("blocked_by") || !activity.get("blocked_by").length) {
                return false;
            }

            var info = {
                text: app.lang.get("LBL_BLOCKED_BY", "DRI_Workflows") + ":"
            };

            var count = 0;
            _.each(activity.get("blocked_by"), function (id) {
                if (activity.id !== id && this.activities[id]) {
                    info.text += "\n" + this.activities[id].get("name");
                    count++;
                }
            }, this);

            if (0 === count) {
                return false;
            }

            return info;
        },

        /**
         * @param {object} activity
         * @return {object|boolean}
         */
        getDueDateInfo: function (activity) {
            var dueDateFields = {
                Tasks: "date_due",
                Calls: "date_start",
                Meetings: "date_start"
            };

            var fieldName = dueDateFields[activity.module];

            if (_.isEmpty(activity.get(fieldName)) || this.isClosed(activity)) {
                return false;
            }

            var emptyDate = app.date("2100-01-01T12:00:00");
            var date = app.date(activity.get(fieldName));
            var now = app.date();
            var tomorrow = app.date().add(1, 'day');

            if (date.formatServer() === emptyDate.formatServer()) {
                return false;
            }

            var info = {
                fromNow: date.fromNow(),
                formatUser: date.formatUser(),
                fieldName: app.lang.get(activity.fields[fieldName].vname, activity.module)
            };

            if (date.isBefore(now)) {
                info.className = 'overdue';
                info.status = app.lang.get('LBL_CUSTOMER_JOURNEY_ACTIVITY_DUE_DATE_OVERDUE', activity.module);
            } else if (date.format('YYYY-MM-DD') === now.format('YYYY-MM-DD')) {
                info.className = 'today';
                info.status = app.lang.get('LBL_CUSTOMER_JOURNEY_ACTIVITY_DUE_DATE_TODAY', activity.module);
            } else if (date.format('YYYY-MM-DD') === tomorrow.format('YYYY-MM-DD')) {
                info.className = 'tomorrow';
                info.status = app.lang.get('LBL_CUSTOMER_JOURNEY_ACTIVITY_DUE_DATE_TOMORROW', activity.module);
            } else {
                info.className = 'future';
                info.status = app.lang.get('LBL_CUSTOMER_JOURNEY_ACTIVITY_DUE_DATE_FUTURE', activity.module);
            }

            info.title = app.lang.get('LBL_CUSTOMER_JOURNEY_ACTIVITY_DUE_DATE_TEXT', activity.module, info);

            if (date.format('YYYY') === now.format('YYYY')) {
                info.text = date.format("MMM D");
            } else {
                info.text = date.format("MMM D, YYYY");
            }

            return info;
        },

        /**
         * Handles the error if returned from the api
         *
         * @param {object} error
         */
        loadError: function (error) {
            this.loaded = true;
            this.loading = false;

            if (this.disposed) {
                return;
            }

            this.doneLoading();

            var tpl = this.tplErrorMap[error.message] || 'error';
            this.error = error;
            this.template = app.template.get('dri-workflow.' + tpl);
            this.render();
        },

        /**
         * https://gist.github.com/timruffles/3377784
         *
         * @param array
         * @param chunkSize
         * @returns {object}
         */
        chunk: function (array,chunkSize) {
            if (_.isObject(array)) {
                array = _.toArray(array);
            }

            return _.reduce(array, function(reducer, item, index) {
                reducer.current.push(item);

                if (reducer.current.length === chunkSize || index + 1 === array.length) {
                    reducer.chunks.push(reducer.current);
                    reducer.current = [];
                }
                return reducer;
            }, { current:[], chunks: [] }).chunks
        },

        /**
         * @param {object} activity
         * @returns {string}
         */
        getIcon: function (activity) {
            switch (activity.module) {
                case "Tasks":
                    switch (activity.get("customer_journey_type")) {
                        case "customer_task":  return "fa-star icon-star";
                        case "milestone":      return "fa-trophy icon-trophy";
                        case "internal_task":  return "fa-user icon-user";
                        case "agency_task":    return "fa-building-o icon-building";
                        case "automatic_task": return "fa-refresh icon-refresh";
                    }
                    break;
                case "Meetings": return "fa-calendar icon-calendar";
                case "Calls":    return "fa-phone icon-phone";
            }
        },

        /**
         * @param {object} activity
         * @returns {string}
         */
        getIconTooltip: function (activity) {
            var activityTypeList = App.lang.getAppListStrings("dri_workflow_task_templates_activity_type_list");
            switch (activity.module) {
                case "Tasks":
                    var typeList = App.lang.getAppListStrings("dri_workflow_task_templates_type_list");
                    return typeList[activity.get("customer_journey_type")] || activityTypeList[activity.module];
                default:
                    return activityTypeList[activity.module];
            }
        },

        /**
         * Returns the status label from a activity model
         *
         * @param {object} activity
         * @returns {string}
         */
        getStatusLabel: function (activity) {
            var statusList = app.lang.getAppListStrings(activity.fields.status.options);
            var status = statusList[activity.get("status")];
            var points = activity.get("customer_journey_points") || 0;
            var score = activity.get("customer_journey_score") || 0;
            var progress = activity.get("customer_journey_progress") || 0;
            var label = points === 1 ? "LBL_WIDGET_POINT" : "LBL_WIDGET_POINTS";
            return status + " - " + progress + "% (" + score + "/" + points + " " + app.lang.get(label, "DRI_Workflows") + ")";
        },

        /**
         * Returns the status class from a activity model
         *
         * @returns {string}
         */
        getStatusClass: function (activity) {
            return "dri-subworkflow-activity-" + activity.get("status").replace(/\s+/, "-").toLowerCase();
        },

        /**
         * Returns the type class from a activity model
         *
         * @returns {string}
         */
        getTypeClass: function (activity) {
            return activity.get("customer_journey_type");
        }
    };
}(SUGAR.App))
