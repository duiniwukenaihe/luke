<?php

namespace DRI_Workflows;

require_once 'modules/DRI_Workflows/LicenseValidator.php';
require_once 'modules/DRI_Workflows/Config.php';

/**
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
class ConnectorHelper
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var LicenseValidator
     */
    private $validator;

    /**
     * @var array
     */
    private static $licenseChecked = array ();

    /**
     * ConnectorHelper constructor.
     */
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * This method gets called when the before_save, before_retrieve & before_delete
     * and checks that the configured license is valid and that the user has access.
     *
     * A user that does not have access to the plugin can only read
     * retrieve DRI_Workflow records and template records.
     *
     * @param \SugarBean $bean
     * @param string $event
     */
    public function checkLicenseBeanHook(\SugarBean $bean, $event)
    {
        // validate user access if the logic hooks regards to
        // DRI_SubWorkflow or any other action then retrieve.
        $this->checkLicense($bean instanceof \DRI_SubWorkflow || $event !== 'before_retrieve');
    }

    /**
     * Checks the configured license
     *
     * @param bool $checkUser
     * @param bool $force
     *
     * @throws \DRI_Workflows\Exception\InvalidLicenseException
     * @throws \SugarApiException
     */
    public function checkLicense($checkUser = true, $force = false)
    {
        if (true === $force || isset(self::$licenseChecked[(int)$checkUser])) {
            return;
        }

        // If module and action is set in the request we can expect that we are in bwc mode.
        // The license check should be performed here as it may break the application.
        if (isset($_REQUEST['module'], $_REQUEST['action'])) {
            return;
        }

        $this->loadValidator()->validateKey();

        if ($checkUser) {
            $this->loadValidator()->validateCurrentUser();
        }

        self::$licenseChecked[(int)$checkUser] = true;
    }

    /**
     * @return string|null
     */
    public function getLicenseKey()
    {
        return $this->config->getLicenseKey();
    }

    /**
     * @return string|null
     */
    public function getValidationKey()
    {
        return $this->config->getValidationKey();
    }

    /**
     * @return string|null
     */
    public function getCurrentVersion()
    {
        return $this->config->getCurrentVersion();
    }

    /**
     * @return int
     */
    public function getUserLimit()
    {
        return $this->loadValidator()->getUserLimit();
    }

    /**
     * @return int
     */
    public function getCurrentUsers()
    {
        return $this->loadValidator()->getCurrentUsers();
    }

    /**
     * @return \DateTime
     */
    public function getValidUntil()
    {
        return $this->loadValidator()->getValidUntil();
    }

    /**
     * @return LicenseValidator
     */
    private function loadValidator()
    {
        if (null === $this->validator) {
            $this->validator = new LicenseValidator(
                'customer_journey',
                $this->config->getLicenseKey(),
                $this->config->getValidationKey()
            );
        }

        return $this->validator;
    }
}
