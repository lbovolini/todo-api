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
}