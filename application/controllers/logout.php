<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->auth_library->logout();

		redirect($this->my_url.'login');
	}
}
