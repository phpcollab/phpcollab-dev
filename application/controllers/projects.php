<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class projects extends CI_Controller {
	public function index() {
		$filters = array();
		$filters['projects_name'] = array('pro.name', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'pro.id';
		$columns[] = 'pro.name';
		$columns[] = 'pro.priority';
		$columns[] = 'org_name';
		$columns[] = 'pro.status';
		$col = build_columns('projects', $columns, 'pro.id', 'DESC');

		$results = $this->phpcollab_model->get_projects_count($flt);
		$build_pagination = $this->phpcollab_library->build_pagination($results->count, 20, 'projects');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->phpcollab_model->get_projects_limit($flt, $build_pagination['limit'], $build_pagination['start'], 'projects');
		$this->zones['content'] = $this->load->view('projects/projects_index', $data, true);
	}
}
