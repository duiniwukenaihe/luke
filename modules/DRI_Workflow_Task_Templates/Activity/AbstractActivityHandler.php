<?php

namespace DRI_Workflow_Task_Templates\Activity;

/**
 * Abstract implementation of a Activity Handler.
 *
 * All OOTB handlers extends from this one.
 *
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
abstract class AbstractActivityHandler implements ActivityHandlerInterface
{
    /**
     * @var string
     */
    protected $linkName;

    /**
     * @var string
     */
    protected $moduleName;

    /**
     * @var array
     */
    private $children;

    /**
     * {@inheritdoc}
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return \BeanFactory::newBean($this->moduleName);
    }

    /**
     * {@inheritdoc}
     */
    public function populateFromTemplate(\SugarBean $activity, \DRI_Workflow_Task_Template $activityTemplate)
    {
        $activity->dri_workflow_task_template_id = $activityTemplate->id;
        $activity->dri_workflow_sort_order = $activityTemplate->sort_order;
        $activity->name = $activityTemplate->name;
        $activity->description = $activityTemplate->description;
        $activity->customer_journey_points = $activityTemplate->points;
        $activity->is_customer_journey_parent_activity = $activityTemplate->is_parent;
        $activity->customer_journey_blocked_by = $activityTemplate->blocked_by;
    }

    /**
     * {@inheritdoc}
     */
    public function afterCreate(\SugarBean $activity, \SugarBean $parent)
    {
        // default no op
    }

    /**
     * {@inheritdoc}
     */
    public function populateFromStage(\SugarBean $activity, \DRI_SubWorkflow $stage)
    {
        $activity->dri_subworkflow_id = $stage->id;
        $activity->dri_subworkflow_name = $stage->name;

        if ($stage->getAssigneeRule() === \DRI_Workflow_Template::ASSIGNEE_RULE_CREATE) {
            $activity->assigned_user_id = $stage->getTargetAssigneeId();
            $activity->team_id = $stage->getTargetTeamId();
            $activity->team_set_id = $stage->getTargetTeamSetId();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function populateFromJourneyTemplate(\SugarBean $activity, \DRI_Workflow_Template $journeyTemplate)
    {
        $activity->dri_workflow_template_id = $journeyTemplate->id;
        $activity->dri_workflow_template_name = $journeyTemplate->name;
    }

    /**
     * {@inheritdoc}
     */
    public function populateFromStageTemplate(\SugarBean $activity, \DRI_SubWorkflow_Template $stageTemplate)
    {
        $activity->dri_subworkflow_template_id = $stageTemplate->id;
        $activity->dri_subworkflow_template_name = $stageTemplate->name;
    }

    /**
     * {@inheritdoc}
     */
    public function populateFromParent(\SugarBean $activity, \SugarBean $parent)
    {
        $activity->parent_type = $parent->module_dir;
        $activity->parent_id = $parent->id;
        $activity->parent_name = $parent->name;
    }

    /**
     * {@inheritdoc}
     */
    public function populateFromParentActivity(\SugarBean $activity, \SugarBean $parent)
    {
        $activity->customer_journey_parent_activity_type = $parent->module_dir;
        $activity->customer_journey_parent_activity_id = $parent->id;
    }

    /**
     * {@inheritdoc}
     */
    public function start(\SugarBean $activity)
    {
        $stage = $this->getStage($activity);

        $save = false;

        if ($stage->getAssigneeRule() === \DRI_Workflow_Template::ASSIGNEE_RULE_STAGE_START) {
            $activity->assigned_user_id = $stage->getTargetAssigneeId();
            $activity->team_id = $stage->getTargetTeamId();
            $activity->team_set_id = $stage->getTargetTeamSetId();
            $save = true;
        }

        if (!empty($activity->id)) {
            foreach ($this->getChildren($activity) as $child) {
                $handler = ActivityHandlerFactory::factory($child->module_dir);
                if ($handler->start($child)) {
                    $child->save();
                }
            }
        }

        return $save;
    }

    /**
     * {@inheritdoc}
     */
    public function completed(\DRI_Workflow $journey, \DRI_SubWorkflow $stage, \SugarBean $activity)
    {
        if ($this->hasParent($activity)) {
            $next = $this->getNextChildActivity($activity);
        } else {
            $next = $journey->getNextActivity($stage, $activity);
        }

        if ($next) {
            $handler = ActivityHandlerFactory::factory($next->module_dir);
            $handler->previousActivityCompleted($next, $activity);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNextChildActivity(\SugarBean $activity)
    {
        $parent = $this->getParent($activity);
        $parentHandler = ActivityHandlerFactory::factory($parent->module_dir);

        foreach ($parentHandler->getChildren($parent) as $next) {
            $nextHandler = ActivityHandlerFactory::factory($next->module_dir);
            if (!$next->deleted && $nextHandler->getChildOrder($next) > $this->getChildOrder($activity)) {
                return $next;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateStatus(\SugarBean $activity)
    {
        $children = $this->getChildren($activity);
        $count = count($children);
        $notStarted = 0;
        $completed = 0;

        foreach ($children as $child) {
            $handler = ActivityHandlerFactory::factory($child->module_dir);
            if ($handler->isNotStarted($child)) {
                $notStarted++;
            } elseif ($handler->isCompleted($child)) {
                $completed++;
            }
        }

        if ($completed === $count) {
            $this->setStatus($activity, $this->getCompletedStatus());
        } elseif ($notStarted === $count) {
            $this->setStatus($activity, $this->getNotStartedStatus());
        } else {
            $this->setStatus($activity, $this->getInProgressStatus());
        }

        return $this->isStatusChanged($activity);
    }

    /**
     * @return string
     */
    abstract protected function getNotStartedStatus();

    /**
     * @return string
     */
    abstract protected function getInProgressStatus();

    /**
     * @return string
     */
    abstract protected function getCompletedStatus();

    /**
     * @param \SugarBean $activity
     * @param string $status
     */
    protected function setStatus(\SugarBean $activity, $status)
    {
        $activity->status = $status;
    }

    /**
     * @param \SugarBean $activity
     * @return bool
     */
    public function isStatusChanged(\SugarBean $activity)
    {
        return $this->isFieldChanged($activity, 'status');
    }

    /**
     * @param \SugarBean $activity
     * @return bool
     */
    public function isPointsChanged(\SugarBean $activity)
    {
        return $this->isFieldChanged($activity, 'customer_journey_points');
    }

    /**
     * @param \SugarBean $activity
     * @return bool
     */
    public function isScoreChanged(\SugarBean $activity)
    {
        return $this->isFieldChanged($activity, 'customer_journey_score');
    }

    /**
     * @param \SugarBean $activity
     * @return bool
     */
    public function isProgressChanged(\SugarBean $activity)
    {
        return $this->isFieldChanged($activity, 'customer_journey_progress');
    }

    /**
     * @param \SugarBean $activity
     * @param string $field
     * @return bool
     */
    protected function isFieldChanged(\SugarBean $activity, $field)
    {
        return $activity->{$field} !== $activity->fetched_row[$field];
    }

    /**
     * {@inheritdoc}
     */
    public function createFromTemplate(
        \DRI_Workflow_Task_Template $activityTemplate,
        \DRI_SubWorkflow $stage,
        \SugarBean $parent
    ) {
        $activity = $this->create();

        $this->populateFromTemplate($activity, $activityTemplate);
        $this->populateFromStage($activity, $stage);
        $this->populateFromStageTemplate($activity, $stage->getTemplate());
        $this->populateFromJourneyTemplate($activity, $stage->getTemplate()->getJourneyTemplate());
        $this->populateFromParent($activity, $parent);

        return $activity;
    }

    /**
     * {@inheritdoc}
     */
    public function relateToParent(\SugarBean $activity, \SugarBean $parent)
    {
        $linkName = $this->getLinkName();
        $this->loadRelationship($parent, $linkName);
        $parent->{$linkName}->add($activity);
    }

    /**
     * {@inheritdoc}
     */
    public function getByStageIdAndName($stageId, $name, $skipId)
    {
        $query = new \SugarQuery();
        $query->from($this->create());
        $query->select('id');
        $where = $query->where();
        $where->equals('dri_subworkflow_id', $stageId);
        $where->equals('name', $name);

        if (null !== $skipId) {
            $where->notEquals('id', $skipId);
        }

        $results = $query->execute();

        if (count($results) === 0) {
            throw new \SugarApiExceptionNotFound();
        }

        $result = array_shift($results);

        return $this->getById($result['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function getByStageIdAndOrder($stageId, $order, $skipId)
    {
        $query = new \SugarQuery();
        $query->from($this->create());
        $query->select('id');
        $where = $query->where();
        $where->equals('dri_subworkflow_id', $stageId);
        $where->equals('dri_workflow_sort_order', $order);

        if (null !== $skipId) {
            $where->notEquals('id', $skipId);
        }

        $results = $query->execute();

        if (count($results) === 0) {
            throw new \SugarApiExceptionNotFound();
        }

        $result = array_shift($results);

        return $this->getById($result['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function getChildOrder(\SugarBean $activity)
    {
        $order = $this->getSortOrder($activity);

        if (false !== strpos($order, '.')) {
            list($_, $order) = explode('.', $order);
        }

        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public function getSortOrder(\SugarBean $activity)
    {
        return (string) $activity->dri_workflow_sort_order;
    }

    /**
     * {@inheritdoc}
     */
    public function getPoints(\SugarBean $activity)
    {
        return (int)$activity->customer_journey_points;
    }

    /**
     * before_save logic hook
     *
     * @param \SugarBean $activity
     */
    public function calculate(\SugarBean $activity)
    {
        $this->setPoints($activity, $this->calculatePoints($activity));
        $this->setScore($activity, $this->calculateScore($activity));
        $this->setProgress($activity, $this->calculateProgress($activity));
    }

    /**
     * {@inheritdoc}
     */
    public function calculatePoints(\SugarBean $activity)
    {
        $points = 0;

        if ($this->isParent($activity)) {
            foreach ($this->getChildren($activity) as $child) {
                $handler = ActivityHandlerFactory::factory($child->module_dir);
                $points += $handler->getPoints($child);
            }
        } else {
            if (!empty($activity->customer_journey_points)) {
                $points = (int)$activity->customer_journey_points;
            } elseif (!empty($activity->dri_workflow_task_template_id)) {
                $template = \DRI_Workflow_Task_Template::getById($activity->dri_workflow_task_template_id);

                if (!empty($template->points)) {
                    $points = (int)$template->points;
                }
            }

            if (0 === $points) {
                $points = $GLOBALS['dictionary']['DRI_Workflow_Task_Template']['fields']['points']['default'];
            }
        }

        return $points;
    }

    /**
     * {@inheritdoc}
     */
    public function setPoints(\SugarBean $activity, $points)
    {
        $activity->customer_journey_points = $points;
    }

    /**
     * {@inheritdoc}
     */
    public function getScore(\SugarBean $activity)
    {
        return (int)$activity->customer_journey_score;
    }

    /**
     * {@inheritdoc}
     */
    public function setScore(\SugarBean $activity, $score)
    {
        $activity->customer_journey_score = $score;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateScore(\SugarBean $activity)
    {
        $score = 0;

        if ($this->isParent($activity)) {
            foreach ($this->getChildren($activity) as $child) {
                $handler = ActivityHandlerFactory::factory($child->module_dir);
                $score += $handler->getScore($child);
            }
        } elseif ($this->isCompleted($activity)) {
            $score = $this->getPoints($activity);
        } elseif ($this->isStarted($activity)) {
            $score = $this->getPoints($activity) * 0.3;
        }

        return $score;
    }

    /**
     * {@inheritdoc}
     */
    public function setProgress(\SugarBean $activity, $progress)
    {
        $activity->customer_journey_progress = $progress;
    }

    /**
     * {@inheritdoc}
     */
    public function getProgress(\SugarBean $activity)
    {
        return $activity->customer_journey_progress;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateProgress(\SugarBean $activity)
    {
        $points = $this->getPoints($activity);
        $score = $this->getScore($activity);
        return $points > 0 ? round($score / $points, 2) : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function increaseSortOrder(\SugarBean $activity)
    {
        $activity->dri_workflow_sort_order++;
    }

    /**
     * {@inheritdoc}
     */
    public function getStage(\SugarBean $activity)
    {
        return \DRI_SubWorkflow::getById($this->getStageId($activity));
    }

    /**
     * {@inheritdoc}
     */
    public function hasActivityTemplate(\SugarBean $activity)
    {
        $id = $this->getActivityTemplateId($activity);
        return !empty($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getActivityTemplate(\SugarBean $activity)
    {
        return \DRI_Workflow_Task_Template::getById($this->getActivityTemplateId($activity));
    }

    /**
     * {@inheritdoc}
     */
    public function getStageId(\SugarBean $activity)
    {
        if (!empty($activity->dri_subworkflow_id)) {
            return $activity->dri_subworkflow_id;
        }

        if ($activity->deleted && !empty($activity->fetched_row['dri_subworkflow_id'])) {
            return $activity->fetched_row['dri_subworkflow_id'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getStageIdFieldName()
    {
        return 'dri_subworkflow_id';
    }

    /**
     * {@inheritdoc}
     */
    public function getActivityTemplateId(\SugarBean $activity)
    {
        if (!empty($activity->dri_workflow_task_template_id)) {
            return $activity->dri_workflow_task_template_id;
        }

        if ($activity->deleted && !empty($activity->fetched_row['dri_workflow_task_template_id'])) {
            return $activity->fetched_row['dri_workflow_task_template_id'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function orderExistOnStage($stageId, $order, $skipId)
    {
        $query = new \SugarQuery();
        $query->from($this->create());
        $query->select('id');
        $where = $query->where();
        $where->equals('dri_workflow_sort_order', $order);
        $where->equals('dri_subworkflow_id', $stageId);

        if (!empty($skipId)) {
            $where->notEquals('id', $skipId);
        }

        $results = $query->execute();

        return count($results) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isStageActivity(\SugarBean $activity)
    {
        return !empty($activity->dri_subworkflow_id)
            || ($activity->deleted && !empty($activity->fetched_row['dri_subworkflow_id']));
    }

    /**
     * Retrieves a activity by id
     *
     * @param string $id
     * @return \SugarBean
     * @throws \SugarApiExceptionNotFound
     */
    protected function getById($id)
    {
        if (empty($id)) {
            throw new \SugarApiExceptionNotFound();
        }

        $activity = \BeanFactory::retrieveBean($this->create()->module_dir, $id);

        if (null === $activity) {
            throw new \SugarApiExceptionNotFound();
        }

        return $activity;
    }

    /**
     * {@inheritdoc}
     */
    public function haveChangedStatus(\SugarBean $activity)
    {
        return $activity->fetched_row_before['status'] !== $activity->status;
    }

    /**
     * {@inheritdoc}
     */
    public function haveChangedPoints(\SugarBean $activity)
    {
        return $activity->fetched_row_before['customer_journey_points'] !== $activity->customer_journey_points;
    }

    /**
     * {@inheritdoc}
     */
    public function isBlocked(\SugarBean $activity)
    {
        if (!$this->hasBlockedBy($activity)) {
            return false;
        }

        $blockedBy = $this->getBlockedBy($activity);

        return !empty($blockedBy);
    }

    /**
     * {@inheritdoc}
     */
    public function isParent(\SugarBean $activity)
    {
        return !empty($activity->is_customer_journey_parent_activity);
    }

    /**
     * {@inheritdoc}
     */
    public function hasParent(\SugarBean $activity)
    {
        return !empty($activity->customer_journey_parent_activity_id);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(\SugarBean $activity)
    {
        return $this->hasParent($activity) ? \BeanFactory::retrieveBean(
            $activity->customer_journey_parent_activity_type,
            $activity->customer_journey_parent_activity_id
        ) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockedByIds(\SugarBean $activity)
    {
        if (empty($activity->customer_journey_blocked_by)) {
            return array ();
        }

        return is_string($activity->customer_journey_blocked_by)
            ? json_decode($activity->customer_journey_blocked_by, true)
            : (is_array($activity->customer_journey_blocked_by) ? $activity->customer_journey_blocked_by : array ());
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockedByActivityIds(\SugarBean $activity)
    {
        $ids = array ();

        foreach ($this->getBlockedBy($activity) as $bean) {
            $ids[] = $bean->id;
        }

        return $ids;
    }

    /**
     * {@inheritdoc}
     */
    public function hasBlockedBy(\SugarBean $activity)
    {
        return count($this->getBlockedByIds($activity)) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockedBy(\SugarBean $activity)
    {
        if (!$this->hasBlockedBy($activity)) {
            return array ();
        }

        $stage = $this->getStage($activity);
        $journey = $stage->getJourney();

        $blockedBy = array ();
        foreach ($this->getBlockedByIds($activity) as $id) {
            $bean = $journey->getActivityByTemplateId($id);

            if ($bean) {
                $handler = ActivityHandlerFactory::factory($bean->module_dir);

                if (!$handler->isCompleted($bean)) {
                    $blockedBy[] = $bean;
                }
            }
        }

        return $blockedBy;
    }

    /**
     * @param \SugarBean $bean
     * @param string $linkName
     * @throws \SugarApiExceptionError
     */
    protected function loadRelationship(\SugarBean $bean, $linkName)
    {
        $bean->load_relationship($linkName);

        if (!($bean->{$linkName} instanceof \Link2)) {
            throw new \SugarApiExceptionError(sprintf('unable to load link: %s', $linkName));
        }
    }

    /**
     * @return string
     */
    protected function getLinkName()
    {
        return $this->linkName;
    }

    /**
     * {@inheritdoc}
     */
    public function load(\DRI_SubWorkflow $stage)
    {
        // really make sure not to load this relationship if the stage is new.
        // If doing this and the id is empty ALL activities in the system not related to a CJ
        // will be retrieved and potentially changed!
        if (empty($stage->id)) {
            return array ();
        }

        $bean = \BeanFactory::newBean($this->moduleName);

        $query = $this->createLoadQuery();
        $query->where()
            ->equals('dri_subworkflow_id', $stage->id);

        return $bean->fetchFromQuery($query);
    }

    /**
     * @return \SugarQuery
     */
    public function createLoadQuery()
    {
        $bean = \BeanFactory::newBean($this->moduleName);

        $query = new \SugarQuery();
        $query->from($bean);
        $query->select('*');
        $query->where()
            ->isEmpty('customer_journey_parent_activity_id');

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveChildren(\SugarBean $bean)
    {
        $query = new \SugarQuery();
        $query->from(\BeanFactory::newBean($this->moduleName));
        $query->select('id');
        $query->where()
            ->equals('customer_journey_parent_activity_id', $bean->id)
            ->equals('customer_journey_parent_activity_type', $bean->module_dir);

        $activities = array ();

        $results = $query->execute();

        foreach ($results as $result) {
            $activities[] = \BeanFactory::retrieveBean($this->moduleName, $result['id']);
        }

        return $activities;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren(\SugarBean $bean)
    {
        $this->loadChildren($bean);

        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function loadChildren(\SugarBean $bean)
    {
        if (null === $this->children) {
            $this->children = array ();

            foreach (ActivityHandlerFactory::all() as $activityHandler) {
                $this->children = array_merge($this->children, $activityHandler->retrieveChildren($bean));
            }

            $this->children = $this->sortChildren($this->children);
        }
    }

    /**
     * @param \SugarBean $activity
     * @param \SugarBean $child
     */
    public function insertChild(\SugarBean $activity, \SugarBean $child)
    {
        foreach ($this->getChildren($activity) as $id => $bean) {
            if ($bean->id === $child->id) {
                $this->children[$id] = $child;
            }
        }
    }

    /**
     * Since all php functions that sorts an array based on a function is blacklisted by the package scanner
     * we have to implement our own algorithm, this is based on quicksort
     *
     * @param \SugarBean[] $activities
     * @return array
     */
    private function sortChildren($activities) {
        if (count($activities) < 2) {
            return $activities;
        }

        $left = $right = array ();
        reset($activities);
        $pivot_key = key($activities);
        $pivotActivity = array_shift($activities);
        $pivot = ActivityHandlerFactory::factory($pivotActivity->module_dir)->getChildOrder($pivotActivity);

        foreach ($activities as $k => $activity) {
            $order = ActivityHandlerFactory::factory($activity->module_dir)->getChildOrder($activity);
            if ($order < $pivot) {
                $left[$k] = $activity;
            } else {
                $right[$k] = $activity;
            }
        }

        return array_merge(
            $this->sortChildren($left),
            array($pivot_key => $pivotActivity),
            $this->sortChildren($right)
        );
    }
}
