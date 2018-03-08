<?php

require_once 'custom/include/MailChimp/MailChimp.php';

class Lists extends MailChimp
{
    /**
     * Lists constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the most recent 100 activities for particular list members (open, click, bounce, unsub, abuse, sent to, etc.)
     * @param string $list_id
     * @param string $subscriber_hash
     * @param array $fields
     * @param array $exclude_fields
     * @return associative_array of data and success/error counts
     *     - success_count int the number of subscribers successfully found on the list
     *     - error_count int the number of subscribers who were not found on the list
     *     - errors array array of error structs including:
     *         - email string whatever was passed in the email parameter
     *             - email string the email address added
     *             - euid string the email unique id
     *             - leid string the list member's truly unique id
     *         - error string the error message
     *         - code string the error code
     *     - data array an array of structs where each activity record has:
     *         - email string whatever was passed in the email parameter
     *             - email string the email address added
     *             - euid string the email unique id
     *             - leid string the list member's truly unique id
     *         - activity array an array of structs containing the activity, including:
     *             - action string The action name, one of: open, click, bounce, unsub, abuse, sent, queued, ecomm, mandrill_send, mandrill_hard_bounce, mandrill_soft_bounce, mandrill_open, mandrill_click, mandrill_spam, mandrill_unsub, mandrill_reject
     *             - timestamp string The date+time of the action (GMT)
     *             - url string For click actions, the url clicked, otherwise this is empty
     *             - type string If there's extra bounce, unsub, etc data it will show up here.
     *             - campaign_id string The campaign id the action was related to, if it exists - otherwise empty (ie, direct unsub from list)
     *             - campaign_data associative_array If not deleted, the campaigns/list data for the campaign
     */
    public function memberActivity($list_id, $subscriber_hash, $fields = array('activity', 'total_items'), $exclude_fields = array())
    {
        $_params = array(
            "fields" => implode(",", $fields),
            "exclude_fields" => $exclude_fields
        );
        return $this->call('get', 'lists/' . $list_id . '/members/' . $subscriber_hash . '/activity', $_params);
    }

    /**
     * Get all of the list members for a list that are of a particular status and potentially matching a segment. This will cause locking, so don't run multiples at once. Are you trying to get a dump including lots of merge
     * data or specific members of a list? If so, checkout the <a href="/export/1.0/list.func.php">List Export API</a>
     * @param string $list_id
     * @param array $fields
     * @param array $exclude_fields
     * @param string $count
     * @param string $offset
     * @param string $email_type
     * @param string $status
     * @param string $since_timestamp_opt
     * @param string $before_timestamp_opt
     * @param string $since_last_changed
     * @param string $before_last_changed
     * @param string $unique_email_id
     * @param string $vip_only
     * @param string $interest_category_id
     * @param string $interest_ids
     * @param string $interest_match
     * @return associative_array of the total records matched and limited list member data for this page
     *     - total int the total matching records
     *     - data array structs for each member as returned by member-info
     */
    public function members(
        $list_id,
        $subscriber_id,
        $fields = array(),
        $exclude_fields = array(),
        $count = 1000,
        $offset = 0,
        $email_type = '',
        $status = '',
        $since_timestamp_opt = '',
        $before_timestamp_opt = '',
        $since_last_changed = '',
        $before_last_changed = '',
        $unique_email_id = '',
        $vip_only = '',
        $interest_category_id = '',
        $interest_ids = '',
        $interest_match = ''
    )
    {
        if(empty($subscriber_id)) {
            $_params = array(
                "fields" => implode(",", $this->arrayWalk($fields, 'members')),
                "exclude_fields" => $exclude_fields,
                "count" => $count,
                "offset" => $offset,
            );
            $url = 'lists/' . $list_id . '/members';
        } else {
            $_params = array(
                "fields" => implode(",", $fields),
                "exclude_fields" => $exclude_fields
            );
            $url = 'lists/' . $list_id . '/members/' . $subscriber_id;
        }

        return $this->call('get', $url, $_params);
    }

    /**
     * @param $list_id
     * @param string $email_address
     * @param array $merge_fields
     * @param string $email_type
     * @param string $status
     * @param string $interests
     * @param string $language
     * @param string $vip
     * @param string $location
     * @return mixed
     */
    public function createMember(
        $list_id,
        $email_address = '',
        $merge_fields = array(),
        $email_type = '',
        $status = 'subscribed',
        $interests = '',
        $language = '',
        $vip = '',
        $location = ''
    )
    {
        $_params = array(
            "email_address" => $email_address,
            "merge_fields" => $merge_fields,
            "status" => $status,
        );
        return $this->call('post', 'lists/' . $list_id . '/members', $_params);
    }

