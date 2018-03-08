<?php

    $viewdefs['base']['view']['track-docusign-envelopes'] = array(
        'template' => 'list',
        'dashlets' => array(
            array(
                'label' => 'RT Track DocuSign Envelopes',
                'description' => 'Dashlet For DocuSign Envelopes Tracking',
                'config' => array(
                ),
                'preview' => array(
                ),
                'filter' => array(
                    'module' => array(
                        'Home',
                    ),
                ),
            ),
        ),
        'filter_duration' => array(
            array(
                'name' => 'select_module',
                'label' => 'LBL_MODULE',
                'type' => 'enum',
                'options' => 'env_modules_list',
                'span' => 6,
                'css_class' => 'select_module'
            ),
            array(
                'name' => 'track_date_from',
                'label' => 'LBL_FROM',
                'type' => 'date',
                'span' => 6,
                'css_class' => 'track_date_from'
            ),
            array(
                'name' => 'track_date_to',
                'label' => 'LBL_TO',
                'type' => 'date',
                'span' => 6,
                'css_class' => 'track_date_to'
            ),
            array(
                'name' => 'select_status',
                'label' => 'LBL_STATUS',
                'type' => 'enum',
                'options' => 'env_status_list',
                'isMultiSelect' => true,
                'span' => 6,
                'css_class' => 'select_status'
            ),
        ),
    );
    