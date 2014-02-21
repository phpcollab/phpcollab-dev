<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		if($this->session->userdata('phpcollab_member')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('mbr_email', 'lang:mbr_email', 'required|valid_email|callback_login');
		$this->form_validation->set_rules('mbr_password', 'lang:mbr_password', 'required');

		if($this->form_validation->run() == FALSE) {
			$data = array();
			$content = $this->load->view('login/login_index', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			if($this->input->get('uri_string')) {
				redirect(base_url().$this->input->get('uri_string'));
			} else {
				redirect($this->my_url);
			}
		}
	}
	public function login() {
		if($this->input->post('mbr_email') && $this->input->post('mbr_password')) {
			if($this->auth_library->login($this->input->post('mbr_email'), $this->input->post('mbr_password'))) {
				return TRUE;
			} else {
				$this->form_validation->set_message('login', $this->lang->line('login_error'));
				$this->output->set_status_header(401);
				return FALSE;
			}
		}
	}
}
