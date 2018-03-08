<?php

require_once 'include/api/SugarApi.php';

/**
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
class DRICustomerJourneyControlPanelApi extends SugarApi
{
    /**
     * @return array
     */
    public function registerApiRest() {
        return array(
            'importTemplates' => array(
                'reqType' => 'POST',
                'path' => array('DRI_Workflow_Templates', 'import-templates'),
                'pathVars' => array('', ''),
                'method' => 'importTemplates',
                'shortHelp' => '',
                'longHelp' => '',
                'noEtag' => true,
            ),
            'resaveAll' => array(
                'reqType' => 'POST',
                'path' => array('DRI_Workflow_Templates', 'resave-all'),
                'pathVars' => array('', ''),
                'method' => 'resaveAll',
                'shortHelp' => '',
                'longHelp' => '',
                'noEtag' => true,
            ),
        );
    }

    /**
     * @param ServiceBase $api
     * @param array       $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     */
    public function importTemplates(ServiceBase $api, array $args)
    {
        $panel = new \DRI_Workflow_Templates\ControlPanel();
        $panel->importTemplates(true);
        return array ();
    }

    /**
     * @param ServiceBase $api
     * @param array       $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     */
    public function resaveAll(ServiceBase $api, array $args)
    {
        $panel = new \DRI_Workflow_Templates\ControlPanel();
        $panel->resaveAll();
        return array ();
    }
}
