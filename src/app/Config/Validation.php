<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

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
		'first_name' => 'required|max_length[255]', 
        'last_name' => 'required|max_length[255]', 
        'email' => 'required|max_length[255]|valid_email|is_unique[users.email, id, {id}]',
        'username' => 'required|max_length[20]|regex_match[^(\w){3,20}\b]',
        'password' => 'required|max_length[255]|regex_match[^(?=.*[\d])(?=.*[a-z])[\w!@#$%^&*()-=+,.;:]{8,}$]',
        'birthday' => 'required|valid_date'
	];
}
