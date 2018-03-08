<?php

    /**
     * class to handle the updation Statuses of attached document and contacts of DocuSign Packet Record.
     */
    class RT_Update_Relationship_Status {

        /**
         * function to update Status of each attached document of DocuSign Packet Record.
         * @param string
         * @param string
         * @return
         */
        function updateDocumentsStatuses($env_rec_id, $newStatus)
        {
            global $db;
            $query = "SELECT id  FROM dp_doucumentspackets_attachments WHERE deleted=0 AND packet_id = '" . $env_rec_id . "'";
            $result = $db->query($query);
            $document_id = array();

            while ($row = $result->fetch_assoc()) { // we are checking if document with this name already exists.
                $rec_id = $row['id'];
                $update = "UPDATE dp_doucumentspackets_attachments SET document_status='" . $newStatus . "' WHERE id='" . $rec_id . "'";
                $res = $db->query($update); // update Status of each attached document
            }
        }

        /**
         * function to update Status of each attached document of DocuSign Packet Record.
         * @param string
         * @param string
         * @return
         */
        function updateReceipentsStatuses($env_rec_id, $newStatus, $contactName, $mode = 1, $date_modified = "")
        {
            global $db, $timedate;
            if (empty($date_modified)) {
                $date_modified = $timedate->getInstance()->nowDb();
            } else {
                $date_modified = date("Y-m-d H:i:s", strtotime($date_modified));
                $date_modified = new DateTime($date_modified);
                $date_modified = $timedate->asDb($date_modified);
            }
            $query = "SELECT id,dp_doucumentspackets_contactscontacts_idb as 'cid'  FROM dp_doucumentspackets_contacts_c WHERE deleted=0 AND dp_doucumentspackets_contactsdp_doucumentspackets_ida = '" . $env_rec_id . "'";
            $result = $db->query($query);
            $document_id = array();
            while ($row = $result->fetch_assoc()) { // we are checking if document with this name already exists.
                $rec_id = $row['id'];
                $cid = $row['cid'];
                $query2 = "select  TRIM(CONCAT(COALESCE(salutation,''),' ',COALESCE(first_name,''),' ',COALESCE(last_name,''))) as 'contact_name' from  contacts where id='" . $cid . "'";
                $result2 = $db->query($query2);
                $cname = "";
                while ($row2 = $result2->fetch_assoc()) {
                    $cname = $row2['contact_name'];
                }
                if ($mode == 1) {// mode will be 1 by default i.e. if this function is called with specific "$contactName" whose status we want to update.
                    if ($cname == trim($contactName)) {
                        $update = "UPDATE dp_doucumentspackets_contacts_c SET date_modified ='$date_modified', receipnt_status='" . $newStatus . "' WHERE id='" . $rec_id . "'";
                        $db->query($update); // update Status of each attached document
                    }
                } else if ($mode == 2) {// mode will be 2 if we want to update the status of all recipients of documents packet
                    $update = "UPDATE dp_doucumentspackets_contacts_c SET date_modified ='$date_modified', receipnt_status='" . $newStatus . "' WHERE id='" . $rec_id . "'";
                    $db->query($update); // update Status of each attached document
                }
            }
        }

        /**
         * function to update Status of each attached document of DocuSign Packet Record.
         * @param string
         * @param string
         * @return
         */
        function updateReceipentStatus($env_rec_id, $newStatus, $contactEmail, $date_modified = "")
        {
            global $db, $timedate;
            if (empty($date_modified)) {
                $date_modified = $timedate->getInstance()->nowDb();
            } else {
                $date_modified = date("Y-m-d H:i:s", strtotime($date_modified));
                $date_modified = new DateTime($date_modified);
                $date_modified = $timedate->asDb($date_modified);
            }
            $query = "SELECT id FROM contacts WHERE  deleted = 0 AND id IN (
                    SELECT eabr_scauth.bean_id
                    FROM email_addr_bean_rel AS eabr_scauth

                    INNER JOIN email_addresses AS ea_scauth
                    ON ea_scauth.deleted = 0
                    AND eabr_scauth.email_address_id = ea_scauth.id
                    AND ea_scauth.email_address = '$contactEmail'
                    WHERE eabr_scauth.deleted = 0
                    AND eabr_scauth.bean_module = 'Contacts'
                    AND eabr_scauth.primary_address = 1)";
            $result = $db->query($query);
            $document_id = array();
            $row = $result->fetch_assoc();
            $contact_id = $row['id'];
            if (!empty($contact_id)) {
                $update = "UPDATE dp_doucumentspackets_contacts_c SET date_modified ='$date_modified', receipnt_status='$newStatus' WHERE dp_doucumentspackets_contactsdp_doucumentspackets_ida='$env_rec_id' AND dp_doucumentspackets_contactscontacts_idb='$contact_id'";
                $db->query($update);
            }
        }

    }

?>
