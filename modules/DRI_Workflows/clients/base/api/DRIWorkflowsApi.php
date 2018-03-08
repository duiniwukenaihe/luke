<?php

use DRI_Workflow_Task_Templates\Activity\ActivityHandlerFactory;

require_once 'include/api/SugarApi.php';
require_once 'modules/DRI_Workflows/ConnectorHelper.php';

/**
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
class DRIWorkflowsApi extends SugarApi
{
    /**
     * @return array
     */
    public function registerApiRest() {
        return array (
            'chartData' => array(
                'reqType' => 'GET',
                'path' => array('?','?', 'customer-journey', 'chart-data'),
                'pathVars' => array('module', 'record'),
                'method' => 'chartData',
                'shortHelp' => '',
                'longHelp' => '',
                'noEtag' => true,
            ),
            'widgetData' => array(
                'reqType' => 'GET',
                'path' => array('DRI_Workflows','?', 'widget-data'),
                'pathVars' => array('module', 'record'),
                'method' => 'widgetData',
                'shortHelp' => '',
                'longHelp' => '',
                'noEtag' => true,
            ),
            'startCycle' => array(
                'reqType' => 'POST',
                'path' => array('?','?', 'customer-journey', 'start-cycle'),
                'pathVars' => array('module', 'record'),
                'method' => 'startCycle',
                'shortHelp' => '',
                'longHelp' => '',
                'noEtag' => true,
            ),
            'validateLicense' => array(
                'reqType' => 'GET',
                'path' => array('DRI_Workflows', 'validate-license'),
                'pathVars' => array('module', 'record'),
                'method' => 'validateLicense',
                'shortHelp' => '',
                'longHelp' => '',
                'noEtag' => true,
            ),
        );
    }

    /**
     * @param ServiceBase $api
     * @param array       $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     * @throws Exception
     */
    public function chartData(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, array ('module', 'record'));

        try {
            $this->checkLicense();

            $bean = $this->loadBean($api, $args);

            if (!$bean) {
                // Couldn't load the bean
                throw new SugarApiExceptionNotFound('Could not find record: '.$args['record'].' in module: '.$args['module']);
            }

            if ($bean instanceof DRI_Workflow) {
                $journey = $bean;
            } else {
                $bean->load_relationship('dri_workflows');

                $journeys = $bean->dri_workflows->getBeans(array ('orderby' => 'date_entered DESC'));

                $GLOBALS['log']->info("CJ: loading chart data for journey {$bean->id} for parent {$args['module']}:{$args['record']}");

                if (!empty($args['selected'])) {
                    $journey = BeanFactory::retrieveBean('DRI_Workflows', $args['selected']);
                } else {
                    $journey = $this->getChartCycle($journeys);
                }
            }

            $data = array (
                'id' => $journey->id,
                'name' => $journey->name,
                'state' => $journey->state,
                'progress' => $journey->progress,
                'stages' => array (),
            );

            foreach ($journey->getStages() as $stage) {
                $data['stages'][] = array (
                    'id' => $stage->id,
                    'label' => $stage->label,
                    'name' => $stage->name,
                    'state' => $stage->state,
                );
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $data;
    }

    /**
     * @param ServiceBase $api
     * @param array       $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     */
    public function widgetData(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, array ('module', 'record'));

        $user_access = true;

        try {
            $this->checkLicense();
        } catch (\DRI_Workflows\Exception\UserNotAuthorizedException $e) {
            $user_access = false;
        }

        /** @var DRI_Workflow $journey */
        $journey = $this->loadBean($api, $args);

        $fields = array(
            'id',
            'name',
            'progress',
            'state',
            'score',
            'points',
            'description',
            'dri_workflow_template_id',
        );

        foreach ($journey->getParentDefinitions() as $def) {
            $fields[] = $def['name'];
            $fields[] = $def['id_name'];
        }

        // start with loading the complete journey so we
        // can do this in the most optimised fashion
        $journey->load();

        $data = $this->formatBean($api, array ('fields' => $fields), $journey);
        $data['stages'] = array ();
        $data['user_access'] = $user_access;

        $GLOBALS['log']->info("CJ: loading widget data for journey {$journey->id} for parent {$args['module']}:{$args['record']}");

        if ($user_access) {
            foreach ($journey->getStages() as $stage) {
                $data['stages'][] = $this->formatStage($api, $args, $stage);
            }
        }

        return $data;
    }

    /**
     * @param DRI_Workflow[] $journeys
     * @return DRI_Workflow
     * @throws SugarApiExceptionNotFound
     */
    private function getChartCycle(array $journeys)
    {
        if (count($journeys) === 0) {
            throw new SugarApiExceptionNotFound();
        }

        foreach ($journeys as $journey) {
            if ($journey->state !== DRI_Workflow::STATE_COMPLETED) {
                return $journey;
            }
        }

        $journey = array_shift($journeys);

        if (!($journey instanceof DRI_Workflow)) {
            throw new SugarApiExceptionNotFound();
        }

        return $journey;
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function validateLicense(ServiceBase $api, array $args)
    {
        $this->checkLicense();
        return array ();
    }

    /**
     *
     */
    private function checkLicense()
    {
        $helper = new \DRI_Workflows\ConnectorHelper();
        $helper->checkLicense();
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     */
    public function startCycle(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, array ('module', 'record', 'template_id'));
        $this->checkLicense();
        $bean = $this->loadBean($api, $args);

        $GLOBALS['log']->info("CJ: starting journey template {$args['template_id']} on parent {$args['module']}:{$args['record']}");

        DRI_Workflow::start($bean, $args['template_id']);

        return $this->formatBean($api, $args, $bean);
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @param \DRI_SubWorkflow $stage
     * @return array
     */
    protected function formatStage(ServiceBase $api, array $args, $stage)
    {
        $fields = array (
            'id',
            'name',
            'label',
            'sort_order',
            'state',
            'score',
            'points',
            'progress',
        );

        $data = $this->formatBean($api, array('fields' => $fields), $stage);

        $data['progress'] = (float)$data['progress'];
        $data['progress'] *= 100;
        $data['progress'] = round($data['progress']);

        $data['activities'] = array();
        foreach ($stage->getActivities() as $activity) {
            $data['activities'][] = $this->formatActivity($api, $args, $activity);
        }

        return $data;
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @param \SugarBean $activity
     * @return array
     */
    protected function formatActivity(ServiceBase $api, array $args, \SugarBean $activity)
    {
        $fields = array (
            'id',
            'name',
            'status',
            'dri_workflow_sort_order',
            'customer_journey_type',
            'customer_journey_score',
            'customer_journey_progress',
            'customer_journey_points',
            'customer_journey_parent_activity_type',
            'is_customer_journey_parent_activity',
            'is_customer_journey_activity',
            'dri_subworkflow_id',
            'customer_journey_parent_activity_id',
            'assigned_user_id',
            'assigned_user_name',
        );

        if ($activity instanceof Task) {
            $fields[] = 'date_due';
        } else {
            $fields[] = 'date_start';
        }

        $data = $this->formatBean($api, array ('fields' => $fields), $activity);
        $data['customer_journey_progress'] *= 100;
        $data['customer_journey_progress'] = round($data['customer_journey_progress']);

        $activityHandler = ActivityHandlerFactory::factory($activity->module_dir);

        $data['blocked_by'] = $activityHandler->getBlockedByActivityIds($activity);

        if ($activityHandler->hasParent($activity)) {
            $parent = $activityHandler->getParent($activity);

            if ($parent) {
                $parentHandler = ActivityHandlerFactory::factory($parent->module_dir);

                if ($parentHandler->isBlocked($parent)) {
                    $data['blocked_by'] = array_merge($data['blocked_by'], $parentHandler->getBlockedByActivityIds($parent));
                    $data['blocked_by'] = array_unique($data['blocked_by']);
                }
            }
        }

        if (!empty($data['assigned_user_id'])) {
            $user = BeanFactory::retrieveBean('Users', $data['assigned_user_id']);
            $userData = $this->formatBean($api, $args, $user);
            $data['assigned_user'] = $userData;
        }

        if ($activityHandler->isParent($activity)) {
            $data['children'] = array();
            foreach ($activityHandler->getChildren($activity) as $child) {
                $data['children'][] = $this->formatActivity($api, $args, $child);
            }
        }

        return $data;
    }
}
