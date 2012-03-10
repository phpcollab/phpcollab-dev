<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class project extends CI_Controller {
	public function create() {
		$this->load->library('form_validation');

		$data = array();
		$data['select_status'] = $this->phpcollab_model->select_status();
		$data['select_priority'] = $this->phpcollab_model->select_priority();

		$this->form_validation->set_rules('name', 'lang:name', 'required|max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('project_create', $data, true);
		} else {
			$this->db->set('name', $this->input->post('name'));
			$this->db->set('status', $this->input->post('status'));
			$this->db->set('priority', $this->input->post('priority'));
			$this->db->insert('projects');
			$id = $this->db->insert_id();
			$this->read($id);
		}
	}
	public function read($id) {
		$data = array();
		$data['pro'] = $this->phpcollab_model->get_project($id);
		$data['org'] = $this->phpcollab_model->get_organization($data['pro']->organization);
		$this->zones['content'] = $this->load->view('project_read', $data, true);

		$filters = array();
		$filters['tasks_name'] = array('tsk.name', 'like');
		$flt = build_filters($filters);
		$flt[] = 'tsk.project = \''.intval($id).'\'';

		$columns = array();
		$columns[] = 'tsk.id';
		$columns[] = 'tsk.name';
		$columns[] = 'tsk.priority';
		$columns[] = 'tsk.status';
		$columns[] = 'tsk.completion';
		$columns[] = 'tsk.published';
		$col = build_columns('tasks', $columns, 'tsk.id', 'DESC');

		$results = $this->phpcollab_model->get_tasks_count($flt);
		$build_pagination = $this->phpcollab_library->build_pagination($results->count, 5, 'tasks_'.$id);

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->phpcollab_model->get_tasks_limit($flt, $build_pagination['limit'], $build_pagination['start'], 'tasks');
		$this->zones['content'] .= $this->load->view('tasks_index', $data, true);

		$filters = array();
		$filters['topics_name'] = array('tpc.name', 'like');
		$flt = build_filters($filters);
		$flt[] = 'tpc.project = \''.intval($id).'\'';

		$columns = array();
		$columns[] = 'tpc.id';
		$columns[] = 'tpc.subject';
		$columns[] = 'tpc.posts';
		$columns[] = 'tpc.last_post';
		$columns[] = 'tpc.status';
		$col = build_columns('topics', $columns, 'tpc.id', 'DESC');

		$results = $this->phpcollab_model->get_topics_count($flt);
		$build_pagination = $this->phpcollab_library->build_pagination($results->count, 5, 'topics_'.$id);

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->phpcollab_model->get_topics_limit($flt, $build_pagination['limit'], $build_pagination['start'], 'topics');
		$this->zones['content'] .= $this->load->view('topics_index', $data, true);
	}
	public function update($id) {
		$this->load->library('form_validation');

		$data = array();
		$data['pro'] = $this->phpcollab_model->get_project($id);
		$data['select_status'] = $this->phpcollab_model->select_status();
		$data['select_priority'] = $this->phpcollab_model->select_priority();
		$data['select_organization'] = $this->phpcollab_model->select_organization();

		$this->form_validation->set_rules('name', 'lang:name', 'required|max_length[255]');
		$this->form_validation->set_rules('priority', 'lang:priority', 'required|numeric');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('project_update', $data, true);
		} else {
			$this->db->set('name', $this->input->post('name'));
			$this->db->set('status', $this->input->post('status'));
			$this->db->set('priority', $this->input->post('priority'));
			$this->db->set('description', $this->input->post('description'));
			$this->db->set('url_dev', $this->input->post('url_dev'));
			$this->db->set('url_prod', $this->input->post('url_prod'));
			$this->db->set('organization', $this->input->post('organization'));
			$this->db->where('id', $id);
			$this->db->update('projects');
			$this->read($id);
		}
	}
}
