<?php

class CustomModuleBuilderController extends ModuleBuilderController
{
	/*
		NOTE: This is copied directly from the 7.9.0.1 function
		from the stock controller. We have only changed it to 
		use the ParserFactory for loading the SidecarFilterLayoutMetaDataParser.

		Our changes are commented. 
	 */
	public function action_searchViewSave()
	{
	    $packageName = $this->request->getValidInputRequest('view_package', 'Assert\ComponentName');

	    // Bug 56789 - Set the client from the view to ensure the proper viewdef file
	    $client = MetaDataFiles::getClientByView($_REQUEST['view']);
	    if (isModuleBWC($_REQUEST['view_module'])) {
	        $parser = new SearchViewMetaDataParser($_REQUEST ['view'], $_REQUEST ['view_module'], $packageName, $client);
	    } else {
	        $client = empty($client) ? 'base' : $client;
			$parser = ParserFactory::getParser($_REQUEST ['view'], $_REQUEST ['view_module'], $packagename, null, $client);
			if (! $parser instanceof SidecarFilterLayoutMetaDataParser) {
			    $GLOBALS['log']->fatal('ParserFactory picked an unexpected Parser, reverting to default. This means that the alphabetization customization will probably be skipped');
			    $parser = new SidecarFilterLayoutMetaDataParser($_REQUEST ['view_module'], $packageName, $client);
			}
	    }
	    $parser->handleSave();

	    //Repair or create a custom SearchFields.php file as needed
	    $module_name = $this->request->getValidInputRequest('view_module', 'Assert\ComponentName');
	    global $beanList;
	    if (isset($beanList[$module_name]) && $beanList[$module_name] != "") {
	        $objectName = BeanFactory::getObjectName($module_name);

	        //Load the vardefs for the module to pass to TemplateRange
	        VardefManager::loadVardef($module_name, $objectName, true);
	        global $dictionary;
	        $vardefs = $dictionary[$objectName]['fields'];
	        TemplateRange::repairCustomSearchFields($vardefs, $module_name, $packageName);
	    }
	    $this->view = 'searchView';
	}
}