    /**
     * @param string $list_id
     * @param string $subscriber_hash
     * @return mixed
     */
    public function deleteMember($list_id, $subscriber_hash)
    {
        return $this->call('delete', 'lists/' . $list_id . '/members/' . $subscriber_hash);
    }

    /**
     * @param array $operations
     * @return mixed
     */
    public function doBatchOperation($operations = array())
    {
        $_params = array(
            "operations" => $operations,
        );
        return $this->call('post', 'batches', $_params);
    }

    public function batchWebhookAdd($url = '')
    {
        $_params = array(
            "url" => $url,
        );
        return $this->call('post', 'batch-webhooks', $_params);
    }

    public function batchWebhooks($fields = array(), $exclude_fields = array(), $count = 1000, $offset = 0)
    {
        $_params = array(
            "fields" => $fields,
            "count" => $count,
            "offset" => $offset
        );
        return $this->call('get', 'batch-webhooks', $_params);
    }

    /**
     * Edit the email address, merge fields, and interest groups for a list member. If you are doing a batch update on lots of users,
     * consider using lists/batch-subscribe() with the update_existing and possible replace_interests parameter.
     * @param string $list_id
     * @param string $subscriber_hash
     * @param string $email_address
     * @param associative_array $merge_fields
     * @param string $email_type
     * @param string $status
     * @param string $interests
     * @param string $language
     * @param string $vip
     * @param string $location
     * @return associative_array the ids for this subscriber
     *     - email string the email address added
     *     - euid string the email unique id
     *     - leid string the list member's truly unique id
     */
    public function updateMember(
        $list_id,
        $subscriber_hash,
        $email_address = '',
        $merge_fields = array(),
        $email_type = '',
        $status = 'subscribed',
        $interests = '',
        $language = '',
        $vip = '',
        $location = ''
    )
    {
        $_params = array(
            "email_address" => $email_address,
            "merge_fields" => $merge_fields,
            "status" => $status,
        );
        return $this->call('patch', 'lists/' . $list_id . '/members/' . $subscriber_hash, $_params);
    }

    /**
     * Add a new Webhook URL for the given list
     * @param string $id
     * @param string $url
     * @param associative_array $actions
     *     - subscribe bool optional as subscribes occur, defaults to true
     *     - unsubscribe bool optional as subscribes occur, defaults to true
     *     - profile bool optional as profile updates occur, defaults to true
     *     - cleaned bool optional as emails are cleaned from the list, defaults to true
     *     - upemail bool optional when  subscribers change their email address, defaults to true
     *     - campaign bool option when a campaign is sent or canceled, defaults to true
     * @param associative_array $sources
     *     - user bool optional user/subscriber initiated actions, defaults to true
     *     - admin bool optional admin actions in our web app, defaults to true
     *     - api bool optional actions that happen via API calls, defaults to false
     * @return associative_array with a single entry:
     *     - id int the id of the new webhook, otherwise an error will be thrown.
     */
    public function webhookAdd($list_id, $url, $events = array("subscribe" => true, "unsubscribe" => true, "profile" => true, "cleaned" => false, "upemail" => true, "campaign" => true), $sources = array("user" => true, "admin" => true, "api" => false))
    {
        $_params = array(
            "url" => $url,
            "events" => $events,
            "sources" => $sources
        );

        return $this->call('post', 'lists/' . $list_id . '/webhooks', $_params);
    }

    /**
     * Delete an existing Webhook URL from a given list
     * @param string $id
     * @param string $url
     * @return associative_array with a single entry:
     *     - complete bool whether the call worked. reallistically this will always be true as errors will be thrown otherwise.
     */
    public function webhookDel($id, $url)
    {
        $_params = array("id" => $id, "url" => $url);
        return $this->call('post', 'lists/webhook-del', $_params);
    }

