<?php
    $viewdefs['mv_Attachments']['base']['filter']['basic']['filters'][] = array(
        'id' => 'unsigned',
        'name' => 'Unsinged',
        'filter_definition' => array(
            array(
                'signed_copy' => array(
                    '$equals' => false,
                ),
            ),
        ),
        'editable' => true,
        'is_template' => false,
    );
    