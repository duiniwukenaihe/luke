<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$GLOBALS['db']->query("UPDATE outbound_email SET deleted=1 WHERE (mail_smtpuser IS NULL OR mail_smtppass IS NULL) AND mail_smtpauth_req=1");

$queryParams = array(
    'module' => 'Administration',
    'action' => 'index',
);

SugarApplication::redirect('index.php?' . http_build_query($queryParams));