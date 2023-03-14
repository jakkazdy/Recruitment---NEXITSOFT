<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddCandidates extends Migration
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
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'dob' => [
                'type'       => 'DATE'
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'education' => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'attachment_ml' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'attachment_cv' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'attachment_other_status' => [
                'type'       => 'tinyint',
                'constraint' => '1',
                'default'    => 0,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('candidates');
    }

    public function down()
    {
        $this->forge->dropTable('candidates');
    }
}
