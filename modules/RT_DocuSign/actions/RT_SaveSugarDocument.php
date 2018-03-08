<?php

    require_once 'include/upload_file.php';

    class RT_SaveSugarDocument {

        public function saveDocument($document_name, $document_content, $source = "Sugar", $mode = "1")
        {

            $GLOBALS['log']->debug('DocuSign::createDocument() - Entering');
            $docRevisionId = "";

            try {

                $doc = new Document();
                $doc->document_name = $document_name;
                $doc->doc_type = $source;
                $doc->team_id = 1;
                $doc->team_set_id = 1;
                $docId = $doc->save();


                // updating the document.
                $doc = new Document();
                $doc->retrieve($docId);

                $uploadFile = new UploadFile('filename_file');
                $uploadFile->set_for_soap($document_name, $document_content);
                $ext_pos = strrpos($document_name, ".");
                $uploadFile->file_ext = substr($document_name, $ext_pos + 1);

                $docRevision = new DocumentRevision();
                $docRevision->filename = $uploadFile->get_stored_file_name();
                $docRevision->file_mime_type = 'application/pdf';
                $docRevision->file_ext = $uploadFile->file_ext;
                $docRevision->doc_type = "Sugar";

                $docRevision->revision = 1;
                $docRevision->document_id = $docId;
                $docRevision->save();

                $doc->document_revision_id = $docRevision->id;
                $doc->save();
                $uploadFile->final_move($docRevision->id);
                if ($mode == "1") {
                    $docRevisionId = $docRevision->id;
                } else if ($mode == "2") {
                    $docRevisionId = $docId;
                }
                //$GLOBALS['log']->fatal("upload file errors -- in Create Document".print_r($uploadFile,true));
            } catch (Exception $e) {
                $docId = "";
                $GLOBALS['log']->debut("Exception: " . $e->getMessage());
            }
            return $docRevisionId;
        }

        // function to update Revision of Sugar Document.
        public function updateDocumentRevision($docId, $document_name, $document_content, $change_log, $source = "Sugar", $status = "", $envelope_id)
        {
            global $db;
            $docRevisionId = "";
            try {

                $document_bean = BeanFactory::retrieveBean('Documents', $docId, array('disable_row_level_security' => true));
                $doc_type = $document_bean->doc_type;
                $created_by = $document_bean->created_by;
                $old_rev_id = $document_bean->document_revision_id;
                $docname = $document_bean->document_name;

                $docRevision_old = new DocumentRevision();
                $docRevision_old->retrieve($old_rev_id);
                $old_rev_count = $docRevision_old->revision;

                // As docusign contains files in pdf format. So we are saving file as pdf.
                if (strpos($docname, '.pdf') == false) {
                    $docname = $docname . ".pdf";
                }

                $uploadFile = new UploadFile('filename_file');


                $uploadFile->set_for_soap($docname, $document_content);
                $uploadFile->file_ext = "pdf";

                $docRevision = new DocumentRevision();
                $docRevision->filename = $uploadFile->get_stored_file_name();
                $docRevision->file_mime_type = 'application/pdf';
                $docRevision->file_ext = $uploadFile->file_ext;
                $docRevision->created_by = $created_by;
                $docRevision->doc_type = $doc_type;
                $docRevision->change_log = $change_log;
                $docRevision->revision = intval($old_rev_count) + 1;
                $docRevision->document_id = $docId;
                $docRevision->save();


                // updating Document Record with new Revision ID.
                $document_bean->document_name = $uploadFile->get_stored_file_name();
                $document_bean->document_revision_id = $docRevision->id;
                $document_bean->status_id = "Active";
                $document_bean->save();

                // moving final documents
                $uploadFile->final_move($docRevision->id);
                //$GLOBALS['log']->fatal("upload file errors -- in REvision".print_r($uploadFile,true));
                $docRevisionId = $docRevision->id;

                // updating created by as it is not updated by bean.			
                $sql = "UPDATE document_revisions SET created_by = '$created_by' WHERE id = '{$docRevision->id}'";
                $docRevision->db->query($sql);

                /*
                 * Creating Signed Atachment
                 */
                $change_log_lbl = translate('LBL_RT_DOCUSGIN_SIGNED_BY_ALL_CHNG_LOG', 'RT_DocuSign');
                if ($change_log == $change_log_lbl && $doc_type == "PDF" && !empty($envelope_id)) {
                    $envelope = BeanFactory::retrieveBean('DP_DoucumentsPackets', $envelope_id, array('disable_row_level_security' => true));
                    $uploadSignedCopy = new UploadFile('filename_file');
                    $uploadSignedCopy->set_for_soap($envelope->signed_attachment_name, $document_content);
                    $uploadSignedCopy->file_ext = "pdf";

                    $attachment = new mv_Attachments();
                    $attachment->document_name = $envelope->signed_attachment_name;
                    $attachment->filename = $uploadSignedCopy->get_stored_file_name();
                    $attachment->file_mime_type = 'application/pdf';
                    $attachment->file_ext = $uploadSignedCopy->file_ext;
                    $attachment->created_by = $created_by;
                    $attachment->modified_user_id = $created_by;
                    $attachment->assigned_user_id = $created_by;
                    $attachment->parent_id = $envelope->parent_id;
                    $attachment->parent_type = $envelope->parent_type;
                    $attachment->signed_copy = true;
                    $attachment->category_id = $envelope->signed_attachment_type;
                    $attachment->save();
                    $attachment->load_relationship('dp_doucumentspackets_mv_attachments_1');
                    $attachment->dp_doucumentspackets_mv_attachments_1->add($envelope_id);
                    $uploadSignedCopy->final_move($attachment->id);

                    /*
                     * Removing attachment from  subpanel
                     */
                    $query = "select attachment_id from dp_doucumentspackets_attachments where deleted=0 and packet_id='$envelope->id'";
                    $result = $db->query($query);
                    while ($row = $result->fetch_assoc()) {
                        $attachment_id = $row['attachment_id'];
                        $db->query("UPDATE mv_attachments SET parent_type = '', parent_id = '' WHERE id = '$attachment_id'");
                    }
                }
            } catch (Exception $e) {
                $docId = "";
                $GLOBALS['log']->debut("Exception: " . $e->getMessage());
            }

            return $docRevisionId;
        }

        // function to update Revision of Sugar Document.
        public function createSignedAttachment($docId, $document_name, $document_content, $change_log, $source = "Sugar")
        {
            try {
                $document_bean = BeanFactory::retrieveBean('Documents', $docId, array('disable_row_level_security' => true));
                $doc_type = $document_bean->doc_type;
                $created_by = $document_bean->created_by;
                $old_rev_id = $document_bean->document_revision_id;
                $docname = $document_bean->document_name;

                $docRevision_old = new DocumentRevision();
                $docRevision_old->retrieve($old_rev_id);
                $old_rev_count = $docRevision_old->revision;

                // As docusign contains files in pdf format. So we are saving file as pdf.
                if (strpos($docname, '.pdf') == false) {
                    $docname = $docname . ".pdf";
                }
                $uploadFile = new UploadFile('filename_file');


                $uploadFile->set_for_soap($docname, $document_content);
                $uploadFile->file_ext = "pdf";

                $docRevision = new mv_Attachments();
                $docRevision->filename = $uploadFile->get_stored_file_name();
                $docRevision->file_mime_type = 'application/pdf';
                $docRevision->file_ext = $uploadFile->file_ext;
                $docRevision->created_by = $created_by;
                $docRevision->doc_type = $doc_type;
                $docRevision->change_log = $change_log;
                $docRevision->revision = intval($old_rev_count) + 1;
                $docRevision->document_id = $docId;
                $docRevision->save();


                // updating Document Record with new Revision ID.
                $document_bean->document_name = $uploadFile->get_stored_file_name();
                $document_bean->document_revision_id = $docRevision->id;
                $document_bean->status_id = "Active";
                $document_bean->save();
            } catch (Exception $e) {
                $docId = "";
                $GLOBALS['log']->debut("Exception: " . $e->getMessage());
            }
        }

    }
    