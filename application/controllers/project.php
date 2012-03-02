<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class project extends CI_Controller {
	public function create() {
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('pro_name', 'lang:pro_name', 'required|max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('project_create', $data, true);
		} else {
			$this->db->set('pro_name', $this->input->post('pro_name'));
			$this->db->insert('projects');
			$pro_id = $this->db->insert_id();
			$this->read($pro_id);
		}
	}
	public function read($pro_id) {
		$data = array();
		$data['pro'] = $this->phpcollab_model->get_project($pro_id);
		$this->zones['content'] = $this->load->view('project_read', $data, true);
	}
	public function update($pro_id) {
		$this->load->library('form_validation');

		$data = array();
		$data['pro'] = $this->phpcollab_model->get_project($pro_id);

		$this->form_validation->set_rules('pro_name', 'lang:pro_name', 'required|max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('project_update', $data, true);
		} else {
			$this->db->set('pro_name', $this->input->post('pro_name'));
			$this->db->where('pro_id', $pro_id);
			$this->db->update('projects');
			$this->read($pro_id);
		}
	}
}
