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

    public function findAndDelete(int $id): bool {

        $findByIdQuery = "SELECT 1 FROM {$this->table} WHERE id = :id: LIMIT 1;";

        $deleteQuery = "DELETE FROM {$this->table} WHERE id = :id: LIMIT 1;";

        // start transaction
        $this->db->transStart();

        $result = $this->db->query($findByIdQuery, ['id' => $id]);
        $isUserFound = $result->getNumRows() > 0;

        if ($isUserFound) {
            $this->db->query($deleteQuery, ['id' => $id]);
        }

        // end transaction
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \RuntimeException("Error executing delete query in {$this->table} table");
        }

        return $isUserFound;
    }

    public function findAndUpdate(array $data): bool {

        $findByIdQuery = "SELECT 1 FROM {$this->table} WHERE id = :id: LIMIT 1;";

        $updateQuery = "UPDATE {$this->table} " .
            "SET " . 
                "first_name = :first_name:, " .
                "last_name  = :last_name:, " .
                "email      = :email:, " .
                "username   = :username:, " .
                "password   = :password:, " .
                "birthday   = :birthday: " .
            "WHERE id = :id: LIMIT 1;";

        // start transaction
        $this->db->transStart();

        $result = $this->db->query($findByIdQuery, $data);
        $isUserFound = $result->getNumRows() > 0;

        if ($isUserFound) {
            $this->db->query($updateQuery, $data);
        }
        
        // end transaction
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \RuntimeException("Error executing update query in {$this->table} table");
        }

        return $isUserFound;
    }

}