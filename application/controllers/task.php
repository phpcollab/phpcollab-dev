<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class task extends CI_Controller {
	public function create() {
		$this->load->library('form_validation');

		$data = array();
		$data['select_project'] = $this->phpcollab_model->select_project();

		$this->form_validation->set_rules('name', 'lang:name', 'required|max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('task_create', $data, true);
		} else {
			$this->db->set('project', $this->input->post('project'));
			$this->db->set('name', $this->input->post('name'));
			$this->db->insert('tasks');
			$id = $this->db->insert_id();
			$this->read($id);
		}
	}
	public function read($id) {
		$data = array();
		$data['tsk'] = $this->phpcollab_model->get_task($id);
		$data['pro'] = $this->phpcollab_model->get_project($data['tsk']->project);
		$data['org'] = $this->phpcollab_model->get_organization($data['pro']->organization);
		$this->zones['content'] = $this->load->view('task_read', $data, true);
	}
	public function update($id) {
		$this->load->library('form_validation');

		$data = array();
		$data['tsk'] = $this->phpcollab_model->get_task($id);
		$data['pro'] = $this->phpcollab_model->get_project($data['tsk']->project);
		$data['select_project'] = $this->phpcollab_model->select_project();

		$this->form_validation->set_rules('name', 'lang:name', 'required|max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('task_update', $data, true);
		} else {
			$this->db->set('project', $this->input->post('project'));
			$this->db->set('name', $this->input->post('name'));
			$this->db->set('description', $this->input->post('description'));
			$this->db->where('id', $id);
			$this->db->update('tasks');
			$this->read($id);
		}
	}
}
