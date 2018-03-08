<?PHP
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/

require_once('modules/RT_DocuSign/RT_DocuSign_sugar.php');
class RT_DocuSign extends RT_DocuSign_sugar {

	function RT_DocuSign(){
		self::__construct();
	}
	public function __construct(){
		parent::__construct();
		$this->name = 'RT DocuSign';
	}
}
?>