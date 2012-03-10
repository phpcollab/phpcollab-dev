<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class organization extends CI_Controller {
	public function create() {
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('name', 'lang:name', 'required|max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('organizations/organization_create', $data, true);
		} else {
			$this->db->set('name', $this->input->post('name'));
			$this->db->insert('organizations');
			$id = $this->db->insert_id();
			$this->read($id);
		}
	}
	public function read($id) {
		$data = array();
		$data['org'] = $this->phpcollab_model->get_organization($id);
		$this->zones['content'] = $this->load->view('organizations/organization_read', $data, true);

		$filters = array();
		$filters['tasks_name'] = array('tsk.name', 'like');
		$flt = build_filters($filters);
		$flt[] = 'pro.organization = \''.intval($id).'\'';

		$columns = array();
		$columns[] = 'pro.id';
		$columns[] = 'pro.name';
		$columns[] = 'pro.priority';
		$columns[] = 'org_name';
		$columns[] = 'pro.status';
		$col = build_columns('projects', $columns, 'pro.id', 'DESC');

		$results = $this->phpcollab_model->get_projects_count($flt);
		$build_pagination = $this->phpcollab_library->build_pagination($results->count, 30);

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->phpcollab_model->get_projects_limit($flt, $build_pagination['limit'], $build_pagination['start'], 'projects');
		$this->zones['content'] .= $this->load->view('projects/projects_index', $data, true);
	}
	public function update($id) {
		$this->load->library('form_validation');

		$data = array();
		$data['org'] = $this->phpcollab_model->get_organization($id);
		$data['select_organization'] = $this->phpcollab_model->select_organization();

		$this->form_validation->set_rules('name', 'lang:name', 'required|max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('organizations/organization_update', $data, true);
		} else {
			$this->db->set('name', $this->input->post('name'));
			$this->db->where('id', $id);
			$this->db->update('organizations');
			$this->read($id);
		}
	}
}
