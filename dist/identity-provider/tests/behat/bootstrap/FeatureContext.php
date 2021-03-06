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

namespace Sugarcrm\IdentityProvider\IntegrationTests\Bootstrap;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Tester\Exception\PendingException;
use GuzzleHttp;
use Behat\Gherkin\Node\TableNode;
use Psr\Http\Message\ResponseInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @var array
     */
    protected $sugarAdmin;

    /**
     * SetUp necessary configs.
     *
     * @param array $sugarAdmin
     */
    public function __construct(array $sugarAdmin)
    {
        $this->sugarAdmin = $sugarAdmin;
    }

    /**
     * Follows to admin page
     *
     * @And I go to administration
     * @When I go to administration
     */
    public function iGoToAdministration()
    {
        $this->waitForThePageToBeLoaded();
        $this->iClick('#userList');
        $this->iClick('.administration');
        $this->iWaitUntilTheLoadingIsCompleted();
        $this->waitForThePageToBeLoaded();
        $this->switchBwc();
    }

    /**
     * Provides user login operation.
     *
     * @param $username
     * @param $password
     *
     * @And /^I login as "([^"]*)" with password "([^"]*)"$/
     * @When /^I login as "([^"]*)" with password "([^"]*)"$/
     */
    public function iLogin($username, $password)
    {
        $this->waitForThePageToBeLoaded();
        $this->iWaitUntilTheLoadingIsCompleted();
        $page = $this->getSession()->getPage();
        $switchForm = $page->find('css', 'a[name=login_form_button]');
        if (!is_null($switchForm)) {
            $this->iClick("a[name=login_form_button]");
        }
        $page->fillField('username', $username);
        $page->fillField('password', $password);
        $page->pressButton('login_button');
        $this->iWaitUntilTheLoadingIsCompleted();
        $this->waitForThePageToBeLoaded();
    }

    /**
     * Provides user logout operation.
     *
     * @Then I logout
     * @And I logout
     */
    public function iLogout()
    {
        $this->waitForThePageToBeLoaded();
        $this->switchSidecar();
        $this->waitForThePageToBeLoaded();
        $this->iClick('#userList');
        $this->iClick('.profileactions-logout');
        $this->iWaitUntilTheLoadingIsCompleted();
        $this->waitForThePageToBeLoaded();
    }

    /**
     * Click on element found by css selector.
     * @When /^I click "([^"]*)"$/
     * Example: I click "ul.megamenu li button"
     */
    public function iClick($selector)
    {
        $element = $this->getSession()->getPage()->find('css', $selector);
        if (is_null($element)) {
            throw new \RuntimeException("Not found element by selector($selector)");
        }
        $element->click();
    }

    /**
     * Wait until the loading is completed
     * @When /^I wait until the loading is completed$/
     */
    public function iWaitUntilTheLoadingIsCompleted()
    {
        $condition = '!document.querySelector(".alert-wrapper .alert-process .loading") '
            . '&& !document.querySelector("span[sfuuid]:empty:not([class])");';
        $this->getSession()->wait(20000, $condition);
    }

    /**
     * Before working with BWC Iframe need this command.
     * @When /^I switch to BWC$/
     */
    public function switchBwc()
    {
        $this->spin(function (FeatureContext $context) {
            $context->getSession()->getDriver()->switchToIFrame('bwc-frame');
            return boolval($context->getSession()->getPage()->findById('main'));
        }, 20);
    }

    /**
     * Output from bwc.
     * @When /^I switch to sidecar$/
     */
    public function switchSidecar()
    {
        $this->getSession()->getDriver()->switchToIFrame(null);
    }

    /**
     * Wait :milliseconds.
     * @When I wait :milliseconds
     */
    public function wait($milliseconds)
    {
        $this->getSession()->wait($milliseconds);
    }

    /**
     * Wait for the page to be redirected to the specific url
     * @Then /^I should be redirected to "?([^"]*)"?$/
     * @And /^I should be redirected to "?([^"]*)"?$/
     * Example: I should be redirected to "http://localhost:8000"
     *          I should be redirected to saml-server
     */
    public function iShouldBeRedirectedTo($redirectedTo)
    {
        $redirectedTo = $this->getContextSpecificUrl($redirectedTo);
        $this->spin(function (FeatureContext $context) use ($redirectedTo) {
            $diff = $result = array_diff(
                parse_url($redirectedTo),
                parse_url($context->getSession()->getCurrentUrl())
            );
            return empty($diff);
        }, 10);
    }

    /**
     * @param string $url
     * @return string
     */
    protected function getContextSpecificUrl($url)
    {
        return $url;
    }

    /**
     * Wait for the page to be loaded.
     * @And I wait for the page to be loaded
     * @When I wait for the page to be loaded
     */
    public function waitForThePageToBeLoaded()
    {
        $this->getSession()->wait(10000, "document.readyState === 'complete'");
    }

    /**
     * Checking radiobutton.
     * @When /^I check the "([^"]*)" radio button with "([^"]*)" value$/
     * @And /^I check the "([^"]*)" radio button with "([^"]*)" value$/
     * Example: I check the "radioName" radio button with "radioValue" value
     */
    public function iCheckTheRadioButtonWithValue($element, $value)
    {
        $element = $this->fixStepArgument($element);
        $value = $this->fixStepArgument($value);
        $selector = 'input[type="radio"][name="' . $element . '"]';
        foreach ($this->getSession()->getPage()->findAll('css', $selector) as $radio) {
            if ($radio->getAttribute('value') == $value) {
                $radio->check();
                return true;
            }
        }
        return false;
    }

    /**
     * @Then I skip login wizard
     * @And I skip login wizard
     */
    public function iSkipLoginWizard()
    {
        $this->iWaitUntilTheLoadingIsCompleted();
        sleep(5);
        $accessToken = $this->getAccessToken();
        if ($accessToken) {
            $client = new GuzzleHttp\Client();
            $response = $client->get(
                $this->getMinkParameter('base_url') . '/rest/v10/me/preferences',
                ['headers' => ['OAuth-Token' => $accessToken]]
            );

            $userPreferences = json_decode($response->getBody(true));
            $wizard = !(isset($userPreferences->ut) && $userPreferences->ut);
            if ($wizard) {
                $client->put(
                    $this->getMinkParameter('base_url') . '/rest/v10/me/preferences',
                    [
                        'headers' => ['OAuth-Token' => $accessToken],
                        'body' => '{"ut":1}',
                    ]
                );
                $this->getSession()->reload();
                sleep(5);
                $this->waitForThePageToBeLoaded();
                $this->iWaitUntilTheLoadingIsCompleted();
                $this->waitForElement('#userList');
            }
        }
    }

    /**
     * Creates Sugar user with a specified set of bean properties.
     *
     * @Then /^As "([^"]*)" I create Sugar user with the following properties:$/
     * @And /^As "([^"]*)" I create Sugar user with the following properties:$/
     */
    public function iCreateUser($adminKey, TableNode $table)
    {
        $credentials = $this->$adminKey;
        if (empty($credentials)) {
            throw new \RuntimeException('Configuration for ' . $adminKey . ' not found');
        }

        $this->iLogin($credentials['username'], $credentials['password']);
        $this->iSkipLoginWizard();

        $body = [];
        foreach ($table->getHash() as $row) {
            $body[$row['field']] = $row['value'];
        }

        $accessToken = $this->getAccessToken();
        $usersUrl = rtrim($this->getMinkParameter('base_url'), '/') . '/rest/v10/Users';
        $client = new GuzzleHttp\Client();
        /** @var ResponseInterface $response */
        $response = $client->post(
            $usersUrl,
            [
                'headers' => ['OAuth-Token' => $accessToken],
                'body' => json_encode($body),
            ]
        );
        $body = $response->getBody();
        $list = json_decode((string)$body, true);

        $this->iLogout();

        return $list['id'];
    }

    /**
     * Get access token from localStorage
     *
     * @return string
     */
    public function getAccessToken()
    {
        $accessToken = '';
        try {
            $accessToken = $this->getLocalStorageItem('prod:SugarCRM:AuthAccessToken');
        } catch (\Exception $e) {
        }
        return $accessToken;
    }

    /**
     * Get local storage item value
     *
     * @param string $key
     *
     * @return string
     */
    protected function getLocalStorageItem($key)
    {
        $value = $this->getSession()->getDriver()->evaluateScript("localStorage.getItem('$key')");
        $decodedValue = json_decode($value);
        return $decodedValue ?: $value;
    }

    /**
     * Wait until element is appear on the page
     * @When /^I wait for element "([^"]*)"$/
     * @And /^I wait for element "([^"]*)"$/
     * Example: I wait for element "ul.megamenu li button"
     */
    public function waitForElement($css)
    {
        $css = $this->fixStepArgument($css);
        $this->spin(function (FeatureContext $context) use ($css) {
            $element = $context->getSession()->getPage()->find('css', $css);
            return !is_null($element);
        }, 20);
    }

    /**
     * Spin wrapper for long test.
     * @param \Closure $lambda will call until not return true or time out
     * @param int $wait
     * @return bool
     * @throws \Exception
     */
    public function spin(\Closure $lambda, $wait = 60)
    {
        for ($i = 0; $i < $wait; $i++) {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (\Exception $e) {
                // do nothing
            }
            sleep(1);
        }

        $backtrace = debug_backtrace();

        throw new \Exception(
            "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n" .
            $backtrace[1]['file'] . ", line " . $backtrace[1]['line']
        );
    }

    /**
     * Mark scenario as pending.
     *
     * @Given /Mark scenario as pending (?:because|since|see)*(.*)$/
     * Example: Mark scenario as pending because it will be addressed in ticket NNN
     */
    public function iWantToMarkScenarioAsPending($reason)
    {
        $message = 'Scenario is pending.';
        if ($reason) {
            $message .= ' Reason: ' . trim($reason);
        }
        throw new PendingException($message);
    }

    /**
     * Clears local storage and cookies.
     */
    public function clearLocalData()
    {
        $this->getSession()->executeScript('localStorage.clear()');
        $this->getSession()->setCookie('PHPSESSID', null);
    }
}
