<?php

if (sugar_is_file('custom/include/Google/google-api-php-client/GoogleDrive.php'))
    require_once "custom/include/Google/google-api-php-client/GoogleDrive.php";
require_once("modules/Documents/Document.php");
/**
* DriveHelper uses google api to perform syncing of documents
*
* This class is responsible for syncing documents between Google and Sugar
* It takes care of all the details like removing duplicates 
* or deleting documents on one side which are deleted on the other
*
*
*/
class DriveHelper
{

    public static $mimetype_to_extension = array(
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
        'application/vnd.oasis.opendocument.spreadsheet' => 'ods',
        'application/vnd.ms-powerpoint' => 'ppt',
        'application/vnd.ms-excel' => 'xls',
        'text/plain' => 'txt',
        'application/pdf' => 'pdf',
        'text/csv' => 'csv',
        'text/html' => 'html',
        'application/msword' => 'doc',
        'application/zip' => 'zip',
        'application/x-zip' => 'zip',
        'application/rar' => 'rar',
        'application/vnd.oasis.opendocument.text' => 'odt',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'application/rtf' => 'rtf',
        'application/vnd.sun.xml.writer' => 'sxw',
        'text/tab-separated-values' => 'tab',
        'application/vnd.google-apps.audio' => 'audio', // to discuss
        'application/vnd.google-apps.document' => 'docx',
        'application/vnd.google-apps.drawing' => 'jpeg', // all google drawings will be downloaded as jpeg images
        'application/vnd.google-apps.file' => 'file', //to discuss
        'application/vnd.google-apps.folder' => 'folder',
        'application/vnd.google-apps.form' => 'xlsx', //all google forms will be downloaded as xlsx documents
        'application/vnd.google-apps.fusiontable' => 'fusiontable', //to discuss
        'application/vnd.google-apps.kix' => 'kix', //to discuss
        'application/vnd.google-apps.photo' => 'photo', //to discuss
        'application/vnd.google-apps.presentation' => 'pptx',
        'application/vnd.google-apps.script' => 'script', //to discuss
        'application/vnd.google-apps.sites' => 'sites', //to discuss
        'application/vnd.google-apps.spreadsheet' => 'xlsx',
        'application/vnd.google-apps.unknown' => 'unkown',
        'application/vnd.google-apps.video' => 'video', //to discuss
    );

    /**
     * retrieve SugarCRM documents having modified date of document revision greater than last sync date
     * @param int    $assigned_user_id  doument's assigned user
     * @param string $lastSync          containing last sync date
     * @param array  $ids               ids of documents modified in this batch earliar to avoid remodify again
     *
     * @return array of beans of modified documents
     */
    public static function retrieveUpdatedFromSugar($assigned_user_id, $lastSync, $ids = array())
    {
        global $db;

        //$sql = "SELECT DISTINCT d.id,d.gdrive_id,d.deleted FROM documents d JOIN document_revisions dr ON dr.id=d.document_revision_id WHERE d.assigned_user_id= '" . $assigned_user_id . "' AND (dr.date_entered >'" . $lastSync . "' OR (d.date_modified >'" . $lastSync . "' AND d.deleted='1'))";
        $sql = "SELECT DISTINCT d.id,d.gdrive_id,d.deleted FROM documents d WHERE d.assigned_user_id= '" . $assigned_user_id . "' AND  d.date_modified >'" . $lastSync . "'";
        if (!empty($ids)) {
            if (strtolower($db->dbType) == 'mysql') {
                $sql = $sql . " AND ifnull(d.gdrive_id,'null') NOT IN ('" . implode("','", $ids) . "')";
            } else {
                $sql = $sql . " AND d.gdrive_id NOT IN ('" . implode("','", $ids) . "') OR gdrive_id IS NULL";
            }
        }
        $res = $db->query($sql);

        $beans = array();
        while ($row = $db->fetchByAssoc($res)) {
            $bean = new Document();
            $bean->retrieve($row['id']);
            if ($row['deleted'] == '1' || $row['deleted'] == 1) {
                $bean->id = $row['id'];
                $bean->gdrive_id = $row['gdrive_id'];
                $bean->deleted = '1';
                $bean->document_revision_id = '1';
            }
            $beans[] = $bean;
        }


        return $beans;
    }

