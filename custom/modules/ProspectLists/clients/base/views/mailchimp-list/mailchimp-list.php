<?php
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

$viewdefs['ProspectLists']['base']['view']['mailchimp-list'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_MAILCHIMP_LIST',
            'description' => 'LBL_MAILCHIMP_LIST_DESCRIPTION',
            'config' => array(
            ),
            'preview' => array(
            ),
            'filter' => array(
                'module' => array(
                    'ProspectLists',
                ),
                'view' => array(
                    'record',
                ),
            ),
        ),
    ),
);
