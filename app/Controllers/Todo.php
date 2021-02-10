<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TodoModel;
use App\Controllers\Interfaces\CrudController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class Todo extends BaseController implements CrudController {

    use ResponseTrait;

    private TodoModel $todoModel;

    function __construct() {
        $this->todoModel = new TodoModel();
    }

    function delete(int $id): Response {
        try {
            $isTodoFound = $this->todoModel->findAndDelete($id);

            if (!$isTodoFound) {
                return $this->failNotFound("Todo with id = {$id} not found", 'Not Found');
            }

            return $this->respondNoContent();
        } catch(\Exception $e) {
            return $this->failServerError($e->getMessage(), 'Internal server error');
        }
    }

    function create(): Response {
        if (!$this->validate('todo')) {
            $errors = $this->validator->getErrors();
            return $this->fail($errors, 400, 'Bad Request');
        }

        try {
            $data = $this->request->getJSON();
            $todoId = $this->todoModel->insert($data);

            return $this->respondCreated($todoId);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage(), 'Internal server error');
        }
    }

    function find($id): Response {
        try {
            $data = $this->todoModel->find($id);

            if (!$data) {
                return $this->failNotFound("Todo with id = {$id} not found", 'Not Found');
            }

            return $this->respond($data, 200);
        } catch(\Exception $e) {
            return $this->failServerError($e->getMessage(), 'Internal Server Error');
        }
    }

    function update(): Response {
        if (!$this->validate('todo')) {
            $errors = $this->validator->getErrors();
            return $this->fail($errors, 400, 'Bad Request');
        }

        try {
            $data = $this->request->getJSON();
            $isTodoFound = $this->todoModel->findAndUpdate($data);

            if (!$isTodoFound) {
                return $this->failNotFound("Todo with id = {$data['id']} not found", 'Not Found');
            }

            return $this->respondUpdated();
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage(), 'Internal Server Error');
        }
    }

}