<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    require_once('include/api/SugarApi.php');
    require_once('data/BeanFactory.php');
    require_once('modules/jckl_FilterTemplates/jckl_FilterTemplates.php');
    require_once('modules/jckl_FilterTemplates/DeploymentUtilities.php');



    class jckl_FilterTemplatesApi extends SugarApi
    {
        public function registerApiRest()
        {
            return array(
                'getCategoryData' => array(
                    'reqType' => 'GET',
                    'path' => array('jckl_FilterTemplates', 'getCategoryData', '?'),
                    'pathVars' => array('', '', 'category'),
                    'method' => 'getCategoryData',
                    'shortHelp' => 'Retrieves List of Users, Roles, Or Teams based on selection',
                ),
                'deployTemplate' => array(
                    'reqType'   => 'POST',
                    'path'      => array('jckl_FilterTemplates','deployTemplate'),
                    'pathVars'  => array('module', 'path',),
                    'method'    => 'deployTemplate',
                    'shortHelp' => 'Receives Template ID, Category, And Deploy IDs and copies Templates to proper users',
                ),
                'deployFilter' => array(
                    'reqType'   => 'POST',
                    'path'      => array('jckl_FilterTemplates','deployFilter'),
                    'pathVars'  => array('module', 'path',),
                    'method'    => 'deployFilter',
                    'shortHelp' => 'Receives Filter ID, and copies Templates to users',
                ),


            );
        }

        public function getCategoryData($api, array $args)
        {
            $category = $args['category'];
            if (empty($args['category'])) {
                throw new SugarApiExceptionMissingParameter('ERR_MISSING_PARAMETER_FIELD', array('category'), 'jckl_FilterTemplates');
            }

            $template = new jckl_FilterTemplatesDeploymentUtilities();
            $options = $template->getDeployType($category);

            return array('success' => true, 'options' => $options);
        }

        public function deployTemplate($api, array $args)
        {


            global $current_user, $sugar_config;
            require_once('modules/jckl_FilterTemplates/license/OutfittersLicense.php');
            $validate_license = OutfittersLicense::isValid('jckl_FilterTemplates');
            if($validate_license !== true) {

                $url = $sugar_config['site_url'] .'/#bwc/index.php?module=jckl_FilterTemplates&action=license';
                throw new SugarApiExceptionMissingParameter('ERR_LICENSE_EXPIRED', '', 'jckl_FilterTemplates', 0, $url );
                return false;
            }
            $deployer = new jckl_FilterTemplates();

            $users = $deployer->deploy($args['deploy_records'], $args['category'], $args['template_id']);

            return array('success' => true, 'count' => $users);



        }

        public function deployFilter($api, array $args)
        {

            global $current_user, $sugar_config;
            require_once('modules/jckl_FilterTemplates/license/OutfittersLicense.php');
            $validate_license = OutfittersLicense::isValid('jckl_FilterTemplates');
            if($validate_license !== true) {

                $url = $sugar_config['site_url'] .'/#bwc/index.php?module=jckl_FilterTemplates&action=license';
                throw new SugarApiExceptionMissingParameter('ERR_LICENSE_EXPIRED', '', 'jckl_FilterTemplates', 0, $url );
                return false;
            }
            $deployer = new jckl_FilterTemplates();

            $users = $deployer->deployFromSelection($args['users'], $args['filter_id']);

            return array('success' => true, 'count' => $users);
        }


    }