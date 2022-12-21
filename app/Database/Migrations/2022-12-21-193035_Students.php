<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Students extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'student_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'student_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'student_street' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'student_number' => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'student_complement' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'student_district' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'student_city' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'student_state' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'student_zipcode' => [
                'type'       => 'VARCHAR',
                'constraint' => '9',
            ],
            'student_country' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'student_picture' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('student_id', true);
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
