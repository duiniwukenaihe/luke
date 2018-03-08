<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/include/MailChimp/MailChimpConnector.php');
require_once('custom/include/MailChimp/MailChimpAdministration.php');

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

/**
 * MailChimp API calls
 *
 */
class MailChimpWebhookApi extends SugarApi {
    public function registerApiRest() {
        return array(
            'getUpdates' => array(
                'reqType' => array('GET','POST'),
                'noLoginRequired' => true,
                'path' => array('mailchimp'),
                'pathVars' => array(''),
                'method' => 'getUpdates',
                'shortHelp' => 'Recieve mailchimp updates in sugarcrm',
                'longHelp' => '',
            ),
            'mailchimpAdmin' => array(
                'reqType' => array('POST'),
                'noLoginRequired' => true,
                'path' => array('mailchimpAdmin'),
                'pathVars' => array(''),
                'method' => 'mailchimpAdmin',
                'shortHelp' => 'Recieve mailchimp administration api',
                'longHelp' => '',
            ),
        );
    }

    /**
     * Bulk API call
     * @param ServiceBase $api
     * @param array $args
     * @throws SugarApiExceptionMissingParameter
     * @return array
     */
    public function getUpdates(ServiceBase $api, array $args) {   
        if(isset($args['__sugar_url'])) {
            unset($args['__sugar_url']);
        }
        $connector = new MailChimpConnector;
        return $connector->syncMailChimpChanges($args);
    }

    /**
     * Bulk API call
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function mailchimpAdmin(ServiceBase $api, array $args) {   
        if(isset($args['__sugar_url'])) {
            unset($args['__sugar_url']);
        }
        $mailchimp_admin = new MailChimpAdministration;
        return $mailchimp_admin->mailChimpAdministration($args);
    }
}
