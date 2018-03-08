<?php

require_once 'include/SugarLogger/SugarLogger.php';

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/*********************************************************************************
 * $Id$
 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

/**
 * MailChimpLogger Logger
 */
class MailChimpLogger extends SugarLogger {

    /**
     * properties for the MailChimpLogger
     */
    protected $logfile = 'mailchimp';
    protected $ext = '.log';
    protected $dateFormat = '%c';
    protected $logSize = '10MB';
    protected $maxLogs = 10;
    protected $filesuffix = "";
    protected $date_suffix = "";
    protected $log_dir = 'custom/include/MailChimp/logs/';

    /**
     * Constructor
     *
     * Reads the config file for logger settings
     */
    public function __construct() {
        $this->_doInitialization();
    }
}
