<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\Interfaces\CrudController;

class User extends BaseController implements CrudController {

    private $userModel;

    function __construct() {
        $this->userModel = new UserModel();
    }

    function delete($id) {
        // handle user not found
        
    }

    function create() {
        $data = $this->request->getJSON();
        $data->password = password_hash($data->password, PASSWORD_DEFAULT);

        if (!$data->password) {
            // handle error
        }
        // handle validation errors

        $user = $this->userModel->insert($data);

        return $this->response->setJSON($user);
    }

    function find($id) {
        $data = $this->userModel->find($id);

        if (!$data) {
            // handle user not found
        }

        return $this->response->setJSON($data);
    }

    function update() {
        $data = $this->request->getJSON();
        $success = $this->userModel->update($data->id, $data);

        // handle not found
        // handle validatoin errors

        if (!$success) {
            // handle error
        }

        return $this->response->setJSON($updatedData);
    }

}