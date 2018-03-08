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

namespace Sugarcrm\IdentityProvider\Tests\Functional\SAML;

use Sugarcrm\IdentityProvider\Authentication\Provider\SAMLAuthenticationProvider;
use Sugarcrm\IdentityProvider\Authentication\Token\SAML\InitiateToken;
use Sugarcrm\IdentityProvider\Authentication\UserProvider\SAMLUserProvider;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sugarcrm\IdentityProvider\App\Authentication\UserMappingService;
use Sugarcrm\IdentityProvider\Authentication\User\SAMLUserChecker;

class SignedRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testSignedRequest()
    {
        /** @var Session | \PHPUnit_Framework_MockObject_MockObject $session */
        $session = $this->createMock(SessionInterface::class);
        $mapper = new UserMappingService([]);
        $token = new InitiateToken();
        require_once __DIR__ . '/fixtures/OneLogin/SignedRequest/config-signed.php';
        $samlProvider = new SAMLAuthenticationProvider(
            $params,
            new SAMLUserProvider(),
            new SAMLUserChecker(),
            $session,
            $mapper
            );
        $token = $samlProvider->authenticate($token);
        $this->assertTrue($token->hasAttribute('url'));
        parse_str(parse_url($token->getAttribute('url'), PHP_URL_QUERY), $parameters);
        $this->assertArrayHasKey('SigAlg', $parameters);
        $this->assertEquals($params['security']['signatureAlgorithm'], $parameters['SigAlg']);
        $this->assertArrayHasKey('Signature', $parameters);
    }

    public function testUnsignedRequest()
    {
        /** @var Session | \PHPUnit_Framework_MockObject_MockObject $session */
        $session = $this->createMock(SessionInterface::class);
        $mapper = new UserMappingService([]);
        $token = new InitiateToken();
        $token->setAttribute('idp', 'okta');
        require_once __DIR__ . '/fixtures/OneLogin/SignedRequest/config-unsigned.php';
        $samlProvider = new SAMLAuthenticationProvider(
            $params,
            new SAMLUserProvider(),
            new SAMLUserChecker(),
            $session,
            $mapper
        );
        $token = $samlProvider->authenticate($token);
        $this->assertTrue($token->hasAttribute('url'));
        parse_str(parse_url($token->getAttribute('url'), PHP_URL_QUERY), $parameters);
        $this->assertArrayNotHasKey('SigAlg', $parameters);
        $this->assertArrayNotHasKey('Signature', $parameters);
    }
}
