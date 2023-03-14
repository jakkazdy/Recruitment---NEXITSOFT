<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInternship extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_candidate' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
            ],
            'name_brand' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'date_start' => [
                'type'       => 'DATE',
            ],
            'date_end' => [
                'type'       => 'DATE',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('internships');
    }

    public function down()
    {
        $this->forge->dropTable('internships');
    }
}