    /**
     * retrieve GOOGLE files having modified date of document revision greater than last sync date
     * @param Google_DriveService $service Drive API service instance.
     * @param int $userID doument's assigned user id
     * @param string $lastSync containing last sync date
     * @return array  ids of documents modified now to avoid sending back these files for modification to GOOGLE
     */
    public static function updateFromGoogle($service, $userID, $lastSync)
    {

        $GD = new GoogleDrive();
        $ids = array();
        $lastSync_g = date('Y-m-d H:i', strtotime($lastSync));
        $lastSync_g = str_replace(' ', 'T', $lastSync_g) . ":00.000Z";

        //handlig trashed files in google
        $files_deleted = $GD->getTrashedFiles($service);
        if ($files_deleted && !empty($files_deleted)) {


            foreach ($files_deleted as $file) {
                $deleted_ids[] = $file['id'];
                try {

                    $tmp = new Document();
                    $tmp->retrieve_by_string_fields(array('gdrive_id' => $file['id']));
                    $tmp->deleted = '1';
                    if (!empty($tmp->id) && $tmp->save()) {

                        $GLOBALS['log']->fatal($tmp->object_name . ": " . $tmp->filename . " with id " . $tmp->id . " having revision id " . $tmp->document_revision_id . " deleted in Sugar.");
                    }
                } catch (Exception $e) {
                    $GLOBALS['log']->fatal('Exception Occurred: ' . $e->getMessage());
                }
            }
            $ids = array_merge($ids, $deleted_ids);
        }

        // hadling updated/modified files in google

        $GD->setQ(array("modifiedDate >= '" . $lastSync_g . "'", "mimeType!='application/vnd.google-apps.folder'", "'me' in owners", "trashed=false"));
        $files = $GD->getUpdatedFiles($service);

        if ($files && !empty($files)) {

            foreach ($files as $file) {
                if ($file['labels']['trashed'] == 1 || $file['labels']['trashed'] == '1' || $file['labels']['trashed'] === true) {
                    //do nothing as we have handled trashed files above
                } else {
                    //updateSugarFile($file_meta,$userID,$service)
                    $id = self::updateSugarDocs($file, $userID, $service, $lastSync);
                }
                if (isset($id) && $id !== false) {
                    $ids[] = $id;
                    unset($id);
                }
            }
        } else {
            //$GLOBALS['log']->fatal("GOOGLE: no updated files found from ".$lastSync_g." onward");
        }


        //die();
        return $ids;
    }

    /**
     * update or trash files from GOOGLE
     * @param Google_DriveService $service Drive API service instance.
     * @param array $beans modified beans
     */
    public static function sendUpdatedToGoogle($service, $beans)
    {
        global $db;
        $GD = new GoogleDrive();
        foreach ($beans as $bean) {
            try {
                if ($bean->deleted != '1' && !empty($bean->document_revision_id)) { //deleted=0 from sugar
                    if (empty($bean->gdrive_id)) {
                        //addFile($service, $title, $description, $parentId, $mimeType, $filename)
                        $createdFile = $GD->addFile($service, $bean->document_name, $bean->description, null, $bean->last_rev_mime_type, $GLOBALS['sugar_config']['upload_dir'] . $bean->document_revision_id);
                        if ($createdFile) {
                            $sql = "UPDATE documents SET gdrive_id='" . $createdFile->id . "' WHERE id='" . $bean->id . "'";
                            $db->query($sql);
                            $GLOBALS['log']->fatal($bean->object_name . ": " . $bean->filename . " with id " . $bean->id . " having revision id " . $bean->document_revision_id . " saved in Google.");
                        }
                    } else {
                        //handling revisions
                        $rev = 0;
                        $r = $db->query("SELECT COUNT(*) as rev FROM document_revisions WHERE document_id='" . $bean->id . "'");
                        if ($rw = $db->fetchByAssoc($r)) {
                            $rev = $rw['rev'];
                        }
                        //updateFile($service, $fileId, $newTitle, $newDescription, $newMimeType, $newFileName, $newRevision)
                        $updatedFile = $GD->updateFile($service, $bean->gdrive_id, $bean->document_name, $bean->description, $bean->last_rev_mime_type, $GLOBALS['sugar_config']['upload_dir'] . $bean->document_revision_id, $rev + 1, str_replace(' ', 'T', gmdate('Y-m-d H:i:s')) . ".000Z");
                        if ($updatedFile) {
                            if ($updatedFile == '404') {
                                //file has been deleted permanently from google so delete from sugar also....
                                $sql_document = "UPDATE documents SET deleted='1',date_modified='" . gmdate($GLOBALS['timedate']->get_db_date_time_format()) . "' WHERE id='" . $bean->id . "';";
                                $result = $GLOBALS['db']->query($sql_document);
                                $GLOBALS['log']->fatal($bean->object_name . ": " . $bean->filename . " with id " . $bean->id . " having revision id " . $bean->document_revision_id . " deleted in Sugar(reason: not found in GOOGLE).");
                            } else {
                                $GLOBALS['log']->fatal($bean->object_name . ": " . $bean->filename . " with id " . $bean->id . " having revision id " . $bean->document_revision_id . " updated in Google.");
                            }
                        }
                    }
                } else {
                    //trashFile($service, $fileId)
                    if (!empty($bean->gdrive_id)) {
                        $deletedFile = $GD->trashFile($service, $bean->gdrive_id);
                        if ($deletedFile) {
                            $GLOBALS['log']->fatal($bean->object_name . ": " . $bean->filename . " with id " . $bean->id . " trashed in Google.");
                        }
                    }
                }
            } catch (Exception $e) {
                $GLOBALS['log']->fatal('GOOGLE- UPDATION ERROR:' . $e->getMessage());
            }
        }
    }

