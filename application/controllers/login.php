<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('user_name', 'lang:user_name', 'required|callback_rule_login');
		$this->form_validation->set_rules('password', 'lang:password', 'required');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('login_index', null, true);
		} else {
			redirect('home');
		}
	}
	public function rule_login() {
		if($this->phpcollab_model->login($this->input->post('user_name'), $this->input->post('password'))) {
			return TRUE;
		} else {
			$this->form_validation->set_message('rule_login', $this->lang->line('invalid_login'));
			return FALSE;
		}
	}
}
