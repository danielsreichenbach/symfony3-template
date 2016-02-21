<?php

namespace Acme\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Creates the necessary tables to keep track of entity changes.
 */
class Version20151129102147 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $logEntryTable = $schema->createTable('ext_log_entries');

        $logEntryTable->addColumn('id', 'integer', ['notnull' => true, 'autoincrement' => true]);
        $logEntryTable->addColumn('action', 'string', ['length' => 8, 'notnull' => true]);
        $logEntryTable->addColumn('logged_at', 'datetime', ['notnull' => true]);
        $logEntryTable->addColumn('object_id', 'string', ['length' => 64, 'notnull' => false]);
        $logEntryTable->addColumn('object_class', 'string', ['length' => 255, 'notnull' => true]);
        $logEntryTable->addColumn('version', 'integer', ['notnull' => true]);
        $logEntryTable->addColumn('data', 'text', ['notnull' => false, 'comment' => '(DC2Type:array)']);
        $logEntryTable->addColumn('username', 'string', ['length' => 255, 'notnull' => false]);

        $logEntryTable->addIndex(['object_class'], 'log_class_lookup_idx');
        $logEntryTable->addIndex(['logged_at'], 'log_date_lookup_idx');
        $logEntryTable->addIndex(['username'], 'log_user_lookup_idx');
        $logEntryTable->addIndex(['object_id', 'object_class', 'version'], 'log_version_lookup_idx');

        $logEntryTable->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('ext_log_entries');
    }
}
