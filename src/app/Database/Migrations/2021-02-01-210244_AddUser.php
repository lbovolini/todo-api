<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
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
			'first_name' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
                'null' => FALSE
			],
			'last_name' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
                'null' => FALSE
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'unique' => TRUE,
				'null' => FALSE
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => 20,
				'unique' => TRUE,
				'null' => FALSE
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
                'null' => FALSE
			],
			'birthday' => [
				'type' => 'DATE',
				'null' => FALSE
			]
		]);

		$this->forge->addPrimaryKey('id');

		$this->forge->createTable('users');
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
