<?php

array_push($job_strings, 'mailchimp_sync');

/**
 * @return bool
 */
function mailchimp_sync() {
    require_once('custom/include/MailChimp/MailChimpConnector.php');
    $connector = new MailChimpConnector;
    $connector->syncLists();
    return true;
}