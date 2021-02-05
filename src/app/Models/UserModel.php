<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    
    protected $table = 'users';

    protected $allowedFields = [
        'first_name', 
        'last_name', 
        'email',
        'username',
        'password',
        'birthday'
    ];

    public function findAndDelete($id): bool {
        // start transaction
        $this->db->transStart();

        $findByIdQuery = "SELECT 1 FROM users WHERE id = '{$id}' LIMIT 1;";
        $deleteQuery = "DELETE FROM users WHERE id = '{$id}';";

        $result = $this->db->query($findByIdQuery);
        $isUserFound = $result->getNumRows() > 0;

        if ($isUserFound) {
            $this->db->query($deleteQuery);
        }

        // end transaction
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \RuntimeException("Error executing delete query in {$this->table} table");
        }

        return $isUserFound;
    }

    public function findAndUpdate($id, $data): bool {
        // start transaction
        $this->db->transStart();

        $findByIdQuery = "SELECT 1 FROM users WHERE id = '{$id}' LIMIT 1;";
        $updateQuery = "UPDATE users " .
            "SET " . 
                "first_name = '{$data->first_name}', " .
                "last_name = '{$data->last_name}', " .
                "email = '{$data->email}', " .
                "username = '{$data->username}', " .
                "password = '{$data->password}', " .
                "birthday = '{$data->birthday}' " .
            "WHERE id = '{$id}';";

        $result = $this->db->query($findByIdQuery);
        $isUserFound = $result->getNumRows() > 0;

        if ($isUserFound) {
            $this->db->query($updateQuery);
        }
        
        // end transaction
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \RuntimeException("Error executing update query in {$this->table} table");
        }

        return $isUserFound;
    }

}