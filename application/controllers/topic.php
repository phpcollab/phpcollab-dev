<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class topic extends CI_Controller {
	public function create($id) {
		$this->load->library('form_validation');

		$data = array();
		$data['pro'] = $this->phpcollab_model->get_project($id);
		$data['select_project'] = $this->phpcollab_model->select_project();
		$data['select_status'] = $this->phpcollab_model->select_status();
		$data['select_priority'] = $this->phpcollab_model->select_priority();
		$data['select_completion'] = $this->phpcollab_model->select_completion();

		$this->form_validation->set_rules('name', 'lang:name', 'required|max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('topic_create', $data, true);
		} else {
			$this->db->set('project', $this->input->post('project'));
			$this->db->set('subject', $this->input->post('subject'));
			$this->db->set('status', 1);
			$this->db->insert('topics');
			$id = $this->db->insert_id();
			$this->read($id);
		}
	}
	public function read($id) {
		$data = array();
		$data['tpc'] = $this->phpcollab_model->get_topic($id);
		$data['pro'] = $this->phpcollab_model->get_project($data['tpc']->project);
		$data['org'] = $this->phpcollab_model->get_organization($data['pro']->organization);
		$this->zones['content'] = $this->load->view('topic_read', $data, true);
	}
	public function update($id) {
		$this->load->library('form_validation');

		$data = array();
		$data['tpc'] = $this->phpcollab_model->get_topic($id);
		$data['pro'] = $this->phpcollab_model->get_project($data['tpc']->project);
		$data['select_project'] = $this->phpcollab_model->select_project();
		$data['select_status'] = $this->phpcollab_model->select_status();
		$data['select_priority'] = $this->phpcollab_model->select_priority();
		$data['select_completion'] = $this->phpcollab_model->select_completion();

		$this->form_validation->set_rules('name', 'lang:name', 'required|max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('topic_update', $data, true);
		} else {
			$this->db->set('project', $this->input->post('project'));
			$this->db->set('subject', $this->input->post('subject'));
			$this->db->set('status', $this->input->post('status'));
			$this->db->where('id', $id);
			$this->db->update('topics');
			$this->read($id);
		}
	}
}
