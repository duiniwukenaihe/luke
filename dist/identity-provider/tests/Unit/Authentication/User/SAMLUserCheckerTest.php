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

namespace Sugarcrm\IdentityProvider\Tests\Unit\Authentication\User;

use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Authentication\User\SAMLUserChecker;
use Sugarcrm\IdentityProvider\Authentication\Exception\InvalidIdentifier\EmptyFieldException;
use Sugarcrm\IdentityProvider\Authentication\Exception\InvalidIdentifier\EmptyIdentifierException;
use Sugarcrm\IdentityProvider\Authentication\Exception\InvalidIdentifier\IdentifierInvalidFormatException;

/**
 * @coversDefaultClass Sugarcrm\IdentityProvider\Authentication\User\SAMLUserChecker
 */
class SAMLUserCheckerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var User
     */
    protected $user;

    /**
     * @var SAMLUserChecker
     */
    protected $userChecker;

    /**
     * Data provider for testValidIdentifier
     * @see testValidIdentifier
     * @return array
     */
    public function validIdentifierProvider()
    {
        return [
            'emptyField' => [
                'expectedException' => EmptyFieldException::class,
                'field' => '',
                'value' => '',
            ],
            'emptyValue' => [
                'expectedException' => EmptyIdentifierException::class,
                'field' => 'someField',
                'value' => '',
            ],
            'invalidEmailFormat' => [
                'expectedException' => IdentifierInvalidFormatException::class,
                'field' => 'email',
                'value' => 'invalidEmail',
            ],
        ];
    }

    /**
     * @dataProvider validIdentifierProvider
     * @covers ::checkPostAuth
     * @param $expectedException
     * @param $field
     * @param $value
     */
    public function testValidIdentifier($expectedException, $field, $value)
    {
        $this->user->method('getAttribute')->willReturnMap([
            ['identityField', $field],
            ['identityValue', $value],
        ]);

        $this->expectException($expectedException);

        $this->userChecker->checkPostAuth($this->user);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->createMock(User::class);
        $this->userChecker = new SAMLUserChecker();
    }
}
