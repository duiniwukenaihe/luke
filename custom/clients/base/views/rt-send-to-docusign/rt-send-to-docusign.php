<?php

    if (!defined('sugarEntry') || !sugarEntry)
        die('Not A Valid Entry Point');
    /*     * *******************************************************************************
     * By installing or using this file, you are confirming on behalf of the entity
     * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
     * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
     * http://www.sugarcrm.com/master-subscription-agreement
     *
     * If Company is not bound by the MSA, then by installing or using this file
     * you are agreeing unconditionally that Company will be bound by the MSA and
     * certifying that you have authority to bind Company accordingly.
     *
     * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
     * ****************************************************************************** */

// PRO/CORP only fields
    $fields = array(
        'attacheddocuments_c' => array(
            'name' => 'attacheddocuments_c',
            'type' => 'relate',
            'module' => 'mv_Attachments',
            'event' => 'button:attacheddocuments_c:change',
            'label' => 'Attachments',
            'view' => 'edit',
            'default' => false,
            'enabled' => true,
            'required' => false,
            'initial_filter' => 'unsigned',
            'initial_filter_label' => 'Unsigned',
            'filter_populate' => array(
                'signed_copy' => false
            ),
        ),
        'attachedcontacts_c' => array(
            'name' => 'attachedcontacts_c',
            'type' => 'relate',
            'label' => 'Attached Contacts',
            'module' => 'Contacts',
            'view' => 'edit',
            'default' => false,
            'enabled' => true,
            'required' => false,
            'css_class' => 'attached_contacts'
        ),
        'signed_attachment_type' => array(
            'name' => 'signed_attachment_type',
            'type' => 'enum',
            'label' => 'Attachment Type',
            'module' => 'mv_Attachments',
            'view' => 'edit',
            'enabled' => true,
            'len' => 100,
            'options' => 'document_template_type_dom',
            'required' => true,
        ),
        'docusign_templates' => array(
            'name' => 'docusign_templates',
            'type' => 'enum',
            'label' => 'Getting Docusign Templates. Please wait...',
            'module' => 'mv_Attachments',
            'view' => 'edit',
            'enabled' => true,
            'len' => 100,
            'options' => 'docusign_templates',
            'required' => true,
        ),
        'documents_type' => array(
            'name' => 'documents_type',
            'type' => 'enum',
            'label' => 'Documents Type',
            'module' => 'mv_Attachments',
            'view' => 'edit',
            'enabled' => true,
            'default' =>'Sugar Attachments',
            'len' => 100,
            'options' => 'documents_type',
            'required' => true,
        ),
    );




    $viewdefs['base']['view']['rt-send-to-docusign'] = array(
        'panels' => array(
            array(
                'label' => 'Send To DocuSign',
                'columns' => 2,
                'fields' => $fields,
            )
        )
    );
    