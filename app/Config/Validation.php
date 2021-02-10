<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

use App\Validations\SanitizerRules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
		SanitizerRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $user = [
		'id' => 'required_in_update|is_sanitized_number',
		'first_name' => 'required|trim|max_length[50]|is_sanitized_string', 
        'last_name' => 'required|trim|max_length[100]|is_sanitized_string', 
        'email' => 'required|trim|max_length[100]|is_sanitized_email|valid_email|is_unique[users.email, id, {id}]',
        'username' => 'required|trim|max_length[20]|is_sanitized_string|regex_match[^(\w){3,20}\b]|is_unique[users.username, id, {id}]',
        'password' => 'required|trim|max_length[255]|is_sanitized_string|regex_match[^(?=.*[\d])(?=.*[a-z])[\w!@#$%^&*()-=+,.;:]{8,}$]',
        'birthday' => 'required|trim|valid_date'
	];

	public $todo = [
	    'id' => 'required_in_update|is_sanitized_number',
        'users_id' => 'required|is_sanitized_number'
    ];
}
