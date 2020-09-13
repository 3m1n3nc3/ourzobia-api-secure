<?php namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
		\App\Libraries\Custom_rules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   			  => 'CodeIgniter\Validation\Views\list',
		'single' 			  => 'CodeIgniter\Validation\Views\single',
		'my_error_list'       => 'errors/_validation_error_list',
		'my_error_plain_list' => 'errors/_validation_error_plain_list',
		'my_single_error'     => 'errors/_validation_error',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
