<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class preferences extends CI_Controller {
	public function index() {
		$data = array();
		$this->zones['content'] = $this->load->view('preferences/preferences_index', $data, true);
	}
	public function profile() {
		$this->load->library('form_validation');

		$data = array();
		$data['mbr'] = $this->phpcollab_model->get_member($this->session->userdata('id'));

		$this->form_validation->set_rules('name', 'lang:full_name', 'required|max_length[155]');
		$this->form_validation->set_rules('title', 'lang:title', 'max_length[155]');
		$this->form_validation->set_rules('email_work', 'lang:email', 'max_length[155]|valid_email');
		$this->form_validation->set_rules('phone_work', 'lang:work_phone', 'max_length[155]');
		$this->form_validation->set_rules('phone_home', 'lang:home_phone', 'max_length[155]');
		$this->form_validation->set_rules('mobile', 'lang:mobile_phone', 'max_length[155]');
		$this->form_validation->set_rules('fax', 'lang:fax', 'max_length[155]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('preferences/preferences_profile', $data, true);
		} else {
			$this->db->set('name', $this->input->post('name'));
			$this->db->set('title', $this->input->post('title'));
			$this->db->set('email_work', $this->input->post('email_work'));
			$this->db->set('phone_work', $this->input->post('phone_work'));
			$this->db->set('phone_home', $this->input->post('phone_home'));
			$this->db->set('mobile', $this->input->post('mobile'));
			$this->db->set('fax', $this->input->post('fax'));
			$this->db->where('id', $this->session->userdata('id'));
			$this->db->update('members');
			$this->member = $this->phpcollab_model->get_member($this->session->userdata('id'));
			$this->index();
		}
	}
	public function rule_old_password($old_password) {
		$this->form_validation->set_message('rule_old_password', $this->lang->line('old_password_error'));
		return $this->phpcollab_model->password_check($old_password, $this->member->password);
	}
	public function password() {
		$this->load->library('form_validation');

		$data = array();
		$data['mbr'] = $this->phpcollab_model->get_member($this->session->userdata('id'));

		$this->form_validation->set_rules('old_password', 'lang:old_password', 'required|callback_rule_old_password');
		$this->form_validation->set_rules('new_password', 'lang:new_password', 'required');
		$this->form_validation->set_rules('confirm_password', 'lang:confirm_password', 'required|matches[new_password]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('preferences/preferences_password', $data, true);
		} else {
			$this->db->set('password', $this->phpcollab_model->password_save($this->input->post('new_password')));
			$this->db->where('id', $this->session->userdata('id'));
			$this->db->update('members');
			$this->member = $this->phpcollab_model->get_member($this->session->userdata('id'));
			$this->index();
		}
	}
}
