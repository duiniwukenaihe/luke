<?php

    global $db,$current_user,$timedate;
    $modules = array(
        'Accounts' => 'Accounts',
        'Leads' => 'Leads',
        'Contacts' => 'Contacts',
        'Cases' => 'Warranties',
        'Opportunities' => 'Opportunities',
        'm_CAMS' => 'CAM',
    );
    
    $offset = $_REQUEST['offset'];
    $limit = $_REQUEST['limit'];
    $track_date_from = $_REQUEST['track_date_from'];
    $track_date_to = $_REQUEST['track_date_to'];
    $select_module = $_REQUEST['select_module'];
    $select_status = explode(",",$_REQUEST['select_status']);
    $sort_by = $_REQUEST['sort_by'];
    $order = $_REQUEST['order'];
    $query = "";
    $query = "SELECT * from dp_doucumentspackets";
    $count_query = "SELECT count(*) count from dp_doucumentspackets";

    $where = " WHERE deleted=0";
    if (!empty($select_module)) {
        $module = $select_module;
        $where .= " AND parent_type = '$module'";
    }
    if (!empty($track_date_from) && !empty($track_date_to)) {
        $track_date_from = date("Y-m-d", strtotime($track_date_from));
        $track_date_to = date("Y-m-d", strtotime($track_date_to));
        $where .= " AND (date_entered between '$track_date_from 00:00:00' AND '$track_date_to 23:59:00')";
    } else if (!empty($track_date_from)) {
        $track_date_from = date("Y-m-d", strtotime($track_date_from));
        $where .= " AND date_entered >= '$track_date_from 00:00:00'";
    } else if (!empty($track_date_to)) {
        $track_date_to = date("Y-m-d", strtotime($track_date_to));
        $where .= " AND date_entered <= '$track_date_to 23:59:00'";
    }
    if(!empty($select_status[0]) && count($select_status) > 0) {
        $select_status = implode("','", $select_status);
        $select_status = "'".$select_status."'";
        $where .= " AND packetstatus IN ($select_status)";
    }
    
    if(!$current_user->is_admin) {
        $where .= " AND assigned_user_id = '$current_user->id'";
    }
    
    $count_query = $count_query . $where;
    $count_result = $db->query($count_query);
    $count_result = $db->fetchByAssoc($count_result);
    $total = $count_result['count'];
    $query .= " $where ORDER BY $sort_by $order LIMIT $limit OFFSET $offset";
    
    $result = $db->query($query);
    $response = array();
    $response["total"] = $total;
    $data = array();
    while ($row = $db->fetchByAssoc($result)) {
        //print_r($row);
        $env_id = $row['id'];
        $parent_name = getName($row['parent_type'], $row['parent_id']);
        $created_by_name = getName("Users", $row['created_by']);
        $doc_name = getName("Documents", $row['document_id_c']);

        $related_contacts_query = "SELECT * from dp_doucumentspackets_contacts_c WHERE 	dp_doucumentspackets_contactsdp_doucumentspackets_ida = '$env_id' AND deleted=0";
        $related_contacts_result = $db->query($related_contacts_query);
        $related_contacts = array();
        $total_contacts = 0;
        $completed_contacts = 0;
        while ($related_contact = $db->fetchByAssoc($related_contacts_result)) {
            $total_contacts++;
            if ($related_contact['receipnt_status'] == 'Completed') {
                $completed_contacts++;
            }
            $related_contacts[] = array(
                'contact_id' => $related_contact['dp_doucumentspackets_contactscontacts_idb'],
                'contact_name' => getName("Contacts", $related_contact['dp_doucumentspackets_contactscontacts_idb']),
                'contact_status' => (empty($related_contact['receipnt_status']) ? " " : $related_contact['receipnt_status']),
                //'date_modified' => date("d-m-Y H:i:s", strtotime($related_contact['date_modified'])),
                'date_modified' => $timedate->to_display_date_time($related_contact['date_modified'], true, true, $current_user),
            );
        }
        $completed = $completed_contacts . " of " . $total_contacts;
        $env = array(
            'id' => $env_id,
            'name' => $row['name'],
            'packetstatus' => $row['packetstatus'],
            'parent_id' => $row['parent_id'],
            'parent_name' => $parent_name,
            'parent_type' => $row['parent_type'],
            'parent_label' => (empty($modules[$row['parent_type']]) ? " " : $modules[$row['parent_type']]),
            //'date_entered' => date("d-m-Y H:i:s", strtotime($row['date_entered'])),
            'date_entered' => $timedate->to_display_date_time($row['date_entered'], true, true, $current_user),
            'created_by_id' => $row['created_by'],
            'created_by_name' => $created_by_name,
            'document_id' => $row['document_id_c'],
            'document_name' => $doc_name,
            'total' => $total,
            'related_contacts' => $related_contacts,
            'completed' => $completed,
        );

        $data[] = $env;
    }
    $response["data"] = $data;
    $date_format = $timedate->get_date_format();
    $date_format = str_replace("d", "dd", $date_format);
    $date_format = str_replace("m", "mm", $date_format);
    $date_format = str_replace("Y", "yyyy", $date_format);
    $response["date_format"] = $date_format;
    echo json_encode($response);
    exit();

    function getName($module, $id)
    {
        global $db;
        if (empty($id)) {
            $name = '';
        } else {
            $table = strtolower($module);
            $select = "name";
            if ($module == 'Documents') {
                $select = "document_name";
            } else if ($module == 'Users' || $module == 'Leads' || $module == 'Contacts') {
                $select = "first_name,last_name";
            }
            $get_name_query = "select $select from $table where id='$id'";
            $get_name_queryresult = $db->query($get_name_query);
            $result = $db->fetchByAssoc($get_name_queryresult);
            if ($module == 'Users' || $module == 'Leads' || $module == 'Contacts') {
                $name = $result['first_name'] . " " . $result['last_name'];
            } else {
                $name = $result[$select];
            }
        }
        return $name;
    }
    