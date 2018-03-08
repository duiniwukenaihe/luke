<?php
    /**
     * Created using PhpStorm.
     * User: shad
     * Date: 5/18/17
     * Time: 4:06 PM
     * File Name: ${FILE_PATH} subpanels.php
     * Project: sugarclass
     */


    $viewdefs['jckl_FilterTemplates']['base']['layout']['subpanels']['components'][] = array (
        'layout' => 'subpanel',
        'label' => 'LBL_JCKL_FILTERTEMPLATES_JCKL_FILTERSELECTIONS_FROM_JCKL_FILTERSELECTIONS_TITLE',
        'context' =>
            array (
                'link' => 'jckl_filtertemplates_jckl_filterselections',
            ),
    );

    $viewdefs['jckl_FilterTemplates']['base']['layout']['subpanels']['components'][] = array (
        'layout' => 'subpanel',
        'label' => 'LBL_JCKL_FILTERTEMPLATES_JCKL_FILTERDEPLOYMENTS_FROM_JCKL_FILTERDEPLOYMENTS_TITLE',
        'context' =>
            array (
                'link' => 'jckl_filtertemplates_jckl_filterdeployments',
            ),
    );