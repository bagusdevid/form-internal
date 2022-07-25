<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'tanggal' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'klasifikasi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'client_status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'client_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'reference' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ], // Nama pengorder
            'social_media_order' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'social_media_account' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'postdate' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'post_qty' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
                'default' => 0
            ],
            'cost' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
                'default' => 0
            ],
            'other_brief' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
