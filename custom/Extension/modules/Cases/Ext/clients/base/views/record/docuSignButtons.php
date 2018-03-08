<?php

    /*
     * module name
     */
    $moduleUsed = 'Cases';

    /*
     * buttons to append
     */
    $addButtons = array(
        array(
            'type' => 'divider',
        ),
        array(
            'type' => 'rowaction',
            'event' => 'button:send_to_docusign:click',
            'name' => 'send_to_docusign',
            'label' => 'Send Documents To DocuSign',
            'acl_action' => 'view',
        ),
        array(
            'type' => 'divider',
        ),
        array(
            'type' => 'RT_DocuSign_pdfaction',
            'event' => 'button:send_pdf_to_docusign:click',
            'name' => 'send_pdf_to_docusign',
            'label' => 'Send PDF To DocuSign',
            'action' => 'send_pdf_to_docusign',
            'acl_action' => 'view',
        )
    );

    /*
     * if the buttons are missing in our base modules metadata, include core buttons
     */
    if (!isset($viewdefs[$moduleUsed]['base']['view']['record']['buttons'])) {
        require('clients/base/views/record/record.php');
        $viewdefs[$moduleUsed]['base']['view']['record']['buttons'] = $viewdefs['base']['view']['record']['buttons'];
        unset($viewdefs['base']);
    }

    foreach ($viewdefs[$moduleUsed]['base']['view']['record']['buttons'] as $outerKey => $outerButton) {
        if (isset($outerButton['type']) && $outerButton['type'] == 'actiondropdown' && isset($outerButton['name']) && $outerButton['name'] == 'main_dropdown' && isset($outerButton['buttons'])) {
            /*
             * appending buttons
             */
            foreach ($addButtons as $addButton) {
                $viewdefs[$moduleUsed]['base']['view']['record']['buttons'][$outerKey]['buttons'][] = $addButton;
            }
        }
    }
?>