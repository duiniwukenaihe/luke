<?php

function MailChimpLists() {
    require_once('custom/include/MailChimp/MailChimpConnector.php');
    $mailchimp_connector = new MailChimpConnector;
    $lists = $mailchimp_connector->getLists();
    $response = array('' => 'Please select');
    if(!empty($lists) && is_array($lists) && count($lists) > 0) {
        $admin = new Administration();
        $admin->retrieveSettings();
        foreach($lists as $list) {
            $id = $list['id'];
            $name = $list['name'];
            if(!empty($admin->settings['mailchimp_'.$id])) {
                $old = json_decode($admin->settings['mailchimp_'.$id]);
                if(!empty($old->sync_mailchimp_list)) {
                    $old->mailchimp_list_name = $name;
                    $admin->saveSetting("mailchimp", $id, json_encode($old));
                }
            }
            $response[$id] = $name;
        }
    }
    return $response;
}