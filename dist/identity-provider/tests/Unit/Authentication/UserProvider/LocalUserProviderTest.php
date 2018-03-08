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

namespace Sugarcrm\IdentityProvider\Tests\Unit\Authentication\UserProvider;

use PHPUnit_Framework_TestCase;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Authentication\UserProvider\LocalUserProvider;

/**
 * Class LocalUserProviderTest.
 */
class LocalUserProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $testUserName = 'user1';

    /**
     * @var string
     */
    protected $testPassword = 'passwordnohash';

    public function testLoadUserByUsernameUserExists()
    {
        $userProvider = $this->getUserProvider();
        $user = $userProvider->loadUserByUsername($this->testUserName);
        $this->assertEquals($this->testUserName, $user->getUsername());
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function testLoadUserByUsernameUserDoesntExist()
    {
        $userProvider = $this->getUserProvider(null);
        $userProvider->loadUserByUsername('unknown_user_name');
    }

    public function testRefreshUser()
    {
        $userProvider = $this->getUserProvider();
        $user = new User($this->testUserName, $this->testPassword . 'suffix');
        $user = $userProvider->refreshUser($user);
        $this->assertEquals($this->testPassword, $user->getPassword());
    }

    /**
     * @param array|null $data Creates UserProvider object which returns predefined data
     *                         that can be overwritten by $data param.
     *                         UserProvider will return null if $data is not array.
     * @return LocalUserProvider
     */
    protected function getUserProvider($data = [])
    {
        $userProvider = $this->getMockBuilder(LocalUserProvider::class)
            ->disableOriginalConstructor()
            ->setMethods(['getUserData'])
            ->getMock()
        ;

        if (is_array($data)) {
            $rowData = array_merge([
                'id' => '12345678-9012-3456-7890-123456789012',
                'username' => $this->testUserName,
                'password' => $this->testPassword,
                'deleted' => 0,
                'client_id' => 'test',
                'created' => '',
                'modified' => '',
            ], $data);

        } else {
            $rowData = null;
        }

        $userProvider->method('getUserData')
            ->willReturn($rowData);

        return $userProvider;
    }
}
