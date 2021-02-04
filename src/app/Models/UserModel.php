<?php

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

    public function findAndDelete($rawId) {
        // sanitize input data
        $id = static::sanitizeNumber($rawId);
        // start transaction
        $this->db->transStart();

        $findByIdQuery = "SELECT 1 FROM users WHERE id = '{$id}' LIMIT 1;";
        $deleteQuery = "DELETE FROM users WHERE id = '{$id}';";

        $result = $this->db->query($findByIdQuery);
        $isUserFound = $result->getNumRows();

        if ($isUserFound) {
            $this->db->query($deleteQuery);
        }

        // end transaction
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \RuntimeException("Error executing update query in {$this->table} table");
        }

        return $isUserFound;
    }

    public function findAndUpdate($rawId, $rawData): bool {
        // sanitize input data
        $id = static::sanitizeNumber($rawId);
        $data = static::sanitizeAll($rawData);

        // start transaction
        $this->db->transStart();

        $findByIdQuery = "SELECT 1 FROM users WHERE id = '{$id}';";
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
        $isUserFound = $result->getNumRows();

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

    public function insert($rawData = null, $returnID = true) {
        $data = static::sanitizeAll($rawData);

        parent::insert($data, $returnID);
    }


    private static function sanitizeNumber($id) {
        $sanitizedId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if (!$sanitizedId) {
            throw new RuntimeException('Failed to sanitize number');
        }

        return $sanitizedId;
    }

    private static function sanitizeString($string) {
        $sanitizedString = filter_var($string, FILTER_SANITIZE_STRING);

        if (!$sanitizedString) {
            throw new RuntimeException('Failed to sanitize string');
        }

        return $sanitizedString;
    }

    private static function sanitizeEmail($email) {
        $sanitizedEmail= filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!$sanitizedEmail) {
            throw new RuntimeException('Failed to sanitize email');
        }

        return $sanitizedEmail;
    }

    private static function sanitizeAll($rawData) {

        $data = clone $rawData;

        $data->id = static::sanitizeNumber($rawData->id);
        $data->first_name = static::sanitizeString($rawData->first_name); 
        $data->last_name = static::sanitizeString($rawData->last_name);
        $data->email = static::sanitizeEmail($rawData->email);
        $data->username = static::sanitizeString($rawData->username);
        $data->password = static::sanitizeString($rawData->password);

        return $data;
    }
}