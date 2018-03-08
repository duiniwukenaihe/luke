<?php


    global $sugar_version, $admin_group_header;

    if (!is_array($jckl_options_defs)) {
        $jckl_options_defs=array();
    }

    $jckl_options_defs['Administration']['jackal_Filter_license']= array('helpInline','LBL_JCKL_FILTER_LICENSEADDON_LICENSE_TITLE','LBL_JCKL_FILTER_LICENSEADDON_LICENSE','javascript:parent.SUGAR.App.router.navigate("#bwc/index.php?module=jckl_FilterTemplates&action=license", {trigger: true});');

    $jckl_options_defs['Administration']['jackal_Filter_link']=array(
        'Administration',
        'LBL_JACKAL_FILTER_TITLE',
        'LBL_JACKAL_FILTER_DESCRIPTION',
        'javascript:parent.SUGAR.App.router.navigate("#jckl_FilterTemplates", {trigger: true})'
    );
    $admin_group_header['jackal_software']=array(
        'LBL_JACKAL_DASHBOARD_MANAGER_GROUP_TITLE',
        '',
        'false',
        $jckl_options_defs,
        'LBL_JACKAL_DASHBOARD_MANAGER_GROUP_DESCRIPTION',
    );