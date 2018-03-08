<?php

namespace DRI_Workflow_Task_Templates\Activity;

/**
 * Abstract implementation for all appointment activities (Meeting/Call)
 *
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
abstract class AbstractAppointmentHandler extends AbstractActivityHandler
{
    const STATUS_PLANNED = 'Planned';
    const STATUS_HELD = 'Held';
    const STATUS_NOT_HELD = 'Not Held';
    const STATUS_NOT_APPLICABLE = 'Not Applicable';

    /**
     * {@inheritdoc}
     */
    protected function getNotStartedStatus()
    {
        return static::STATUS_PLANNED;
    }

    /**
     * {@inheritdoc}
     */
    protected function getInProgressStatus()
    {
        return static::STATUS_PLANNED;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCompletedStatus()
    {
        return static::STATUS_HELD;
    }

    /**
     * {@inheritdoc}
     */
    public function isCompleted(\SugarBean $activity)
    {
        return in_array($activity->status, array (self::STATUS_HELD, self::STATUS_NOT_HELD), true);
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted(\SugarBean $activity)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isNotStarted(\SugarBean $activity)
    {
        return $activity->status === self::STATUS_PLANNED;
    }

    /**
     * {@inheritdoc}
     */
    public function isNotApplicable(\SugarBean $activity)
    {
        return $activity->status === self::STATUS_NOT_APPLICABLE;
    }

    /**
     * {@inheritdoc}
     */
    public function populateFromTemplate(\SugarBean $activity, \DRI_Workflow_Task_Template $template)
    {
        /** @var \Meeting $activity */
        parent::populateFromTemplate($activity, $template);

        $activity->status = self::STATUS_PLANNED;
        $activity->send_invites = $template->send_invites === \DRI_Workflow_Task_Template::SEND_INVITES_CREATE;

        if ($template->task_due_date_type === \DRI_Workflow_Task_Template::TASK_DUE_DATE_TYPE_DAYS_FROM_CREATED) {
            $this->createDates(
                $template,
                $activity,
                \TimeDate::getInstance()->getNow()
            );
        } else {
            // default to a "empty" start date, we always needs to
            // set a start date for calls/meetings since this field is required
            $this->setDates(
                $template,
                $activity,
                $this->getEmptyStartDate()
            );
        }
    }

    /**
     * Invites the parent Contact/Lead to Meeting/Call
     *
     * {@inheritdoc}
     */
    public function afterCreate(\SugarBean $activity, \SugarBean $parent)
    {
        if ($parent->module_dir === 'Contacts') {
            $activity->load_relationship('contacts');
            $activity->contacts->add($parent->id);
        } elseif ($parent->module_dir === 'Leads') {
            $activity->load_relationship('leads');
            $activity->leads->add($parent->id);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function start(\SugarBean $activity)
    {
        /** @var \Meeting $activity */
        $save = parent::start($activity);

        if (!empty($activity->dri_workflow_task_template_id)) {
            $template = \DRI_Workflow_Task_Template::getById($activity->dri_workflow_task_template_id);

            if ($template->send_invites === \DRI_Workflow_Task_Template::SEND_INVITES_STAGE_START) {
                $activity->send_invites = true;
                $save = true;
            }

            switch ($template->task_due_date_type) {
                case \DRI_Workflow_Task_Template::TASK_DUE_DATE_TYPE_DAYS_FROM_STAGE_STARTED:
                    if ($this->isEmptyStartDate($activity)) {
                        $this->createDates(
                            $template,
                            $activity,
                            \TimeDate::getInstance()->getNow()
                        );
                        $save = true;
                    }

                    break;
            }
        }

        return $save;
    }

    /**
     * {@inheritdoc}
     */
    public function previousActivityCompleted(\SugarBean $activity, \SugarBean $previous)
    {
        if (!empty($activity->dri_workflow_task_template_id)) {
            /** @var \Meeting|\Call $activity */
            $template = \DRI_Workflow_Task_Template::getById($activity->dri_workflow_task_template_id);

            switch ($template->task_due_date_type) {
                case \DRI_Workflow_Task_Template::TASK_DUE_DATE_TYPE_DAYS_FROM_PREVIOUS_ACTIVITY_COMPLETED:
                    if ($this->isEmptyStartDate($activity)) {
                        $this->createDates(
                            $template,
                            $activity,
                            \TimeDate::getInstance()->getNow()
                        );
                        $activity->save();
                    }
                    break;
            }
        }
    }

    /**
     * Checks if the start date is a "empty" start date
     *
     * @param \SugarBean $activity
     * @return bool
     */
    private function isEmptyStartDate(\SugarBean $activity)
    {
        $timeDate = \TimeDate::getInstance();

        if (empty($activity->date_start)) {
            return true;
        }

        $date = $timeDate->fromUser($activity->date_start);

        if (!$date) {
            $date = $timeDate->fromDb($activity->date_start);
        }

        return $timeDate->asDb($date) === $timeDate->asDb($this->getEmptyStartDate());
    }

    /**
     * The empty start date for calls/meetings is a date far ahead in the future
     *
     * @return \DateTime
     */
    private function getEmptyStartDate()
    {
        return new \SugarDateTime('2100-01-01 12:00:00');
    }

    /**
     * @param \DRI_Workflow_Task_Template $template
     * @param \SugarBean $bean
     * @param \DateTime $date
     */
    private function createDates(\DRI_Workflow_Task_Template $template, \SugarBean $bean, \DateTime $date)
    {
        $timeDate = \TimeDate::getInstance();
        $startDate = clone $date;

        // set correct timezone
        $timeDate->tzUser($startDate);

        // add the days
        $startDate->modify(sprintf('+ %d days', $template->task_due_days));

        // set time
        list($hour, $minute) = explode(':', $template->time_of_day);
        $startDate->setTime((int)$hour, (int)$minute, 0);

        $this->setDates($template, $bean, $startDate);
    }

    /**
     * @param \DRI_Workflow_Task_Template $template
     * @param \SugarBean $bean
     * @param $startDate
     */
    private function setDates(\DRI_Workflow_Task_Template $template, \SugarBean $bean, \DateTime $startDate)
    {
        $timeDate = \TimeDate::getInstance();

        // create end date
        $endDate = clone $startDate;

        // add duration hours
        $durationHours = (int)$template->duration_hours;
        if ($durationHours > 0) {
            $endDate->modify(sprintf('+ %s hours', $durationHours));
        }

        // add duration minutes
        $durationMinutes = (int)$template->duration_minutes;
        if ($durationMinutes > 0) {
            $endDate->modify(sprintf('+ %s minutes', $durationMinutes));
        }

        // format and populate data
        $bean->date_start = $timeDate->asUser($startDate);
        $bean->date_end = $timeDate->asUser($endDate);
        $bean->duration_hours = $template->duration_hours;
        $bean->duration_minutes = $template->duration_minutes;
    }
}
