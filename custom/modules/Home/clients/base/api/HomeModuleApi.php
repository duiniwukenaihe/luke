<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

class HomeModuleApi extends ModuleApi {

    public function registerApiRest() {
        return array(
            'enum' => array(
                'reqType' => 'GET',
                'path' => array('Home','enum','?'),
                'pathVars' => array('module', 'enum', 'field'),
                'method' => 'getEnumValues',
                'shortHelp' => 'This method returns enum values for a specified field',
                'longHelp' => 'include/api/help/module_enum_get_help.html',
            ),
        );
    }

    /**
     * This method returns the dropdown options of a given field
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function getEnumValues(ServiceBase $api, array $args)
    {
        return MailChimpCampaigns();
    }

}
