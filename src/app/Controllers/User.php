<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\Interfaces\CrudController;

use CodeIgniter\API\ResponseTrait;


class User extends BaseController implements CrudController {

    use ResponseTrait;    

    private $userModel;

    function __construct() {
        $this->userModel = new UserModel();
    }

    function delete($id) {
        // handle user not found

    }

    function create() {

        if (!$this->validate('user')) {
            $errors = $this->validator->getErrors();
            return $this->fail($errors, 400, 'Bad Request');
        }

        $data = $this->request->getJSON();
        $data->password = password_hash($data->password, PASSWORD_DEFAULT);

        if (!$data->password) {
            return $this->failServerError('Password hashing function error', 'Internal Server Error');
        }

        try {
            $user = $this->userModel->insert($data);
            return $this->respondCreated($user);
        } catch(\Exception $e) {
            return $this->failServerError($e->getMessage(), 'Internal Server Error');
        }
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