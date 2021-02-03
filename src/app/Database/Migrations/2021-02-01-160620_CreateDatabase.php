<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDatabase extends Migration
{
	public function up()
	{
		$this->forge->createDatabase('todo', TRUE);
	}

	public function down()
	{
		$this->forge->dropDatabase('todo');
	}
}
