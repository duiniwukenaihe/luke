<?php

require_once 'clients/base/api/ConfigModuleApi.php';
require_once 'modules/DRI_Workflows/ConnectorHelper.php';

/**
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
class DRICustomerJourneyConfigApi extends ConfigModuleApi
{
    /**
     * @var string
     */
    private static $portalUrl = 'https://portal.addoptify.com';

    /**
     * @return array
     */
    public function registerApiRest() {
        return array(
            'configCreate' => array(
                'reqType' => 'POST',
                'path' => array('DRI_Workflows', 'config'),
                'pathVars' => array('module', ''),
                'method' => 'configSave',
                'shortHelp' => 'Creates the config entries for the given module',
                'longHelp' => 'include/api/help/module_config_post_help.html',
            ),
            'configUpdate' => array(
                'reqType' => 'PUT',
                'path' => array('DRI_Workflows', 'config'),
                'pathVars' => array('module', ''),
                'method' => 'configSave',
                'shortHelp' => 'Updates the config entries for given module',
                'longHelp' => 'include/api/help/module_config_put_help.html',
            ),
            'configRead' => array(
                'reqType' => 'GET',
                'path' => array('DRI_Workflows', 'config'),
                'pathVars' => array('module'),
                'method' => 'getConfig',
                'shortHelp' => '',
                'longHelp' => '',
                'noEtag' => true,
            ),
            'activateUsers' => array(
                'reqType' => 'PUT',
                'path' => array('DRI_Workflows', 'config', 'activate-users'),
                'pathVars' => array('module'),
                'method' => 'activateUsers',
                'shortHelp' => '',
                'longHelp' => '',
                'noEtag' => true,
            ),
            'deactivateUsers' => array(
                'reqType' => 'PUT',
                'path' => array('DRI_Workflows', 'config', 'deactivate-users'),
                'pathVars' => array('module'),
                'method' => 'deactivateUsers',
                'shortHelp' => '',
                'longHelp' => '',
                'noEtag' => true,
            ),
            'saveConfigureModules' => array(
                'reqType' => 'PUT',
                'path' => array('DRI_Workflows', 'config', 'enabled_modules'),
                'pathVars' => array('module', ''),
                'method' => 'saveConfigureModules',
                'shortHelp' => '',
                'longHelp' => '',
            ),
            'readConfigureModules' => array(
                'reqType' => 'GET',
                'path' => array('DRI_Workflows', 'config', 'enabled_modules'),
                'pathVars' => array('module', ''),
                'method' => 'readConfigureModules',
                'shortHelp' => '',
                'longHelp' => '',
            ),
        );
    }

    /**
     * @param ServiceBase $api
     * @param array       $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     */
    public function configSave(ServiceBase $api, array $args)
    {
        global $current_user;

        $this->requireArgs($args, array ('license_key', 'validation_key'));
        $panel = new \DRI_Workflow_Templates\ControlPanel();
        $this->skipMetadataRefresh = true;
        parent::configSave($api, $args);

        if (!$current_user->customer_journey_access) {
            $current_user->customer_journey_access = true;
            $current_user->save();
        }

        $panel->validateLicense($args['license_key'], $args['validation_key']);
        $panel->importTemplates();

        return $this->getConfig($api, $args);
    }

    /**
     * @param ServiceBase $api
     * @param array $args-readConfigureModules
     * @return array
     */
    public function saveConfigureModules(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, array ('enabled_modules'));
        require_once 'ModuleInstall/ModuleInstaller.php';
        $configurator = new Configurator();
        $configurator->config['additional_js_config']['customer_journey']['enabled_modules'] = implode(',', $args['enabled_modules']);
        $configurator->saveConfig();
        ModuleInstaller::handleBaseConfig();

        return array (
            'missing_modules' => $this->getMissingModuleInfo()
        );
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function readConfigureModules(ServiceBase $api, array $args)
    {
        return array (
            'enabled_modules' => $this->getEnabledModules(),
            'missing_modules' => $this->getMissingModuleInfo(),
        );
    }

    /**
     * @return array
     */
    private function getEnabledModules()
    {
        global $sugar_config;
        $enabled_modules = array ();

        if (isset($sugar_config['additional_js_config']['customer_journey']['enabled_modules'])) {
            if (is_string($sugar_config['additional_js_config']['customer_journey']['enabled_modules'])) {
                $enabled_modules = explode(',', $sugar_config['additional_js_config']['customer_journey']['enabled_modules']);
            } else {
                $enabled_modules = $sugar_config['additional_js_config']['customer_journey']['enabled_modules'];
            }
        } else {
            $w = new DRI_Workflow();
            foreach ($w->getParentDefinitions() as $def) {
                $enabled_modules[] = $def['module'];
            }
        }

        return $enabled_modules;
    }

    /**
     * @return array
     */
    private function getMissingModuleInfo()
    {
        $available_modules = array ();
        $w = new DRI_Workflow();

        foreach ($w->getParentDefinitions() as $def) {
            $available_modules[] = $def['module'];
        }

        $missing = array_diff($this->getEnabledModules(), $available_modules);
        $missing = array_values($missing);

        $defs = array ();
        foreach ($missing as $module) {
            $bean = BeanFactory::newBean($module);

            if (!$bean) {
                continue;
            }

            $def = array (
                'module_name' => $bean->module_dir,
                'object_name' => $bean->object_name,
                'table_name' => $bean->table_name,
                'translations' => array (),
            );

            foreach (SugarConfig::getInstance()->get('languages') as $language => $name) {
                $lang = return_module_language($language, $module);
                if (!empty($lang['LBL_MODULE_NAME'])) {
                    $def['translations'][$language] = $lang['LBL_MODULE_NAME'];
                }
            }

            $defs[] = $def;
        }

        $defs = base64_encode(serialize($defs));

        return array (
            'modules' => $missing,
            'module_loader_link' => SugarConfig::getInstance()->get('site_url').'/#bwc/index.php?module=Administration&action=UpgradeWizard&view=module',
            'download_link' => static::$portalUrl . '/customer-journey/custom-modules?' .http_build_query(array (
                'modules' => $defs,
            )),
        );
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function getConfig(ServiceBase $api, array $args)
    {
        $helper = new \DRI_Workflows\ConnectorHelper();

        $config = array (
            'license_key' => $helper->getLicenseKey(),
            'validation_key' => $helper->getValidationKey(),
            'version' => $helper->getCurrentVersion(),
            'valid' => true,
            'current_users' => null,
            'user_limit' => null,
            'valid_until' => null,
            'active_users' => array (),
            'inactive_users' => array (),
        );

        try {
            $config['current_users'] = $helper->getCurrentUsers();
            $config['user_limit'] = $helper->getUserLimit();
            $config['valid_until'] = $helper->getValidUntil()->format('Y-m-d');
        } catch (\Exception $e) {

        }

        try {
            $helper->checkLicense(false);
        } catch (\Exception $e) {
            $config['valid'] = false;
        }

        return $config;
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionInvalidParameter
     */
    public function activateUsers(ServiceBase $api, array $args)
    {
        $helper = new \DRI_Workflows\ConnectorHelper();

        $limit = $helper->getUserLimit();
        $current = $helper->getCurrentUsers();

        foreach ($args['ids'] as $id) {
            $user = BeanFactory::retrieveBean('Users', $id);

            if ($user && !$user->customer_journey_access) {
                $current++;
                $user->customer_journey_access = true;

                if ($current > $limit) {
                    throw new \SugarApiExceptionInvalidParameter('User limit reached');
                }

                $user->save();
            }
        }

        return array (
            'limit' => $limit,
            'current' => $current,
        );
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionInvalidParameter
     */
    public function deactivateUsers(ServiceBase $api, array $args)
    {
        $helper = new \DRI_Workflows\ConnectorHelper();

        $limit = $helper->getUserLimit();
        $current = $helper->getCurrentUsers();

        foreach ($args['ids'] as $id) {
            $user = BeanFactory::retrieveBean('Users', $id);

            if ($user && $user->customer_journey_access) {
                $current--;
                $user->customer_journey_access = false;

                $user->save();
            }
        }

        return array (
            'limit' => $limit,
            'current' => $current,
        );
    }
}
