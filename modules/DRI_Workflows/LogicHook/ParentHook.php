<?php

/**
 * This class contains logic hooks related to the Addoptify Customer Journey plugin for the parent modules
 *
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
class DRI_Workflows_LogicHook_ParentHook
{
    /**
     * This logic hook stores the fetched_row before a parent is saved.
     *
     * It makes the fetched_row available after save for self::startJourney
     *
     * @param \SugarBean $bean
     */
    public function saveFetchedRow(\SugarBean $bean)
    {
        $bean->dri_customer_journey_fetched_row = $bean->fetched_row;
    }

    /**
     * This logic hook gets triggered after a parent is saved.
     *
     * If the conditions of self::shouldStartJourney is met, a new journey
     * will be started related to the parent if not already started..
     *
     * If the conditions of self::toRemoveJourneys is met,
     * all non completed journeys will be unlinked
     *
     * @param \SugarBean $bean
     * @throws \SugarApiException
     */
    public function startJourney(\SugarBean $bean)
    {
        try {
            if ($this->shouldStartJourney($bean)) {
                DRI_Workflow::start($bean, $bean->dri_workflow_template_id);
            }
        } catch (\SugarApiException $e) {
            if ('ERROR_INVALID_LICENSE' !== $e->messageLabel) {
                throw $e;
            }
        }
    }

    /**
     * The Journey will be started if the template id is set and one of the following conditions is met:
     *
     *   - the parent is new
     *   - the template id has been changed
     *
     * @param \SugarBean $bean
     * @return bool
     */
    private function shouldStartJourney(\SugarBean $bean)
    {
        return !empty($bean->dri_workflow_template_id)
            && (empty($bean->dri_customer_journey_fetched_row)
                || $bean->dri_workflow_template_id !== $bean->dri_customer_journey_fetched_row['dri_workflow_template_id']);
    }
}
