<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class tasks extends CI_Controller {
	public function index($id) {
		$filters = array();
		$filters['tasks_name'] = array('pro.name', 'like');
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
		$build_pagination = $this->phpcollab_library->build_pagination($results->count, 20, 'tasks');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->phpcollab_model->get_tasks_limit($flt, $build_pagination['limit'], $build_pagination['start'], 'tasks');
		$data['pro'] = $this->phpcollab_model->get_project($id);
		$this->zones['content'] = $this->load->view('tasks/tasks_index', $data, true);
	}
}
