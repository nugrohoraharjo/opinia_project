<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => true
            ],
            'fullname' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'unique'     => true,
                'constraint' => 255
            ],
            'email' => [
                'type' => 'VARCHAR',
                'unique'     => true,
                'constraint' => 255
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ]
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
    }
}