    /**
     * create or update file in SugarCRM
     * @param array $file_meta containing metedata of file to be created or updated
     * @param int $userID doument's assigned user id
     * @param Google_DriveService $service Drive API service instance.
     * @return true if modification/creation successfull false otherwise
     */
    public static function updateSugarDocs($file_meta, $userID, $service, $lastSync)
    {
        $GD = new GoogleDrive();
        $file = self::toArray($file_meta);
        $file['assigned_user_id'] = $userID;

        $tmp = new Document();
        $tmp->retrieve_by_string_fields(array('gdrive_id' => $file['gdrive_id']));

        //START: document deleted in SugarCRM but not deleted in Google

        $sql = "SELECT * FROM " . $tmp->table_name . " WHERE gdrive_id='" . $file['gdrive_id'] . "';";
        $result = $GLOBALS['db']->query($sql);
        $row = $GLOBALS['db']->fetchByAssoc($result);
        if ($row) {

            if (!empty($row['gdrive_id']) && $row['deleted'] == '1') {
                $GLOBALS['log']->fatal($tmp->object_name . ": " . $row['document_name'] . " with id " . $row['id'] . " deleted in SugarCRM but not deleted in Google.");
                return false;
            }//no id is returned so that we can delete document in Google
        }

        //END: document deleted in SugarCRM but not deleted in Google
        //Bug #11115
        // if due to any reason file come in result but date_modified is less than sync date then return dont update
        $date_modified = gmdate($GLOBALS['timedate']->get_db_date_time_format(), strtotime($file['date_modified']));
        if (!empty($tmp->gdrive_id) && strtotime($date_modified) <= strtotime($lastSync)) {
            return false;
        }

        if (empty($tmp->id)) {
            $tmp->id = create_guid();
            $tmp->new_with_id = true;

            //2013-09-24J v1.6 changes
            $tmp->modified_user_id = $userID;
            $tmp->update_modified_by = false;
            $tmp->created_by = $userID;
            $tmp->set_created_by = false;
            //2013-09-24J v1.6 changes end
        }

        foreach ($file as $k => $v) {
            $tmp->$k = $v;
        }

        //Hadling Revision
        $Revision = new DocumentRevision();

        $rev = 0;
        $r = $Revision->db->query("SELECT COUNT(*) as rev FROM document_revisions WHERE document_id='" . $tmp->id . "'");
        if ($rw = $Revision->db->fetchByAssoc($r)) {
            $rev = $rw['rev'];
        }

        $Revision->id = create_guid();
        $Revision->new_with_id = true;
        $Revision->in_workflow = true;
        $Revision->not_use_rel_in_req = true;
        $Revision->new_rel_id = $tmp->id;
        $Revision->new_rel_relname = 'Documents';
        $Revision->change_log = ($rev == 0) ? translate('DEF_CREATE_LOG', 'Documents') : '';
        $Revision->revision = $rev + 1;
        $Revision->document_id = $tmp->id;
        $Revision->filename = $tmp->filename;
        $Revision->file_ext = isset($tmp->file_ext) ? $tmp->file_ext : '';
        $Revision->file_mime_type = isset($tmp->file_mime_type) ? self::getFilemimeType($tmp->file_mime_type) : '';
        $Revision->doc_type = $tmp->doc_type;

        //2013-09-24J v1.6 changes
        $Revision->modified_user_id = $userID;
        $Revision->update_modified_by = false;
        $Revision->created_by = $userID;
        $Revision->set_created_by = false;
        //2013-09-24J v1.6 changes end
        //Downloading file
        try {

            $file['downloadPath'] = $GLOBALS['sugar_config']['upload_dir'] . $Revision->id;
            $downloaded = $GD->downloadFile($service, $file);

            if ($downloaded) {
                $GLOBALS['log']->fatal("File downloaded successfully location: " . $file['downloadPath']);
            } else {

                return false; // returning to calling function withoud id
            }

            if ($Revision->save()) {
                $tmp->document_revision_id = $Revision->id;

                if ($tmp->save()) {
                    $GLOBALS['log']->fatal($tmp->object_name . ": " . $tmp->filename . " with id " . $tmp->id . " saved in SugarCRM.");
                    return $tmp->gdrive_id;
                }
            }
        } catch (Exception $ex) {
            $GLOBALS['log']->fatal('GOOGLE - DOWNLOAD ERROR for ' . $tmp->filename . ' :' . $ex->getMessage());
            return false; //return without id
        }
    }

