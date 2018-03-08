<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

$fields = array(
	
	
	'docusign_username' => array(
        'name' => 'docusign_username',
        'type' => 'name',
        'label' => 'LBL_RT_DOCUSIGN_USERNAME',
        'view' => 'edit',
        'default' => false,
        'enabled' => true,
		'required' => true,
    ),
	'docusign_password' => array(
        'name' => 'docusign_password',
        'type' => 'password',
        'label' => 'LBL_RT_DOCUSIGN_PASSWORD',
        'view' => 'edit',
        'default' => false,
        'enabled' => true,
		'required' => true,
    ),
	'docusign_integrationkey' => array(
        'name' => 'docusign_integrationkey',
        'type' => 'name',
        'label' => 'LBL_RT_DOCUSIGN_INTEGRATION_KEY',
        'view' => 'edit',
        'default' => false,
        'enabled' => true,
		'required' => true,
    ),	
	'docusign_notification_url' => array(
        'name' => 'docusign_notification_url',
        'type' => 'name',		
        'label' => 'LBL_DOCUSIGN_NOTIFICATION_URL',
        'view' => 'edit',
        'default' => false,
        'enabled' => true,
		'required' => false,
    ),
	
	'docusign_connection_envoirnment' => array(
		'name' => 'docusign_connection_envoirnment',
		'type' => 'enum',		
        'label' => 'LBL_RT_DOCUSIGN_CONNECTION_ENVIRONMENT',
		'options' => array('demo' => 'Demo', 'www' => 'Production', ),		
        'view' => 'edit',		
        'default' => false,
        'enabled' => true,		
		'required' => false,
    ),
	
	
);

$viewdefs['RT_DocuSign']['base']['view']['dsconfig-user'] = array(
    'panels' => array(
        array(
            'label' => 'DocuSign Configurations',
			'columns' => 2,
            'fields' => $fields,
        )
    ),
);

