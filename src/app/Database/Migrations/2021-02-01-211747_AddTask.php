<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Task extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'BIGINT',
				'constraint' => 20,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
                'null' => FALSE
			],
			'description' => [
				'type' => 'VARCHAR',
				'constraint' => 2550,
                'null' => FALSE
			],
			'date' => [
				'type' => 'DATE',
				'null' => FALSE
			],
			'todos_id' => [
				'type' => 'BIGINT',
				'constraint' => 20,
				'unsigned' => TRUE
			]
		]);

		$this->forge->addPrimaryKey('id');
		$this->forge->addForeignKey('todos_id', 'todos', 'id');

		$this->forge->createTable('tasks');
	}

	public function down()
	{
		$this->forge->dropTable('tasks');
	}
}
