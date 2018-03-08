<?php

function MailChimpCampaigns() {
    require_once('custom/include/MailChimp/MailChimpConnector.php');
    $mailchimp_connector = new MailChimpConnector;
    $campaigns = $mailchimp_connector->getMailChimpCampaigns();
    $response = array('' => 'Please select');
    if(!empty($campaigns) && is_array($campaigns) && count($campaigns) > 0) {
        foreach($campaigns as $campaign){
            $response[$campaign['id']] = $campaign['settings']['title'];
        }
    }
    return $response;
}