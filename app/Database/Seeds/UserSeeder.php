<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Config\Services;

class UserSeeder extends Seeder {

    private $validation;

    public function __construct($config, $db = null) {
        parent::__construct($config, $db);

        $this->validation = Services::validation();
    }

    public function run(): void {

        $users = [
            0 => [
                'first_name' => 'Lucas', 
                'last_name' => 'Bovolini', 
                'email' => 'lbovolini94@gmail.com',
                'username' => 'lbovolini',
                'password' => password_hash('pass11word', PASSWORD_DEFAULT),
                'birthday' => '1994/07/18'
            ],
            1 => [
                'first_name' => 'Maria', 
                'last_name' => 'da Silva', 
                'email' => 'maria@gmail.com',
                'username' => 'msilva',
                'password' => password_hash('pass11word', PASSWORD_DEFAULT),
                'birthday' => '2000/03/21'
            ],
            2 => [
                'first_name' => 'João', 
                'last_name' => 'Souza', 
                'email' => 'jsouza@gmail.com',
                'username' => 'jsouza',
                'password' => password_hash('pass11word', PASSWORD_DEFAULT),
                'birthday' => '1997/11/05'
            ],
            3 => [
                'first_name' => 'Jéssica', 
                'last_name' => 'Friedrich', 
                'email' => 'jjessica@hotmail.com',
                'username' => 'jjseccisa',
                'password' => password_hash('pass11word', PASSWORD_DEFAULT),
                'birthday' => '2005/01/14'
            ],
            4 => [
                'first_name' => 'Jhon', 
                'last_name' => 'Smithʼs Müller', 
                'email' => 'jmuller@gmail.com',
                'username' => 'jmuller',
                'password' => password_hash('pass11word', PASSWORD_DEFAULT),
                'birthday' => '1990/02/19'
            ]
        ];

        foreach($users as $user) {
            $this->validation->reset();

            if (!$this->validation->run($user, 'user')) {
                //throw new \RuntimeException("Error validating user seeder data");
                print('Validation fails for user seeder data with username = ' . $user['username'] . "\n");
                print('errors: ');
                foreach($this->validation->getErrors() as $error) {
                    print("\n\t" . $error);
                }
                print("\n");
            }

            $this->db->table('users')->ignore(true)->insert($user);
        }

    }
}