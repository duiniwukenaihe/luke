<?php

/**
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
class DRI_SubWorkflow_Template extends Basic
{
    /**
     * Retrieves a DRI_SubWorkflow_Template with id $id and
     * returns a instance of the retrieved bean
     *
     * @param string $id: the id of the DRI_SubWorkflow_Template that should be retrieved
     * @return DRI_SubWorkflow_Template
     * @throws DRI_SubWorkflow_Templates_Exception_IdNotFound: if not found
     */
    public static function getById($id)
    {
        if (empty($id)) {
            require_once 'modules/DRI_SubWorkflow_Templates/Exception/IdNotFound.php';
            throw new DRI_SubWorkflow_Templates_Exception_IdNotFound($id);
        }

        /** @var DRI_SubWorkflow_Template $bean */
        $bean = BeanFactory::retrieveBean('DRI_SubWorkflow_Templates', $id);

        if (null === $bean)
        {
            require_once 'modules/DRI_SubWorkflow_Templates/Exception/IdNotFound.php';
            throw new DRI_SubWorkflow_Templates_Exception_IdNotFound($id);
        }

        return $bean;
    }

    /**
     * Retrieves a DRI_SubWorkflow_Template with name $name and
     * returns a instance of the retrieved bean
     *
     * @param string $name: the name of the DRI_SubWorkflow_Template that should be retrieved
     * @param string $parentId
     * @param string $skipId
     * @return DRI_SubWorkflow_Template
     * @throws DRI_SubWorkflow_Templates_Exception_NameNotFound
     */
    public static function getByNameAndParent($name, $parentId, $skipId = null)
    {
        $db = DBManagerFactory::getInstance();

        $sql = <<<SQL
            SELECT id
            FROM dri_subworkflow_templates
            WHERE name = '%s'
              AND deleted = 0
              AND dri_workflow_template_id = '%s'
SQL;

        if (!empty($skipId)) {
            $sql .= " AND id != '$skipId'";
        }

        $sql = sprintf($sql, $name, $parentId);
        $id = $db->getOne($sql);

        if (empty($id)) {
            require_once 'modules/DRI_SubWorkflow_Templates/Exception/NameNotFound.php';
            throw new DRI_SubWorkflow_Templates_Exception_NameNotFound($name);
        }

        return self::getById($id);
    }

    /**
     * Retrieves a DRI_SubWorkflow_Template with name $name and
     * returns a instance of the retrieved bean
     *
     * @param string $sortOrder: the name of the DRI_SubWorkflow_Template that should be retrieved
     * @param string $parentId
     * @param string $skipId
     * @return DRI_SubWorkflow_Template
     * @throws DRI_SubWorkflow_Templates_Exception_NameNotFound
     */
    public static function getByOrderAndParent($sortOrder, $parentId, $skipId = null)
    {
        $db = DBManagerFactory::getInstance();

        $sql = <<<SQL
            SELECT id
            FROM dri_subworkflow_templates
            WHERE sort_order = '%s'
              AND deleted = 0
              AND dri_workflow_template_id = '%s'
SQL;

        if (!empty($skipId)) {
            $sql .= " AND id != '$skipId'";
        }

        $sql = sprintf($sql, $sortOrder, $parentId);
        $id = $db->getOne($sql);

        if (empty($id)) {
            require_once 'modules/DRI_SubWorkflow_Templates/Exception/NameNotFound.php';
            throw new DRI_SubWorkflow_Templates_Exception_NameNotFound($sortOrder);
        }

        return self::getById($id);
    }

    public $disable_row_level_security = false;
    public $new_schema = true;
    public $module_dir = 'DRI_SubWorkflow_Templates';
    public $object_name = 'DRI_SubWorkflow_Template';
    public $table_name = 'dri_subworkflow_templates';
    public $importable = true;

    public $team_id;
    public $team_set_id;
    public $team_count;
    public $team_name;
    public $team_link;
    public $team_count_link;
    public $teams;
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $sort_order;
    public $label;
    public $activities;
    public $following;
    public $following_link;
    public $favorite_link;
    public $tag;
    public $tag_link;
    public $points;
    public $related_activities;
    public $locked_fields;
    public $locked_fields_link;
    public $acl_team_set_id;
    public $acl_team_names;
    public $tasks;
    public $meetings;
    public $calls;

    /**
     * @var Link2
     */
    public $dri_subworkflows;

    /**
     * @var Link2
     */
    public $dri_workflow_task_templates;
    public $dri_workflow_template_id;
    public $dri_workflow_template_name;

    /**
     * @var Link2
     */
    public $dri_workflow_template_link;

    /**
     * @param string $interface
     * @return boolean
     */
    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }

        return false;
    }

    /**
     * @return DRI_Workflow_Task_Template[]
     */
    public function getActivityTemplates()
    {
        $bean = BeanFactory::newBean('DRI_Workflow_Task_Templates');

        $query = new SugarQuery();
        $query->from($bean);
        $query->select('*');
        $query->orderBy('sort_order', 'ASC');
        $query->where()
            ->equals('dri_subworkflow_template_id', $this->id)
            ->isEmpty('parent_id');

        return $bean->fetchFromQuery($query);
    }

    /**
     * @return DRI_Workflow_Task_Template
     * @throws SugarApiExceptionNotFound
     */
    public function getLastTask()
    {
        $activityTemplates = $this->getActivityTemplates();

        if (count($activityTemplates) === 0) {
            throw new SugarApiExceptionNotFound();
        }

        return array_pop($activityTemplates);
    }

    /**
     * {@inheritdoc}
     */
    public function save($check_notify = false)
    {
        $this->validateUniqueName();
        $this->setLabel();

        $this->calculatePoints();
        $this->calculateRelatedActivities();

        $isNew = $this->isNew();
        $nameChanged = isset($this->fetched_row['name']) && $this->fetched_row['name'] != $this->name;

        $return = parent::save($check_notify);

        try {
            DRI_Workflow_Template::getById($this->dri_workflow_template_id)->save();
        } catch (\Exception $e) {

        }

        if (!$isNew && $nameChanged) {
            $sql = "UPDATE dri_subworkflows SET name = '%s' WHERE dri_subworkflow_template_id = '%s'";
            $sql = sprintf($sql, $this->name, $this->id);
            DBManagerFactory::getInstance()->query($sql);
        }

        return $return;
    }

    /**
     * Checks if the bean in
     * its current state is new
     * @return boolean
     */
    private function isNew()
    {
        return empty($this->id) || (!empty($this->id) && !empty($this->new_with_id));
    }

    /**
     *
     */
    private function setLabel()
    {
        $order = "{$this->sort_order}";

        if (strlen($order) === 1) {
            $order = "0{$order}";
        }

        $this->label = sprintf('%s. %s', $order, $this->name);
    }

    /**
     * @throws SugarApiExceptionInvalidParameter
     */
    private function validateUniqueName()
    {
        try {
            self::getByNameAndParent($this->name, $this->dri_workflow_template_id, $this->id);
            throw new SugarApiExceptionInvalidParameter(sprintf('template with name %s does already exist', $this->name));
        } catch (DRI_SubWorkflow_Templates_Exception_NotFound $e) {}
    }

    /**
     * @param string $id
     */
    public function mark_deleted($id)
    {
        if ($this->id != $id) {
            $this->retrieve($id);
        }

        $activityTemplates = $this->getActivityTemplates();

        try {
            $journey = $this->getJourneyTemplate();
        } catch (\Exception $e) {
            $journey = null;
        }

        parent::mark_deleted($id);

        foreach ($activityTemplates as $activityTemplate) {
            $activityTemplate->mark_deleted($activityTemplate->id);
        }

        if (null !== $journey && !$journey->deleted) {
            $journey->save();
        }
    }

    /**
     * @return DRI_Workflow_Template
     */
    public function getJourneyTemplate()
    {
        return DRI_Workflow_Template::getById($this->dri_workflow_template_id);
    }

    /**
     *
     */
    private function calculatePoints()
    {
        $sql = "SELECT SUM(points) FROM dri_workflow_task_templates WHERE deleted = 0 AND is_parent = 0 AND dri_subworkflow_template_id = '%s'";
        $sql = sprintf($sql, $this->id);
        $this->points = \DBManagerFactory::getInstance()->getOne($sql) ?: 0;
    }

    /**
     *
     */
    private function calculateRelatedActivities()
    {
        $sql = "SELECT COUNT(id) FROM dri_workflow_task_templates WHERE deleted = 0 AND dri_subworkflow_template_id = '%s'";
        $sql = sprintf($sql, $this->id);
        $this->related_activities = \DBManagerFactory::getInstance()->getOne($sql) ?: 0;
    }
}
