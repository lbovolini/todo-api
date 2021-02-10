<?php

declare(strict_types=1);

namespace App\Controllers\Interfaces;

interface CrudController {

    function delete(int $id);

    function create();

    function find(int $id);

    function update();
}