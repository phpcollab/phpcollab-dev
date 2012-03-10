<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class logout extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->db->set('connected', '');
		$this->db->where('login', $this->member->login);
		$this->db->update('logs');

		$this->session->sess_destroy();
		redirect('login');
	}
}