    /**
     * format meta array of file so that it can be created/updated in SugarCRM
     * @param array $file_meta returned from GOOGLE of updated files
     * @return array 
     */
    public static function toArray($file_meta)
    {
        $file = array();

        $file['gdrive_id'] = $file_meta['id'];
        $file['document_name'] = $file_meta['title'];
        $file['file_mime_type'] = $file_meta['mimeType'];
        $file['description'] = $file_meta['description'];
        $file['doc_type'] = 'Sugar';
        $file['filename'] = $file_meta['title'];
        $file['active_date'] = date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($file_meta['createdDate']));
        $filename = substr($file['filename'], 0, (strrpos($file['filename'], '.', 0) !== false) ? (strrpos($file['filename'], '.', 0)) : strlen($file['filename']));
        $file['fileExtension'] = self::getFileExtension($file_meta);
        $filename = $filename . (!empty($file['fileExtension']) ? "." . $file['fileExtension'] : '');
        $file['filename'] = $filename;
        $date_modified = date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($file_meta['modifiedDate']));
        $file['date_modified'] = $date_modified;
        $file['exportLinks'] = $file_meta['exportLinks'];
        $file['exportLink'] = self::getExportFormat($file_meta);
        return $file;
    }

    /**
    *
    * @param array $file_meta returned from GOOGLE of updated files
    * @return string google export link
    */
    public static function getExportFormat($file_meta)
    {
        $link = "";
        $fileExtension = self::getFileExtension($file_meta);
        if (!empty($file_meta['exportLinks']))
            foreach ($file_meta['exportLinks'] as $key => $exportLink) {
                if (strpos(strtolower($exportLink), "exportformat=" . trim($fileExtension)) !== false)
                    $link = $exportLink;
            }
        return $link;
    }
    /**
    * Returns an extension against a mime type
    * @param array $file_meta returned from GOOGLE of updated files
    * @return string file extension if unable to find extension from given meta data return empty string
    */
    public static function getFileExtension($file_meta)
    {
        if (!empty($file_meta['fileExtension'])) {
            return $file_meta['fileExtension'];
        } else {
            if (isset(DriveHelper::$mimetype_to_extension[$file_meta['mimeType']])) {
                return DriveHelper::$mimetype_to_extension[$file_meta['mimeType']];
            } else {
                return "";
            }
        }
    }

    /**
    * this function is added due to drive send mimeType in format of application/vnd.google-apps..
    * it creates problems while creating new file in google having this format of mimeType
    * Bug #10781 mimeType issue
    * @param array $file_meta returned from GOOGLE of updated files
    * @return string file extension if unable to find extension from given meta data return empty string
    */
    public static function getFilemimeType($mimeType)
    {
        $mimeTypes = array(
            'application/vnd.google-apps.document' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.google-apps.presentation' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.google-apps.spreadsheet' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );
        if (isset($mimeTypes[$mimeType])) {
            return $mimeTypes[$mimeType];
        } else
            return $mimeType;
    }

}

/* 1011 */
?>