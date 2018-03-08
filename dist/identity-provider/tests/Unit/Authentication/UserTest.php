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

namespace Sugarcrm\IdentityProvider\Tests\Unit\Authentication;

use Sugarcrm\IdentityProvider\Authentication\User;

/**
 * Class UserTest.
 * The source of this test is:
 * @see Symfony\Component\Security\Core\Tests\User\UserTest
 *
 * @coversDefaultClass Sugarcrm\IdentityProvider\Authentication\User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = new User('user1', 'user1password');
    }

    /**
     * The username can be empty.
     */
    public function testConstructor()
    {
        new User('', '');
    }

    /**
     * Test user roles by default.
     */
    public function testGetRoles()
    {
        $this->assertNotEmpty($this->user->getRoles());
    }

    /**
     * Test default user roles.
     */
    public function testGetDefaultRoles()
    {
        $this->assertNotEmpty(User::getDefaultRoles());
    }

    public function testGetPassword()
    {
        $this->assertEquals('user1password', $this->user->getPassword());
    }

    public function testGetUsername()
    {
        $this->assertEquals('user1', $this->user->getUsername());
    }

    public function testGetSalt()
    {
        $this->assertEquals('', $this->user->getSalt());
    }

    public function testEraseCredentials()
    {
        $this->user->eraseCredentials();
        $this->assertEmpty($this->user->getPassword());
    }

    public function testToString()
    {
        $this->assertEquals('user1', (string) $this->user);
    }

    public function testAttributes()
    {
        $user = new User('user1', 'user1password', ['attr1' => 1, 'attr2' => 2]);

        $this->assertNotEmpty($user->getAttributes());
        $this->assertNotEmpty($user->getAttribute('attr1'));
        $this->assertTrue($user->hasAttribute('attr2'));

        $user->setAttribute('attr2', 22);
        $this->assertEquals(22, $user->getAttribute('attr2'));

        $user->removeAttribute('attr2');
        $this->assertFalse($user->hasAttribute('attr2'));
    }

    /**
     * @covers ::isAccountNonExpired
     */
    public function testIsAccountNonExpired()
    {
        $this->assertTrue($this->user->isAccountNonExpired());
    }

    /**
     * @covers ::isAccountNonLocked
     */
    public function testIsAccountNonLocked()
    {
        $this->assertTrue($this->user->isAccountNonLocked());
    }

    /**
     * @covers ::isCredentialsNonExpired
     */
    public function testIsCredentialsNonExpired()
    {
        $this->assertTrue($this->user->isCredentialsNonExpired());
    }

    /**
     * @covers ::isEnabled
     */
    public function testIsEnabled()
    {
        $this->assertTrue($this->user->isEnabled());
    }
}
