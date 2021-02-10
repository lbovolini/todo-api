<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class TodoModel extends Model {
    
    protected $table = "todos";

    protected $allowedFields = ['users_id'];

    public function findAndDelete(int $id): bool {

        $findByIdQuery = "SELECT 1 FROM {$this->table} WHERE id = :id: LIMIT 1;";
        $deleteQuery = "DELETE FROM {$this->table} WHERE id =:id: LIMIT 1";

        // start transaction
        $this->db->transStart();

        $result = $this->db->query($findByIdQuery, ['id' => $id]);
        $isTodoFound = $result->getNumRows() > 0;

        if ($isTodoFound) {
            $this->db->query($deleteQuery, ['id' => $id]);
        }

        // end transaction
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \RuntimeException("Error executing delete query in {$this->table} table");
        }

        return $isTodoFound;
    }

    public function findAndUpdate(array $data): bool {

        $findByIdQuery = "SELECT 1 FROM {$this->table} WHERE id = :id: LIMIT 1;";
        $updateQuery = "UPDATE {$this->table} " .
            "SET " .
                "users_id = :users_id" .
            "WHERE id = :id: LIMIT 1;";

        // start transaction
        $this->db->transStart();

        $result = $this->db->query($findByIdQuery, $data);
        $isTodoFound = $result->getNumRows() > 0;

        if ($isTodoFound) {
            $this->db->query($updateQuery, $data);
        }

        // end transaction
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \RuntimeException("Error executing update query in {$this->table} table");
        }

        return $isTodoFound;
    }
}