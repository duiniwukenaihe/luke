<?php

namespace DRI_Workflow_Task_Templates\Activity;

/**
 * Describes the interface all activity handlers must
 * implement to be compatible with the Customer Journey
 *
 * This layer provides a consistent interface to managing actions that should behave
 * differently depending on what kind of activity module
 *
 * Using this structure makes it possible to add new activity modules
 * or similar in the future by either extending one of the existing
 * abstract classes or create a completely new implementation of this interface.
 * 
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
interface ActivityHandlerInterface
{
    /**
     * @return string
     */
    public function getModuleName();

    /**
     * Checks if a activity is completed
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function isCompleted(\SugarBean $activity);

    /**
     * Checks if a activity is completed
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function isNotApplicable(\SugarBean $activity);

    /**
     * Checks if a activity is started
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function isStarted(\SugarBean $activity);

    /**
     * Checks if a activity have changed status
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function haveChangedStatus(\SugarBean $activity);

    /**
     * Checks if a activity have changed points
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function haveChangedPoints(\SugarBean $activity);

    /**
     * Checks if a activity is blocked by another activity in the journey
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function isBlocked(\SugarBean $activity);

    /**
     * Checks if a activity template is configured with a blocked activity
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function hasBlockedBy(\SugarBean $activity);

    /**
     * Retrieves the activities in the journey that given activity is blocked by
     *
     * @param \SugarBean $activity
     * @return \SugarBean[]
     */
    public function getBlockedBy(\SugarBean $activity);

    /**
     * Retrieves the activity template ids in the journey that given activity is blocked by
     *
     * @param \SugarBean $activity
     * @return string[]
     */
    public function getBlockedByIds(\SugarBean $activity);

    /**
     * Retrieves the activity ids in the journey that given activity is blocked by
     *
     * @param \SugarBean $activity
     * @return string[]
     */
    public function getBlockedByActivityIds(\SugarBean $activity);

    /**
     * Gets called when a activity gets started
     *
     * @param \SugarBean $activity
     * @return bool true if the activity needs to be saved
     */
    public function start(\SugarBean $activity);

    /**
     * Gets called when a activity gets completed
     *
     * @param \DRI_Workflow $journey
     * @param \DRI_SubWorkflow $stage
     * @param \SugarBean $activity
     */
    public function completed(\DRI_Workflow $journey, \DRI_SubWorkflow $stage, \SugarBean $activity);

    /**
     * @param \SugarBean $activity
     * @return bool
     */
    public function calculateStatus(\SugarBean $activity);

    /**
     * Gets called when the activity was completed
     *
     * @param \SugarBean $activity
     * @param \SugarBean $previous
     */
    public function previousActivityCompleted(\SugarBean $activity, \SugarBean $previous);

    /**
     * @param \SugarBean $activity
     * @return \SugarBean|false
     */
    public function getNextChildActivity(\SugarBean $activity);

    /**
     * Creates a new instance of the implemented handlers activity
     *
     * @return \SugarBean
     */
    public function create();

    /**
     * Checks if a activity is not started
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function isNotStarted(\SugarBean $activity);

    /**
     * Checks if a activity is a stage activity
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function isStageActivity(\SugarBean $activity);

    /**
     * Retrieves a activity by stage id and name
     *
     * @param string $stageId
     * @param string $name
     * @param string $skipId
     * @return bool
     * @throws \SugarApiExceptionNotFound
     */
    public function getByStageIdAndName($stageId, $name, $skipId);

    /**
     * Retrieves a activity by stage id and order
     *
     * @param string $stageId
     * @param int $order
     * @param string $skipId
     * @return bool
     * @throws \SugarApiExceptionNotFound
     */
    public function getByStageIdAndOrder($stageId, $order, $skipId);

    /**
     * Checks if a activity with a given order exist on stage
     *
     * @param string $stageId
     * @param int    $order
     * @param string $skipId
     * @return bool
     * @throws \SugarQueryException
     */
    public function orderExistOnStage($stageId, $order, $skipId);

    /**
     * Retrieves a order from a activity
     *
     * @param \SugarBean $activity
     * @return string
     */
    public function getSortOrder(\SugarBean $activity);

    /**
     * Retrieves the points from a activity
     *
     * @param \SugarBean $activity
     * @return int
     */
    public function getPoints(\SugarBean $activity);

    /**
     * @param \SugarBean $activity
     */
    public function calculate(\SugarBean $activity);

    /**
     * Retrieves the points from a activity
     *
     * @param \SugarBean $activity
     * @return int
     */
    public function calculatePoints(\SugarBean $activity);

    /**
     * Sets the score on a activity
     *
     * @param \SugarBean $activity
     * @param int $points
     */
    public function setPoints(\SugarBean $activity, $points);

    /**
     * Retrieves the score from a activity
     *
     * @param \SugarBean $activity
     * @return int
     */
    public function getScore(\SugarBean $activity);

    /**
     * Sets the score on a activity
     *
     * @param \SugarBean $activity
     * @param int $score
     */
    public function setScore(\SugarBean $activity, $score);

    /**
     * Calculates the score of a activity
     *
     * @param \SugarBean $activity
     * @return int
     */
    public function calculateScore(\SugarBean $activity);

    /**
     * Sets the progress on a activity
     *
     * @param \SugarBean $activity
     * @param int $progress
     */
    public function setProgress(\SugarBean $activity, $progress);

    /**
     * Retrieves the progress from a activity
     *
     * @param \SugarBean $activity
     * @return float
     */
    public function getProgress(\SugarBean $activity);

    /**
     * Calculates the progress of a activity
     *
     * @param \SugarBean $activity
     * @return float
     */
    public function calculateProgress(\SugarBean $activity);

    /**
     * Retrieves the activity's related stage
     *
     * @param \SugarBean $activity
     * @return \DRI_SubWorkflow
     */
    public function getStage(\SugarBean $activity);

    /**
     * Retrieves the activity's related stage id
     *
     * @param \SugarBean $activity
     * @return string
     */
    public function getStageId(\SugarBean $activity);

    /**
     * @return string
     */
    public function getStageIdFieldName();

    /**
     * Retrieves the activity's related activity template
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function hasActivityTemplate(\SugarBean $activity);

    /**
     * Retrieves the activity's related activity template
     *
     * @param \SugarBean $activity
     * @return \DRI_Workflow_Task_Template
     */
    public function getActivityTemplate(\SugarBean $activity);

    /**
     * Retrieves the activity's related activity template id
     *
     * @param \SugarBean $activity
     * @return string
     */
    public function getActivityTemplateId(\SugarBean $activity);

    /**
     * Increases the activity's sort order
     *
     * @param \SugarBean $activity
     */
    public function increaseSortOrder(\SugarBean $activity);

    /**
     * Creates a activity from the required parent entities
     *
     * @param \DRI_Workflow_Task_Template $activityTemplate
     * @param \DRI_SubWorkflow $stage
     * @param \SugarBean $parent
     * @return \SugarBean
     */
    public function createFromTemplate(\DRI_Workflow_Task_Template $activityTemplate, \DRI_SubWorkflow $stage, \SugarBean $parent);

    /**
     * Will be called after the activity has been created
     *
     * @param \SugarBean $activity
     * @param \SugarBean $parent
     */
    public function afterCreate(\SugarBean $activity, \SugarBean $parent);

    /**
     * @param \SugarBean $activity
     * @param \SugarBean $parent
     */
    public function relateToParent(\SugarBean $activity, \SugarBean $parent);

    /**
     * Populates a activity from the parent (Account/Contact/Lead etc)
     *
     * @param \SugarBean $activity
     * @param \SugarBean $parent
     */
    public function populateFromParent(\SugarBean $activity, \SugarBean $parent);

    /**
     * Populates a activity from the parent activity (Task/Call/Meeting)
     *
     * @param \SugarBean $activity
     * @param \SugarBean $parentActivity
     */
    public function populateFromParentActivity(\SugarBean $activity, \SugarBean $parentActivity);

    /**
     * Populates a activity from the stage
     *
     * @param \SugarBean $activity
     * @param \DRI_SubWorkflow $stage
     */
    public function populateFromStage(\SugarBean $activity, \DRI_SubWorkflow $stage);

    /**
     * Populates a activity from the stage
     *
     * @param \SugarBean $activity
     * @param \DRI_Workflow_Template $journeyTemplate
     */
    public function populateFromJourneyTemplate(\SugarBean $activity, \DRI_Workflow_Template $journeyTemplate);

    /**
     * Populates a activity from the stage
     *
     * @param \SugarBean $activity
     * @param \DRI_SubWorkflow_Template $stageTemplate
     */
    public function populateFromStageTemplate(\SugarBean $activity, \DRI_SubWorkflow_Template $stageTemplate);

    /**
     * Loads the target handlers activity relationship on a stage.
     *
     * @param \DRI_SubWorkflow $stage
     * @return \SugarBean[]
     */
    public function load(\DRI_SubWorkflow $stage);

    /**
     * @return \SugarQuery
     */
    public function createLoadQuery();

    /**
     * @param \SugarBean $bean
     * @return \SugarBean[]
     */
    public function retrieveChildren(\SugarBean $bean);

    /**
     * Checks if a activity has children
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function isParent(\SugarBean $activity);

    /**
     * Checks if a activity has parent
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function hasParent(\SugarBean $activity);

    /**
     * @param \SugarBean $activity
     * @return \SugarBean
     */
    public function getParent(\SugarBean $activity);

    /**
     * @param \SugarBean $bean
     * @return \SugarBean[]
     */
    public function getChildren(\SugarBean $bean);

    /**
     * @param \SugarBean $bean
     */
    public function loadChildren(\SugarBean $bean);

    /**
     * @param \SugarBean $activity
     * @param \SugarBean $child
     */
    public function insertChild(\SugarBean $activity, \SugarBean $child);

    /**
     * @param \SugarBean $activity
     * @return int
     */
    public function getChildOrder(\SugarBean $activity);

    /**
     * @param \SugarBean $activity
     * @return bool
     */
    public function isProgressChanged(\SugarBean $activity);

    /**
     * @param \SugarBean $activity
     * @return bool
     */
    public function isScoreChanged(\SugarBean $activity);

    /**
     * @param \SugarBean $activity
     * @return bool
     */
    public function isPointsChanged(\SugarBean $activity);

    /**
     * @param \SugarBean $activity
     * @return bool
     */
    public function isStatusChanged(\SugarBean $activity);
}
