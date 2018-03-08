<?PHP
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/jckl_FilterTemplates/jckl_FilterTemplates_sugar.php');
class jckl_FilterTemplates extends jckl_FilterTemplates_sugar {

    /**
     * @deprecated Use __construct() instead
     */
    public function jckl_FilterTemplates()
    {
        self::__construct();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Process list of users, roles, or groups
     * @param $users array
     */
    public function deploy($deploy_ids, $category, $template_id)
    {

        $users = $this->getUsersArray($deploy_ids, $category);

        $has_users = $this->checkUsers($users, $template_id);

        if ($has_users) {

            $result = $this->deployToUsers($users, $template_id);

        } else {

            $result = 0;

        }

        return $result;


    }

    protected function deployToUsers($users, $template_id, $dashboards_array)
    {
        global $current_user, $db;
        $template = new jckl_FilterTemplates();
        $template->retrieve($template_id);

        $relationship = 'jckl_filtertemplates_jckl_filterselections';

        $template->load_relationship($relationship);

        $filters_selections = array();
        foreach ($template->$relationship->getBeans() as $filter) {
            $filters_selections[$filter->id] = $filter;
        }
        $i = 0;

        foreach ($users as $user_id) {

            $user = new User();
            $user->retrieve($user_id);

            foreach ($filters_selections as $filter_selection) {
                $filter = BeanFactory::retrieveBean('Filters', $filter_selection->filter_id);
                $exists = $this->checkFilter($filter, $user_id);

                if (!$exists && $filter->name != '' ) {

                    $new_filter = BeanFactory::newBean('Filters');
                    $new_filter->name = $filter->name;
                    $new_filter->set_created_by = false;
                    $new_filter->created_by = $user_id;
                    $new_filter->filter_definition = $filter->filter_definition;
                    $new_filter->description = $filter->id;
                    $new_filter->filter_template = $filter->filter_template;
                    $new_filter->team_id = '1';
                    $new_filter->team_set_id = '1';
                    $new_filter->module_name = $filter->module_name;

                    $new_filter->save();

                } elseif (strlen ($exists) > 10) {
                    $new_filter = BeanFactory::getBean('Filters', $exists);
                    $new_filter->name = $filter->name;
                    $new_filter->set_created_by = false;
                    $new_filter->created_by = $user_id;
                    $new_filter->filter_definition = $filter->filter_definition;
                    $new_filter->description = $filter->id;
                    $new_filter->filter_template = $filter->filter_template;
                    $new_filter->team_id = '1';
                    $new_filter->team_set_id = '1';
                    $new_filter->module_name = $filter->module_name;
                    $new_filter->save();
                }

            }

            $filter_deployment = BeanFactory::newBean('jckl_FilterDeployments');
            $filter_deployment->name = $user->full_name . ' - ' . $template->name;
            $filter_deployment->user_id_c = $user->id;
            $filter_deployment->assigned_user_id = $current_user->id;
            $filter_deployment->save();
            $relationship = 'jckl_filtertemplates_jckl_filterdeployments';
            $filter_deployment->load_relationship($relationship);
            $filter_deployment->$relationship->add($template->id);
            $filter_deployment->save();

            $i++;
        }

        return $i;

    }

    /********************************************************
     *
     *  Check for filter id for user.
     *
     ********************************************************/
    protected function checkFilter($filter, $user_id)
    {

        $query = new SugarQuery();
        $query->from(BeanFactory::newBean('Filters'));
        $query->select('id');
        $query->where()
            ->equals('created_by',$user_id)
            ->equals('name',$filter->name)
            ->equals('filter_definition', $filter->filter_definition)
            ->equals('module_name', $filter->module_name);

        $result = $query->getOne();

        if ($result) {
            return true;
        } else {
            $query = new SugarQuery();
            $query->from(BeanFactory::newBean('Filters'));
            $query->select('id');
            $query->where()
                ->equals('description',$filter->id)
                ->equals('created_by',$user_id);

            $result = $query->getOne();
            if ($result) {
                return $result;
            }
            return false;
        }


    }

    public function deployFromSelection($user_ids, $filter_id)
    {

        $i = 0;
        foreach ($user_ids as $user_id) {

            $user = new User();
            $user->retrieve($user_id);


            $filter = BeanFactory::retrieveBean('Filters', $filter_id);
            $exists = $this->checkFilter($filter, $user_id);

            if (!$exists && $filter->name != '' ) {

                $new_filter = BeanFactory::newBean('Filters');
                $new_filter->name = $filter->name;
                $new_filter->set_created_by = false;
                $new_filter->created_by = $user_id;
                $new_filter->filter_definition = $filter->filter_definition;
                $new_filter->description = $filter->id;
                $new_filter->filter_template = $filter->filter_template;
                $new_filter->module_name = $filter->module_name;
                $new_filter->team_id = '1';
                $new_filter->team_set_id = '1';
                $new_filter->save();

            } elseif (strlen ($exists) > 10) {
                $new_filter = BeanFactory::getBean('Filters', $exists);
                $new_filter->name = $filter->name;
                $new_filter->set_created_by = false;
                $new_filter->created_by = $user_id;
                $new_filter->filter_definition = $filter->filter_definition;
                $new_filter->description = $filter->id;
                $new_filter->filter_template = $filter->filter_template;
                $new_filter->module_name = $filter->module_name;
                $new_filter->team_id = '1';
                $new_filter->team_set_id = '1';
                $new_filter->save();
            }


            $i++;
        }

        return $i;

    }

    /**
     * Check if there are any users selected
     * @param $users
     */
    protected function checkUsers($users)
    {
        $count = count($users);

        $valid = false;

        if ($count > 0) {
            $valid = true;
        }

        return $valid;

    }


    /**
     * Return array of users depending on whether we
     * are deploying to users, roles, or groups
     * @param $deploy_ids
     * @return array
     */
    protected function getUsersArray($deploy_ids, $category)
    {


        $users = array();

        if ($category == 'roles' ) {

            $users = $this->getUsersFromRoles($deploy_ids);

        } elseif($category == 'teams') {

            $users = $this->getUsersFromTeams($deploy_ids);

        }

        else {

            $users = $deploy_ids;

        }


        return $users;

    }


    /**
     * Query to get array of users if deploying to groups
     * @param $deploy_ids
     * @return array
     */
    protected function getUsersFromTeams($deploy_ids)
    {
        global $db;
        require_once('modules/Teams/Team.php');

        $team_obj = new Team();
        $users = array();

        foreach ($deploy_ids as $deploy_id) {
            $team_obj->retrieve($deploy_id);
            $team_members = $team_obj->get_team_members(true);
            foreach ($team_members as $team_member) {
                $users[] = $team_member->id;
            }

        }

        $users = array_unique($users);

        return $users;

    }

    /**
     * Query to get array of users if deploying to roles
     * @param $deploy_ids
     * @return array
     */
    protected function getUsersFromRoles($deploy_ids)
    {

        global $db;

        $deploy_array = array();

        $users_array = array();
        foreach ($deploy_ids as $deploy_id) {

            $role = BeanFactory::retrieveBean('ACLRoles', $deploy_id);

            $role->load_relationship('users');
            $users = $role->users->getBeans();
            foreach ($users as $user) {
                $users_array[] = $user->id;
            }

        }


        return $users_array;

    }

}