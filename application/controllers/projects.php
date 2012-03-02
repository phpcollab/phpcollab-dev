<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class projects extends CI_Controller {
	public function index() {
		$filters = array();
		$filters['home_projects_pro_name'] = array('pro.pro_name', 'like');
		$flt = build_filters($filters);

		$results = $this->phpcollab_model->get_projects_count($flt);
		$build_pagination = $this->phpcollab_library->build_pagination($results->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->phpcollab_model->get_projects_limit($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('projects_index', $data, true);
	}
}
