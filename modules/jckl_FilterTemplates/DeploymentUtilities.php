<?php


    /**
     * Used to aid in Template Deployment
     *
     * Class jckl_FilterTemplatesDeploymentUtilities
     */
    class jckl_FilterTemplatesDeploymentUtilities
    {

        /**
         * Return the options in step two depending on what the user selected in step one
         * @param $type
         * @return array
         */
        public function getDeployType($type)
        {

            switch ($type) {
                case 'roles':
                    $list = $this->getRoles();
                    break;
                case 'teams':
                    $list = $this->getTeams();
                    break;
                case 'users':
                    $list = $this->getUsers();
                    break;
            }


            return $list;
        }


        /**
         * Get list of Available roles
         * @return array
         */
        public function getRoles()
        {

            $query = new SugarQuery();
            $query->select(array('id', 'name'));
            $query->from(BeanFactory::getBean('ACLRoles'));
            $query->where()->equals('deleted','0');
            $query->where()->notEquals('name', 'Tracker');

            $results = $query->execute();

            $GLOBALS['log']->debug('Dashlet Deploy Get Roles Query: ' . $query->compileSql());

            $data = array();

            foreach ($results as $row) {
                $data[] = array('id' => $row['id'], 'name' => $row['name']);
            }


            return $data;

        }

        /**
         * Get list of teams.
         */
        public function getTeams()
        {

            $query = new SugarQuery();
            $query->select(array('id', 'name'));
            $query->from(BeanFactory::getBean('Teams'));
            $query->where()->equals('deleted','0');
            $query->where()->equals('private','0');

            $results = $query->execute();
            $GLOBALS['log']->debug('Dashlet Deploy Get Teams Query: ' . $query->compileSql());

            $data = array();

            foreach ($results as $row) {
                $data[] = array('id' => $row['id'], 'name' => $row['name']);
            }


            return $data;

        }


        public function getUsers()
        {

            require_once('modules/Users/User.php');

            $users = User::getAllUsers();


            $data = array();

            foreach ($users as $key => $value) {
                $data[] = array('id' => $key, 'name' => $value);
            }


            return $data;
        }


        /**
         * @return mixed
         */
        public function getDeploymentOptions()
        {
            global $app_list_strings;
            return $app_list_strings['jckl_deploy_filter_options'];

        }



    }