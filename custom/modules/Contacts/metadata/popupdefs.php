<?php
$popupMeta = array (
    'moduleMain' => 'Contact',
    'varName' => 'CONTACT',
    'orderBy' => 'contacts.first_name, contacts.last_name',
    'whereClauses' => array (
  'first_name' => 'contacts.first_name',
  'last_name' => 'contacts.last_name',
  'account_name' => 'accounts.name',
  'salutation' => 'contacts.salutation',
  'description' => 'contacts.description',
  'created_by_name' => 'contacts.created_by_name',
  'phone_fax' => 'contacts.phone_fax',
  'phone_other' => 'contacts.phone_other',
  'phone_work' => 'contacts.phone_work',
  'phone_mobile' => 'contacts.phone_mobile',
  'phone_home' => 'contacts.phone_home',
  'do_not_call' => 'contacts.do_not_call',
  'department' => 'contacts.department',
  'modified_by_name' => 'contacts.modified_by_name',
  'date_modified' => 'contacts.date_modified',
  'date_entered' => 'contacts.date_entered',
  'name' => 'contacts.name',
  'title' => 'contacts.title',
  'lead_source' => 'contacts.lead_source',
  'email' => 'contacts.email',
  'campaign_name' => 'contacts.campaign_name',
  'assigned_user_id' => 'contacts.assigned_user_id',
  'report_to_name' => 'contacts.report_to_name',
  'my_favorite' => 'contacts.my_favorite',
  'tag' => 'contacts.tag',
  'assigned_user_name' => 'contacts.assigned_user_name',
  'team_name' => 'contacts.team_name',
  'subcontractor_email_group_c' => 'contacts_cstm.subcontractor_email_group_c',
),
    'searchInputs' => array (
  0 => 'first_name',
  1 => 'last_name',
  2 => 'account_name',
  3 => 'email',
  4 => 'salutation',
  5 => 'description',
  6 => 'created_by_name',
  7 => 'phone_fax',
  8 => 'phone_other',
  9 => 'phone_work',
  10 => 'phone_mobile',
  11 => 'phone_home',
  12 => 'do_not_call',
  13 => 'department',
  14 => 'modified_by_name',
  15 => 'date_modified',
  16 => 'date_entered',
  17 => 'name',
  18 => 'title',
  19 => 'lead_source',
  20 => 'campaign_name',
  21 => 'assigned_user_id',
  22 => 'report_to_name',
  23 => 'my_favorite',
  24 => 'tag',
  25 => 'assigned_user_name',
  26 => 'team_name',
  27 => 'subcontractor_email_group_c',
),
    'create' => array (
  'formBase' => 'ContactFormBase.php',
  'formBaseClass' => 'ContactFormBase',
  'getFormBodyParams' => 
  array (
    0 => '',
    1 => '',
    2 => 'ContactSave',
  ),
  'createButton' => 'LNK_NEW_CONTACT',
),
    'searchdefs' => array (
  'salutation' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_SALUTATION',
    'width' => '10',
    'name' => 'salutation',
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10',
    'name' => 'description',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'readonly' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10',
    'name' => 'created_by_name',
  ),
  'phone_fax' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_FAX_PHONE',
    'width' => '10',
    'name' => 'phone_fax',
  ),
  'phone_other' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_OTHER_PHONE',
    'width' => '10',
    'name' => 'phone_other',
  ),
  'phone_work' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_OFFICE_PHONE',
    'width' => '10',
    'name' => 'phone_work',
  ),
  'phone_mobile' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_MOBILE_PHONE',
    'width' => '10',
    'name' => 'phone_mobile',
  ),
  'phone_home' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_HOME_PHONE',
    'width' => '10',
    'name' => 'phone_home',
  ),
  'report_to_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_REPORTS_TO',
    'id' => 'REPORTS_TO_ID',
    'width' => 10,
    'name' => 'report_to_name',
  ),
  'do_not_call' => 
  array (
    'type' => 'bool',
    'label' => 'LBL_DO_NOT_CALL',
    'width' => '10',
    'name' => 'do_not_call',
  ),
  'my_favorite' => 
  array (
    'type' => 'bool',
    'studio' => 
    array (
      'list' => false,
      'recordview' => false,
      'basic_search' => false,
      'advanced_search' => false,
    ),
    'link' => 'favorite_link',
    'label' => 'LBL_FAVORITE',
    'width' => 10,
    'name' => 'my_favorite',
  ),
  'tag' => 
  array (
    'type' => 'tag',
    'link' => 'tag_link',
    'studio' => 
    array (
      'portal' => false,
      'base' => 
      array (
        'popuplist' => false,
      ),
      'mobile' => 
      array (
        'wirelesseditview' => true,
        'wirelessdetailview' => true,
      ),
    ),
    'sortable' => false,
    'label' => 'LBL_TAGS',
    'width' => 10,
    'name' => 'tag',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => 10,
    'name' => 'assigned_user_name',
  ),
  'team_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'studio' => 
    array (
      'portallistview' => false,
      'portalrecordview' => false,
    ),
    'label' => 'LBL_TEAMS',
    'id' => 'TEAM_ID',
    'width' => 10,
    'name' => 'team_name',
  ),
  'department' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_DEPARTMENT',
    'width' => '10',
    'name' => 'department',
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'readonly' => true,
    'label' => 'LBL_MODIFIED',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10',
    'name' => 'modified_by_name',
  ),
  'subcontractor_email_group_c' => 
  array (
    'type' => 'multienum',
    'label' => 'LBL_SUBCONTRACTOR_EMAIL_GROUP_C',
    'width' => 10,
    'name' => 'subcontractor_email_group_c',
  ),
  'date_modified' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10',
    'name' => 'date_modified',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10',
    'name' => 'date_entered',
  ),
  'name' => 
  array (
    'type' => 'fullname',
    'label' => 'LBL_NAME',
    'width' => '10',
    'name' => 'name',
  ),
  'first_name' => 
  array (
    'name' => 'first_name',
    'width' => '10',
  ),
  'last_name' => 
  array (
    'name' => 'last_name',
    'width' => '10',
  ),
  'account_name' => 
  array (
    'name' => 'account_name',
    'type' => 'varchar',
    'width' => '10',
  ),
  'title' => 
  array (
    'name' => 'title',
    'width' => '10',
  ),
  'lead_source' => 
  array (
    'name' => 'lead_source',
    'width' => '10',
  ),
  'email' => 
  array (
    'name' => 'email',
    'width' => '10',
  ),
  'campaign_name' => 
  array (
    'name' => 'campaign_name',
    'displayParams' => 
    array (
      'hideButtons' => 'true',
      'size' => 30,
      'class' => 'sqsEnabled sqsNoAutofill',
    ),
    'width' => '10',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'type' => 'enum',
    'label' => 'LBL_ASSIGNED_TO',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10',
  ),
),
    'listviewdefs' => array (
  'TITLE' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_TITLE',
    'default' => true,
    'name' => 'title',
  ),
  'ACCOUNT_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'module' => 'Accounts',
    'id' => 'ACCOUNT_ID',
    'default' => true,
    'sortable' => true,
    'ACLTag' => 'ACCOUNT',
    'related_fields' => 
    array (
      0 => 'account_id',
    ),
    'name' => 'account_name',
  ),
  'EMAIL' => 
  array (
    'type' => 'email',
    'studio' => 
    array (
      'visible' => true,
      'searchview' => true,
      'editview' => true,
      'editField' => true,
    ),
    'link' => 'email_addresses_primary',
    'label' => 'LBL_ANY_EMAIL',
    'sortable' => false,
    'width' => 10,
    'default' => true,
  ),
),
);
