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

namespace Sugarcrm\IdentityProvider\Tests;

/**
 * Helper class to retrieve necessary certificates for tests.
 * Class ConfigHelper
 * @package Sugarcrm\IdentityProvider\Tests
 */
class IDMFixturesHelper
{
    /**
     * Service provider private key.
     *
     * @return string
     */
    public static function getSpPrivateKey()
    {
        return file_get_contents(__DIR__.'/../app/config/certs/travis.key');
    }

    /**
     * Service provider public key.
     *
     * @return string
     */
    public static function getSpPublicKey()
    {
        return file_get_contents(__DIR__.'/../app/config/certs/travis.crt');
    }

    /**
     * Gets x509 key for service.
     *
     * @param string $idp
     * @return string
     */
    public static function getIdpX509Key($idp)
    {
        return file_get_contents(__DIR__.'/Functional/SAML/fixtures/certs/'.$idp.'/x509.crt');
    }

    /**
     * Gets SAML xml request/response from fixtures.
     *
     * @param string $path
     * @return string
     */
    public static function getSAMLFixture($path)
    {
        return file_get_contents(__DIR__.'/Functional/SAML/fixtures/'.$path);
    }

    /**
     * Gets valid ADFS config.
     *
     * @return array
     */
    public static function getADFSParameters()
    {
        return [
            'strict' => false,
            'debug' => false,
            'sp' => [
                'entityId' => 'https://localhost/saml/metadata',
                'assertionConsumerService' => [
                    'url' => 'https://localhost/saml/acs',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_POST,
                ],
                'singleLogoutService' => [
                    'url' => 'https://localhost/saml/logout',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_REDIRECT,
                ],
                'NameIDFormat' => \OneLogin_Saml2_Constants::NAMEID_EMAIL_ADDRESS,
                'x509cert' => static::getSpPublicKey(),
                'privateKey' => static::getSpPrivateKey(),
            ],

            'idp' => [
                'entityId' => 'https://vmstack104.test.com/adfs/services/trust',
                'singleSignOnService' => [
                    'url' => 'https://vmstack104.test.com/adfs/ls',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_REDIRECT,
                ],
                'singleLogoutService' => [
                    'url' => 'https://vmstack104.test.com/adfs/ls',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_REDIRECT,
                ],
                'x509cert' => static::getIdpX509Key('ADFS'),
            ],
            'security' => [
                'lowercaseUrlencoding' => true,
                'authnRequestsSigned' => true,
                'signatureAlgorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
                'logoutRequestSigned' => true,
                'validateRequestId' => true,
            ],
        ];
    }

    /**
     * Gets valid Okta config.
     *
     * @return array
     */
    public static function getOktaParameters()
    {
        return [
            'strict' => false,
            'debug' => false,
            'sp' => [
                'entityId' => 'http://localhost:8000/saml/metadata',
                'assertionConsumerService' => [
                    'url' => 'http://localhost:8000/saml/acs',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_POST,
                ],
                'singleLogoutService' => [
                    'url' => 'http://localhost:8000/saml/logout',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_REDIRECT,
                ],
                'NameIDFormat' => \OneLogin_Saml2_Constants::NAMEID_EMAIL_ADDRESS,
                'x509cert' => static::getSpPublicKey(),
                'privateKey' => static::getSpPrivateKey(),
            ],

            'idp' => [
                'entityId' => 'http://www.okta.com/exk9f6zk3cchXSMkP0h7',
                'singleSignOnService' => [
                    'url' => 'https://dev-432366.oktapreview.com/app/sugarcrmdev432366_sugarcrmidmdev_1/exk9f6zk3cchXSMkP0h7/sso/saml',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_REDIRECT,
                ],
                'singleLogoutService' => [
                    'url' => 'https://dev-432366.oktapreview.com/app/sugarcrmdev432366_sugarcrmidmdev_1/exk9f6zk3cchXSMkP0h7/slo/saml',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_POST,
                ],
                'x509cert' => static::getIdpX509Key('Okta'),
            ],
            'security' => [
                'logoutRequestSigned' => true,
                'wantMessagesSigned' => true,
                'signatureAlgorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
                'validateRequestId' => true,
            ],
        ];
    }
    /**
     * Gets valid OneLogin config.
     *
     * @return array
     */
    public static function getOneLoginParameters()
    {
        return [
            'strict' => false,
            'debug' => false,
            'sp' => [
                'entityId' => 'idpdev',
                'assertionConsumerService' => [
                    'url' => 'http://localhost:8000/saml/acs',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_POST,
                ],
                'singleLogoutService' => [
                    'url' => 'http://localhost:8000/saml/logout',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_REDIRECT,
                ],
                'NameIDFormat' => \OneLogin_Saml2_Constants::NAMEID_EMAIL_ADDRESS,
                'x509cert' => static::getSpPublicKey(),
                'privateKey' => static::getSpPrivateKey(),
            ],

            'idp' => [
                'entityId' => 'https://app.onelogin.com/saml/metadata/622315',
                'singleSignOnService' => [
                    'url' => 'https://sugarcrm-idmeloper-dev.onelogin.com/trust/saml2/http-post/sso/622315',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_REDIRECT,
                ],
                'singleLogoutService' => [
                    'url' => 'https://sugarcrm-idmeloper-dev.onelogin.com/trust/saml2/http-redirect/slo/622315',
                    'binding' => \OneLogin_Saml2_Constants::BINDING_HTTP_REDIRECT,
                ],
                'x509cert' => static::getIdpX509Key('OneLogin'),
            ],
            'security' => [
                'validateRequestId' => true,
            ],
        ];
    }
}
