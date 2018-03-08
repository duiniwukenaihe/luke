<?php
require_once 'custom/include/MailChimp/MailChimp.php';

class Campaigns extends MailChimp {
    
    /**
     * Campaigns constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get the content (both html and text) for a campaign either as it would appear in the campaign archive or as the raw, original content
     * @param string $cid
     * @param associative_array $options
     *     - view string optional one of "archive" (default), "preview" (like our popup-preview) or "raw"
     *     - email associative_array optional if provided, view is "archive" or "preview", the campaign's list still exists, and the requested record is subscribed to the list. the returned content will be populated with member data populated. a struct with one of the following keys - failing to provide anything will produce an error relating to the email address. If multiple keys are provided, the first one from the following list that we find will be used, the rest will be ignored.
     *         - email string an email address
     *         - euid string the unique id for an email address (not list related) - the email "id" returned from listMemberInfo, Webhooks, Campaigns, etc.
     *         - leid string the list email id (previously called web_id) for a list-member-info type call. this doesn't change when the email address changes
     * @return associative_array containing all content for the campaign
     *     - html string The HTML content used for the campaign with merge tags intact
     *     - text string The Text content used for the campaign with merge tags intact
     */
    public function content($cid, $options=array()) {
        $_params = array("cid" => $cid, "options" => $options);
        return $this->call('get', 'campaigns/content', $_params);
    }

    /**
     * Get the list of campaigns and their details matching the specified filters
     * @param associative_array $filters
     *     - campaign_id string optional - return the campaign using a know campaign_id.  Accepts multiples separated by commas when not using exact matching.
     *     - parent_id string optional - return the child campaigns using a known parent campaign_id.  Accepts multiples separated by commas when not using exact matching.
     *     - list_id string optional - the list to send this campaign to - get lists using lists/list(). Accepts multiples separated by commas when not using exact matching.
     *     - folder_id int optional - only show campaigns from this folder id - get folders using folders/list(). Accepts multiples separated by commas when not using exact matching.
     *     - template_id int optional - only show campaigns using this template id - get templates using templates/list(). Accepts multiples separated by commas when not using exact matching.
     *     - status string optional - return campaigns of a specific status - one of "sent", "save", "paused", "schedule", "sending". Accepts multiples separated by commas when not using exact matching.
     *     - type string optional - return campaigns of a specific type - one of "regular", "plaintext", "absplit", "rss", "auto". Accepts multiples separated by commas when not using exact matching.
     *     - from_name string optional - only show campaigns that have this "From Name"
     *     - from_email string optional - only show campaigns that have this "Reply-to Email"
     *     - title string optional - only show campaigns that have this title
     *     - subject string optional - only show campaigns that have this subject
     *     - sendtime_start string optional - only show campaigns that have been sent since this date/time (in GMT) -  - 24 hour format in <strong>GMT</strong>, eg "2013-12-30 20:30:00" - if this is invalid the whole call fails
     *     - sendtime_end string optional - only show campaigns that have been sent before this date/time (in GMT) -  - 24 hour format in <strong>GMT</strong>, eg "2013-12-30 20:30:00" - if this is invalid the whole call fails
     *     - uses_segment boolean - whether to return just campaigns with or without segments
     *     - exact boolean optional - flag for whether to filter on exact values when filtering, or search within content for filter values - defaults to true. Using this disables the use of any filters that accept multiples.
     * @param int $start
     * @param int $limit
     * @param string $sort_field
     * @param string $sort_dir
     * @return associative_array containing a count of all matching campaigns, the specific ones for the current page, and any errors from the filters provided
     *     - total int the total number of campaigns matching the filters passed in
     *     - data array structs for each campaign being returned
     *         - id string Campaign Id (used for all other campaign functions)
     *         - web_id int The Campaign id used in our web app, allows you to create a link directly to it
     *         - list_id string The List used for this campaign
     *         - folder_id int The Folder this campaign is in
     *         - template_id int The Template this campaign uses
     *         - content_type string How the campaign's content is put together - one of 'template', 'html', 'url'
     *         - title string Title of the campaign
     *         - type string The type of campaign this is (regular,plaintext,absplit,rss,inspection,auto)
     *         - create_time string Creation time for the campaign
     *         - send_time string Send time for the campaign - also the scheduled time for scheduled campaigns.
     *         - emails_sent int Number of emails email was sent to
     *         - status string Status of the given campaign (save,paused,schedule,sending,sent)
     *         - from_name string From name of the given campaign
     *         - from_email string Reply-to email of the given campaign
     *         - subject string Subject of the given campaign
     *         - to_name string Custom "To:" email string using merge variables
     *         - archive_url string Archive link for the given campaign
     *         - inline_css boolean Whether or not the campaign content's css was auto-inlined
     *         - analytics string Either "google" if enabled or "N" if disabled
     *         - analytics_tag string The name/tag the campaign's links were tagged with if analytics were enabled.
     *         - authenticate boolean Whether or not the campaign was authenticated
     *         - ecomm360 boolean Whether or not ecomm360 tracking was appended to links
     *         - auto_tweet boolean Whether or not the campaign was auto tweeted after sending
     *         - auto_fb_post string A comma delimited list of Facebook Profile/Page Ids the campaign was posted to after sending. If not used, blank.
     *         - auto_footer boolean Whether or not the auto_footer was manually turned on
     *         - timewarp boolean Whether or not the campaign used Timewarp
     *         - timewarp_schedule string The time, in GMT, that the Timewarp campaign is being sent. For A/B Split campaigns, this is blank and is instead in their schedule_a and schedule_b in the type_opts array
     *         - parent_id string the unique id of the parent campaign (currently only valid for rss children). Will be blank for non-rss child campaigns or parent campaign has been deleted.
     *         - is_child boolean true if this is an RSS child campaign. Will return true even if the parent campaign has been deleted.
     *         - tests_sent string tests sent
     *         - tests_remain int test sends remaining
     *         - tracking associative_array the various tracking options used
     *             - html_clicks boolean whether or not tracking for html clicks was enabled.
     *             - text_clicks boolean whether or not tracking for text clicks was enabled.
     *             - opens boolean whether or not opens tracking was enabled.
     *         - segment_text string a string marked-up with HTML explaining the segment used for the campaign in plain English
     *         - segment_opts array the segment used for the campaign - can be passed to campaigns/segment-test or campaigns/create()
     *         - saved_segment associative_array if a saved segment was used (match+conditions returned above):
     *             - id int the saved segment id
     *             - type string the saved segment type
     *             - name string the saved segment name
     *         - type_opts associative_array the type-specific options for the campaign - can be passed to campaigns/create()
     *         - comments_total int total number of comments left on this campaign
     *         - comments_unread int total number of unread comments for this campaign based on the login the apikey belongs to
     *         - summary associative_array if available, the basic aggregate stats returned by reports/summary
     *         - social_card associative_array If a social card has been attached to this campaign:
     *             - title string The title of the campaign used with the card
     *             - description string The description used with the card
     *             - image_url string The URL of the image used with the card
     *             - enabled string Whether or not the social card is enabled for this campaign.
     *     - errors array structs of any errors found while loading lists - usually just from providing invalid list ids
     *         - filter string the filter that caused the failure
     *         - value string the filter value that caused the failure
     *         - code int the error code
     *         - error string the error message
     */
    public function getCampaigns($fields=array(), $exclude_fields=array(), $count=1000, $offset=0, $status='', $before_send_time='', $since_send_time='', $before_create_time='', $since_create_time='',$sort_field='create_time', $sort_dir='DESC') {
        $_params = array(
            "fields" => implode(",", $this->arrayWalk($fields, 'campaigns')),
            "exclude_fields" => $exclude_fields,
            "count" => $count,
            "offset" => $offset,
            "sort_field" => $sort_field,
            "sort_dir" => $sort_dir
        );
        return $this->call('get', 'campaigns', $_params);
    }

