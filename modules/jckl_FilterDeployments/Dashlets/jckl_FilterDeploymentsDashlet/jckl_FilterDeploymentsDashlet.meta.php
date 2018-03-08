<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
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
 
global $app_strings;

$dashletMeta['jckl_FilterDeploymentsDashlet'] = array('module'		=> 'jckl_FilterDeployments',
										  'title'       => translate('LBL_HOMEPAGE_TITLE', 'jckl_FilterDeployments'), 
                                          'description' => 'A customizable view into jckl_FilterDeployments',
                                          'icon'        => 'icon_jckl_FilterDeployments_32.gif',
                                          'category'    => 'Module Views');