    /**
     * Return the Webhooks configured for the given list
     * @param string $id
     * @return array of structs for each webhook
     *     - url string the URL for this Webhook
     *     - actions associative_array the possible actions and whether they are enabled
     *         - subscribe bool triggered when subscribes happen
     *         - unsubscribe bool triggered when unsubscribes happen
     *         - profile bool triggered when profile updates happen
     *         - cleaned bool triggered when a subscriber is cleaned (bounced) from a list
     *         - upemail bool triggered when a subscriber's email address is changed
     *         - campaign bool triggered when a campaign is sent or canceled
     *     - sources associative_array the possible sources and whether they are enabled
     *         - user bool whether user/subscriber triggered actions are returned
     *         - admin bool whether admin (manual, in-app) triggered actions are returned
     *         - api bool whether api triggered actions are returned
     */
    public function webhooks($list_id)
    {
        $_params = array();
        return $this->call('get', 'lists/' . $list_id . '/webhooks', $_params);
    }

    /**
     * @param array $item
     * @param string $prefix
     * @return array
     */
    private function arrayWalk($item, $prefix) {
        $newArray = array();
        foreach ($item as $value) {
            $newArray[] = "$prefix.$value";
        }
        if(!empty($item)) {
            $newArray[] = "total_items";
        }
        return $newArray;
    }

    /**
     * Retrieve all of the lists defined for your user account
     * @param associative_array $filters
     *     - list_id string optional - return a single list using a known list_id. Accepts multiples separated by commas when not using exact matching
     *     - list_name string optional - only lists that match this name
     *     - from_name string optional - only lists that have a default from name matching this
     *     - from_email string optional - only lists that have a default from email matching this
     *     - from_subject string optional - only lists that have a default from email matching this
     *     - created_before string optional - only show lists that were created before this date+time  - 24 hour format in <strong>GMT</strong>, eg "2013-12-30 20:30:00"
     *     - created_after string optional - only show lists that were created since this date+time  - 24 hour format in <strong>GMT</strong>, eg "2013-12-30 20:30:00"
     *     - exact boolean optional - flag for whether to filter on exact values when filtering, or search within content for filter values - defaults to false
     * @param int $start
     * @param int $limit
     * @param string $sort_field
     * @param string $sort_dir
     * @return associative_array result of the operation including valid data and any errors
     *     - total int the total number of lists which matched the provided filters
     *     - data array structs for the lists which matched the provided filters, including the following
     *         - id string The list id for this list. This will be used for all other list management functions.
     *         - web_id int The list id used in our web app, allows you to create a link directly to it
     *         - name string The name of the list.
     *         - date_created string The date that this list was created.
     *         - email_type_option boolean Whether or not the List supports multiple formats for emails or just HTML
     *         - use_awesomebar boolean Whether or not campaigns for this list use the Awesome Bar in archives by default
     *         - default_from_name string Default From Name for campaigns using this list
     *         - default_from_email string Default From Email for campaigns using this list
     *         - default_subject string Default Subject Line for campaigns using this list
     *         - default_language string Default Language for this list's forms
     *         - list_rating double An auto-generated activity score for the list (0 - 5)
     *         - subscribe_url_short string Our eepurl shortened version of this list's subscribe form (will not change)
     *         - subscribe_url_long string The full version of this list's subscribe form (host will vary)
     *         - beamer_address string The email address to use for this list's <a href="http://kb.mailchimp.com/article/how-do-i-import-a-campaign-via-email-email-beamer/">Email Beamer</a>
     *         - visibility string Whether this list is Public (pub) or Private (prv). Used internally for projects like <a href="http://blog.mailchimp.com/introducing-wavelength/" target="_blank">Wavelength</a>
     *         - stats associative_array various stats and counts for the list - many of these are cached for at least 5 minutes
     *             - member_count double The number of active members in the given list.
     *             - unsubscribe_count double The number of members who have unsubscribed from the given list.
     *             - cleaned_count double The number of members cleaned from the given list.
     *             - member_count_since_send double The number of active members in the given list since the last campaign was sent
     *             - unsubscribe_count_since_send double The number of members who have unsubscribed from the given list since the last campaign was sent
     *             - cleaned_count_since_send double The number of members cleaned from the given list since the last campaign was sent
     *             - campaign_count double The number of campaigns in any status that use this list
     *             - grouping_count double The number of Interest Groupings for this list
     *             - group_count double The number of Interest Groups (regardless of grouping) for this list
     *             - merge_var_count double The number of merge vars for this list (not including the required EMAIL one)
     *             - avg_sub_rate double the average number of subscribe per month for the list (empty value if we haven't calculated this yet)
     *             - avg_unsub_rate double the average number of unsubscribe per month for the list (empty value if we haven't calculated this yet)
     *             - target_sub_rate double the target subscription rate for the list to keep it growing (empty value if we haven't calculated this yet)
     *             - open_rate double the average open rate per campaign for the list  (empty value if we haven't calculated this yet)
     *             - click_rate double the average click rate per campaign for the list  (empty value if we haven't calculated this yet)
     *         - modules array Any list specific modules installed for this list (example is SocialPro)
     *     - errors array structs of any errors found while loading lists - usually just from providing invalid list ids
     *         - param string the data that caused the failure
     *         - code int the error code
     *         - error string the error message
     */
    public function getList($list_id = '', $fields = array(), $exclude_fields = array(), $count = 1000, $offset = 0, $before_date_created = '', $since_date_created = '', $before_campaign_last_sent = '', $since_campaign_last_sent = '', $email = '', $sort_field = 'date_created', $sort_dir = 'DESC')
    {
        $url = '';
        if(empty($list_id)) {
            $_params = array(
                "fields" => implode(",", $this->arrayWalk($fields, 'lists')),
                "exclude_fields" => $exclude_fields,
                "count" => $count,
                "offset" => $offset,
                "before_date_created" => $before_date_created,
                "since_date_created" => $since_date_created,
                "before_campaign_last_sent" => $before_campaign_last_sent,
                "since_campaign_last_sent" => $since_campaign_last_sent,
                "email" => $email,
                "sort_field" => $sort_field,
                "sort_dir" => $sort_dir
            );
            $url = 'lists';
        } else {
            $_params = array(
                "fields" => implode(",", $fields),
                "exclude_fields" => $exclude_fields
            );
            $url = 'lists/' . $list_id;
        }

        return $this->call('get', $url, $_params);
    }

