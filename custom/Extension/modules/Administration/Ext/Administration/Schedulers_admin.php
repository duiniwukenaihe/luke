<?php
$admin_option_defs = array();
$admin_option_defs['Administration']['gsync_configure_users'] = array('rt_GSync', 'LBL_GSYNC_CONFIGURE_USERS_TITLE', 'LBL_GSYNC_CONFIGURE_USERS', 'javascript:parent.SUGAR.App.router.navigate("#rt_GSync/layout/userconfiguration", {trigger: true});');
$admin_group_header[] = array('LBL_GMAILLICENSEADDON', '', false, $admin_option_defs, '');
