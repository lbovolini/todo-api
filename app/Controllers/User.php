<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\Interfaces\CrudController;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;


class User extends BaseController implements CrudController {

    use ResponseTrait;    

    private UserModel $userModel;

    function __construct() {
        $this->userModel = new UserModel();
    }

    function delete(int $id): Response {
        try {
            $isUserFound = $this->userModel->findAndDelete($id);

            if (!$isUserFound) {
                return $this->failNotFound("User with id = {$id} not found", 'Not Found');
            }

            return $this->respondNoContent();
        } catch(\Exception $e) {
            return $this->failServerError($e->getMessage(), 'Internal Server Error');
        }

    }

    function create(): Response {

        if (!$this->validate('user')) {
            $errors = $this->validator->getErrors();
            return $this->fail($errors, 400, 'Bad Request');
        }

        try {
            $data = $this->request->getJSON();
            $data->password = password_hash($data->password, PASSWORD_DEFAULT);

            if (!$data->password) {
                return $this->failServerError('Password hashing function error', 'Internal Server Error');
            }

            $user = $this->userModel->insert($data);
            return $this->respondCreated($user);
        } catch(\Exception $e) {
            return $this->failServerError($e->getMessage(), 'Internal Server Error');
        }
    }

    function find(int $id): Response {
        try {
            $data = $this->userModel->find($id);

            if (!$data) {
                return $this->failNotFound("User with id = {$id} not found", 'Not Found');
            }

            return $this->respond($data, 200);
        } catch(\Exception $e) {
            return $this->failServerError($e->getMessage(), 'Internal Server Error');
        }
    }

    function update(): Response {

        if (!$this->validate('user')) {
            $errors = $this->validator->getErrors();
            return $this->fail($errors, 400, 'Bad Request');
        }

        try {

            $data = $this->request->getJSON(true);
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            if (!$data['password']) {
                return $this->failServerError('Password hashing function error', 'Internal Server Error');
            }

            $isUserFound = $this->userModel->findAndUpdate($data);

            if (!$isUserFound) {
                return $this->failNotFound("User with id = {$data['id']} not found", 'Not Found');
            }

            return $this->respondUpdated();
        } catch(\Exception $e) {
            return $this->failServerError($e->getMessage(), 'Internal Server Error');
        }
    }

}