    /**
     * campaignReport
     * @param  string $campaign_id
     * @param  array  $fields
     * @param  array  $exclude_fields
     * @return array|false
     */
    public function campaignReport($campaign_id, $fields=array("campaign_title", "list_id", "list_name", "subject_line", "emails_sent", "abuse_reports", "unsubscribed", "send_time", "bounces", "forwards", "opens", "clicks", "industry_stats", "list_stats"), $exclude_fields=array()) {
        $_params = array(
            "fields" => implode(",", $fields),
            "exclude_fields" => $exclude_fields,
        );
        return $this->call('get', 'reports/' . $campaign_id, $_params);
    }
    
    /**
     * Get the HTML template content sections for a campaign. Note that this <strong>will</strong> return very jagged, non-standard results based on the template
    a campaign is using. You only want to use this if you want to allow editing template sections in your application.
     * @param string $cid
     * @return associative_array content containing all content section for the campaign - section name are dependent upon the template used and thus can't be documented
     */
    public function templateContent($cid) {
        $_params = array("cid" => $cid);
        return $this->call('get', 'campaigns/template-content', $_params);
    }

    /**
     * Update just about any setting besides type for a campaign that has <em>not</em> been sent. See campaigns/create() for details.
    Caveats:<br/><ul class='bullets'>
    <li>If you set a new list_id, all segmentation options will be deleted and must be re-added.</li>
    <li>If you set template_id, you need to follow that up by setting it's 'content'</li>
    <li>If you set segment_opts, you should have tested your options against campaigns/segment-test().</li>
    <li>To clear/unset segment_opts, pass an empty string or array as the value. Various wrappers may require one or the other.</li>
    </ul>
     * @param string $cid
     * @param string $name
     * @param array $value
     * @return associative_array updated campaign details and any errors
     *     - data associative_array the update campaign details - will return same data as single campaign from campaigns/list()
     *     - errors array for "options" only - structs containing:
     *         - code int the error code
     *         - message string the full error message
     *         - name string the parameter name that failed
     */
    public function update($cid, $name, $value) {
        $_params = array("cid" => $cid, "name" => $name, "value" => $value);
        return $this->master->call('campaigns/update', $_params);
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
     * getEepURL 
     * @param  string $campaign_id
     * @param  array  $fields         
     * @param  array  $exclude_fields 
     * @return string url                 
     */
    public function getEepURL($campaign_id, $fields = array('eepurl'), $exclude_fields = array()) {
        $_params = array(
            "fields" => implode(",", $fields),
            "exclude_fields" => $exclude_fields,
        );
        return $this->call('get', 'reports/' . $campaign_id . "/eepurl", $_params);
    }

}

