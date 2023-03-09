<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Users extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('squad21_user', ['id' => false, 'primary_key' => 'uuid'])
            ->addColumn('uuid', 'string', ['limit' => 36, 'null' => false])
            ->addColumn('status', 'boolean', ['default' => 1])

            ->addColumn('name', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('username', 'string', ['limit' => 25, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 60, 'null' => false])
            ->addColumn('bio', 'text')
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 4])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('verify_token', 'string', ['limit' => 30])
            ->addColumn('verify_timestamp', 'timestamp')

            ->addIndex('username', ['unique' => true])
            ->addIndex('email', ['unique' => true])

            ->addTimestamps()->create();
    }
}
