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

namespace Sugarcrm\IdentityProvider\Authentication\UserProvider;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Sugarcrm\IdentityProvider\Authentication\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserProvider.
 * Class to load user entity from local database.
 */
class LocalUserProvider implements UserProviderInterface
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * UserProvider constructor.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $row = $this->getUserData($username);
        if (!$row) {
            throw new UsernameNotFoundException();
        }

        return new User($row['username'], $row['password']);
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!($user instanceof User)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $userData = $this->getUserData($user->getUsername());

        return new User($userData['username'], $userData['password']);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }

    /**
     * Returns user attributes from database.
     *
     * @param string $username
     * @return array|null
     */
    protected function getUserData($username)
    {
        $qb = new QueryBuilder($this->db);
        $qb
            ->select('*')
            ->from('users')
            ->where('username = ?')
            ->andWhere('deleted = 0')
            ->setMaxResults(1)
            ->setParameters([
                (string) $username
            ])
        ;

        $row = $qb->execute()->fetch(\PDO::FETCH_ASSOC);

        return !empty($row) ? $row : null;
    }
}
