<?php

// created: 2016-05-30 15:30:12
    $viewdefs['base']['view']['signed_copies'] = array(
        'favorite' => true,
        'panels' =>
        array(
            0 =>
            array(
                'name' => 'panel_header',
                'label' => 'LBL_PANEL_1',
                'fields' =>
                array(
                    0 =>
                    array(
                        'name' => 'name',
                        'label' => 'LBL_NAME',
                        'enabled' => true,
                        'default' => true,
                        'width' => 'medium',
                        'link' => true,
                        'sortable' => true,
                    ),
                    1 =>
                    array(
                        'name' => 'change_log',
                        'label' => 'LBL_CHANGE_LOG',
                        'enabled' => true,
                        'default' => true,
                        'width' => 'medium',
                        'sortable' => false,
                    ),
                    2 =>
                    array(
                        'name' => 'date_entered',
                        'label' => 'LBL_DATE_ENTERED',
                        'sortable' => true,
                        'default' => true,
                        'enabled' => true,
                        'width' => 'small',
                    ),
                    3 =>
                    array(
                        'name' => 'created_by_name',
                        'label' => 'LBL_CREATED_BY',
                        'enabled' => true,
                        'id' => 'created_by_id',
                        'link' => true,
                        'default' => true,
                        'width' => 'small',
                        'type' => 'created_by'
                    ),
                ),
            ),
        ),
        'orderBy' =>
        array(
            'field' => 'date_entered',
            'direction' => 'desc',
        ),
        'rowactions' =>
        array(
            'actions' =>
            array(
            ),
        ),
        'type' => 'subpanel-list',
        'buttons' => array(
        ),
    );
    