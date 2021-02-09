<?php

namespace App\Controllers;

use App\Models\TodoModel;
use App\Controllers\Interfaces\CrudController;

class Todo extends BaseController implements CrudController {

    private $todoModel;

    function __construct(TodoModel $todoModel) {
        $this->todoModel = $todoModel;
    }

    function delete($id) {

    }

    function create() {
        $data = $this->request->getJSON();
        $this->todoModel->insert($data);

        return $this->response->setJSON($data);
    }

    function find($id) {
        $data = $this->todoModel->find($id);

        return $this->response->setJSON($data);
    }

    function update() {
        $data = $this->request->getJSON();
        $updatedData = $this->todoModel->update($data->id, $data);

        return $this->response->setJSON($updatedData);
    }

}