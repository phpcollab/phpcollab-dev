<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class organizations extends CI_Controller {
	public function index() {
		$filters = array();
		$filters['organizations_name'] = array('pro.name', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'org.id';
		$columns[] = 'org.name';
		$columns[] = 'count_projects';
		$col = build_columns('organizations', $columns, 'org.id', 'DESC');

		$results = $this->phpcollab_model->get_organizations_count($flt);
		$build_pagination = $this->phpcollab_library->build_pagination($results->count, 30);

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->phpcollab_model->get_organizations_limit($flt, $build_pagination['limit'], $build_pagination['start'], 'organizations');
		$this->zones['content'] = $this->load->view('organizations_index', $data, true);
	}
}
