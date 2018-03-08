<?php
require_once("vendor/Zend/Gdata/Contacts.php");
require_once 'vendor/Zend/Gdata/Query.php';

class GoogleContacts extends Zend_Gdata_Contacts
{
    public function getContactListFeed($last_sync_date = '')
    {
        $query = new Zend_Gdata_Query(self::CONTACT_FEED_URI);

        $query->maxResults = $this->maxResults;
        $query->startIndex = $this->startIndex;
        if (!empty($last_sync_date)) $query->setUpdatedMin($last_sync_date);
        $query->setParam('showdeleted', 'true');
        return parent::getFeed($query, 'Zend_Gdata_Contacts_ListFeed');
    }

}
 
