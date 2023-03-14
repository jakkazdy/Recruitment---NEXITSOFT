<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAttachment extends Migration
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
            'name_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('attachments');
    }

    public function down()
    {
        $this->forge->dropTable('attachments');
    }
}
