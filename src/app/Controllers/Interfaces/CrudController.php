<?php

namespace App\Controllers\Interfaces;

interface CrudController {

    function delete($id);

    function create();

    function find($id);

    function update();
}