    /**
     * @param string $list_id
     * @param array $fields
     * @param array $exclude_fields
     * @param int $count
     * @param int $offset
     * @param string $type
     * @param string $required
     * @return mixed
     */
    public function getField($list_id, $fields = array(), $exclude_fields = array(), $count = 1000, $offset = 0, $type = '', $required = '')
    {
        $_params = array(
            "fields" => implode(",", $this->arrayWalk($fields, 'merge_fields')),
            "exclude_fields" => $exclude_fields,
            "count" => $count,
            "offset" => $offset,
            "type" => $type,
            "required" => $required,
        );
        return $this->call('get', 'lists/' . $list_id . '/merge-fields', $_params);
    }

    /**
     * @param string $name
     * @param array $contact
     * @param array $campaign_defaults
     * @param string $permission_reminder
     * @param string $use_archive_bar
     * @param string $notify_on_subscribe
     * @param string $notify_on_unsubscribe
     * @param bool $email_type_option
     * @param string $visibility
     * @return mixed
     */
    public function createList($name = 'DemoList', $contact=array(), $campaign_defaults=array(), $permission_reminder='Test', $use_archive_bar='', $notify_on_subscribe='', $notify_on_unsubscribe='', $email_type_option=false, $visibility = '')
    {
        $_params = array(
            "name" => $name,
            "contact" => $contact,
            "permission_reminder" => $permission_reminder,
            "campaign_defaults" => $campaign_defaults,
            "email_type_option" => $email_type_option,
        );

        return $this->call('post', 'lists', $_params);
    }

    /**
     * @param $list_id
     * @param string $name
     * @param array $contact
     * @param array $campaign_defaults
     * @param string $permission_reminder
     * @param string $use_archive_bar
     * @param string $notify_on_subscribe
     * @param string $notify_on_unsubscribe
     * @param bool $email_type_option
     * @param string $visibility
     * @return mixed
     */
    public function updateList($list_id, $name = 'DemoList', $contact=array(), $campaign_defaults=array(), $permission_reminder='', $use_archive_bar='', $notify_on_subscribe='', $notify_on_unsubscribe='', $email_type_option=false, $visibility = '')
    {
        $_params = array(
            "name" => $name,
            "contact" => $contact,
            "permission_reminder" => $permission_reminder,
            "campaign_defaults" => $campaign_defaults,
            "email_type_option" => $email_type_option,
        );

        return $this->call('patch', 'lists/' . $list_id, $_params);
    }

}

