<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class administration extends CI_Controller {
	public function index() {
		$data = array();
		$this->zones['content'] = $this->load->view('administration_index', $data, true);
	}
	public function system_information() {
		$data = array();
		$this->zones['content'] = $this->load->view('administration_sysinfo', $data, true);
	}
	public function company_details() {
		$this->load->library('form_validation');

		$data = array();
		$data['org'] = $this->phpcollab_model->get_organization(1);

		$this->form_validation->set_rules('name', 'lang:name', 'required|max_length[255]');
		$this->form_validation->set_rules('address1', 'lang:address', 'max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('administration_company', $data, true);
		} else {
			$this->db->set('name', $this->input->post('name'));
			$this->db->set('address1', $this->input->post('address1'));
			$this->db->where('id', 1);
			$this->db->update('organizations');
			$this->index();
		}
	}
}
