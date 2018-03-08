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

namespace Sugarcrm\IdentityProvider\App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Current migrations creates user's table on 'up' and drop it on 'down'
 */
class Version20160826150001 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE TABLE `users` (
                `id` char(36) NOT NULL,
                `username` varchar(100) NOT NULL,
                `password` varchar(255) NOT NULL,
                `created` datetime NOT NULL,
                `modified` datetime NOT NULL,
                `deleted` tinyint(1) NOT NULL DEFAULT \'0\',
                PRIMARY KEY (`id`),
                UNIQUE KEY `username_UNIQUE` (`username`)
            ) DEFAULT CHARSET=\'utf8\';
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `users`;');
    }
}
