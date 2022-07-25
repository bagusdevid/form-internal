<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyOrders extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('orders', [
            'tanggal' => [
                'name' => 'tanggal',
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', 'tanggal');
    }
}
