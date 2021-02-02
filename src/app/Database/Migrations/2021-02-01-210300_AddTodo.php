<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Todo extends Migration
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
			'users_id' => [
				'type' => 'BIGINT',
				'constraint' => 20,
				'unsigned' => TRUE
			]
		]);

		$this->forge->addPrimaryKey('id');
		$this->forge->addForeignKey('users_id', 'users', 'id');

		$this->forge->createTable('todos');
	}

	public function down()
	{
		$this->forge->dropTable('todos');
	}
}
