<?php


namespace App\Database\Seeds;


use CodeIgniter\Database\Seeder;
use Config\Services;

class TodoSeeder extends Seeder  {

    private $validation;

    public function __construct($config, $db = null) {
        parent::__construct($config, $db);

        $this->validation = Services::validation();
    }

    public function run(): void {

        $findAllTestUsersIdQuery = "SELECT id FROM users WHERE username IN ('lbovolini', 'msilva', 'jsouza', 'jjseccisa', 'jmuller') LIMIT 5;";
        $usersIdArray = $this->db->query($findAllTestUsersIdQuery)->getResultArray();
        $todos = [];

        for ($i = 0; $i < count($usersIdArray); $i++) {
            $todos[$i]['users_id'] = $usersIdArray[$i]['id'];
        }

        foreach ($todos as $todo) {
            $this->validation->reset();

            if (!$this->validation->run($todo, 'todo')) {
                print('Validation fails for todo seeder data with id = ' . $todo['id'] . "\n");
                print('errors: ');
                foreach($this->validation->getErrors() as $error) {
                    print("\n\t" . $error);
                }
                print("\n");
            }

            $this->db->table('todos')->ignore(true)->insert($todo);
        }
    }
}