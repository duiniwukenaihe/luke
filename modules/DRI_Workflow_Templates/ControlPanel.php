<?php

namespace DRI_Workflow_Templates;

require_once 'modules/DRI_Workflows/ConnectorHelper.php';
require_once 'modules/DRI_Workflow_Templates/TemplateImporter.php';

use DRI_Workflows\ConnectorHelper;

/**
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
class ControlPanel
{
    /**
     * @param bool $force
     */
    public function importTemplates($force = false)
    {
        $helper = new ConnectorHelper();
        $config = $helper->getConfig();

        if ($force || $config->getTemplateVersion() !== $config->getCurrentVersion()) {
            $importer = new TemplateImporter();
            $importer->importAll();
            $config->setTemplateVersion($config->getCurrentVersion());
        }
    }

    /**
     * @return array
     * @throws \SugarApiExceptionMissingParameter
     * @throws \SugarApiExceptionNotAuthorized
     * @throws \SugarApiExceptionNotFound
     */
    public function resaveAll()
    {
        foreach (\DRI_Workflow_Template::all() as $template) {
            foreach ($template->getStageTemplates() as $stageTemplate) {
                foreach ($stageTemplate->getActivityTemplates() as $activityTemplate) {
                    $activityTemplate->save();
                }

                $stageTemplate->retrieve();
                $stageTemplate->save();
            }

            $template->retrieve();
            $template->save();
        }

        return array ();
    }

    /**
     * @param string $licenseKey
     * @param string $validationKey
     */
    public function validateLicense($licenseKey, $validationKey)
    {
        $helper = new ConnectorHelper();
        $helper->getConfig()->setLicenseKey($licenseKey);
        $helper->getConfig()->setValidationKey($validationKey);
        $helper->checkLicense(true, true);
    }
}
