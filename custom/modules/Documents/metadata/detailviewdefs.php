<?php
// created: 2017-12-22 04:20:32
$viewdefs['Documents']['DetailView'] = array (
  'templateMeta' => 
  array (
    'maxColumns' => '2',
    'form' => 
    array (
      'hidden' => 
      array (
        0 => '<input type="hidden" name="old_id" value="{$fields.document_revision_id.value}">',
      ),
    ),
    'widths' => 
    array (
      0 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
      1 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
    ),
    'useTabs' => false,
    'tabDefs' => 
    array (
      'LBL_DOCUMENT_INFORMATION' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      'LBL_PANEL_ASSIGNMENT' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
    'syncDetailEditViews' => true,
  ),
  'panels' => 
  array (
    'lbl_document_information' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'doc_type',
          'comment' => 'Document type (ex: Google, box.net, IBM SmartCloud)',
          'studio' => 
          array (
            'wirelesseditview' => false,
            'wirelessdetailview' => false,
            'wirelesslistview' => false,
            'wireless_basic_search' => false,
          ),
          'label' => 'LBL_DOC_TYPE',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'filename',
          'displayParams' => 
          array (
            'link' => 'filename',
            'id' => 'document_revision_id',
          ),
        ),
        1 => 'status_id',
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'document_name',
          'label' => 'LBL_DOC_NAME',
        ),
        1 => 
        array (
          'name' => 'revision',
          'label' => 'LBL_DOC_VERSION',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'template_type',
          'label' => 'LBL_DET_TEMPLATE_TYPE',
        ),
        1 => 
        array (
          'name' => 'is_template',
          'label' => 'LBL_DET_IS_TEMPLATE',
        ),
      ),
      4 => 
      array (
        0 => 'active_date',
        1 => 'category_id',
      ),
      5 => 
      array (
        0 => 'subcategory_id',
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'description',
          'label' => 'LBL_DOC_DESCRIPTION',
        ),
      ),
      7 => 
      array (
        0 => 'related_doc_name',
        1 => 'related_doc_rev_number',
      ),
    ),
    'LBL_PANEL_ASSIGNMENT' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO_NAME',
        ),
        1 => 
        array (
          'name' => 'team_name',
          'label' => 'LBL_TEAM',
        ),
      ),
    ),
  ),
);