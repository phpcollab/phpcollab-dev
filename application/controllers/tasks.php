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
		$columns[] = 'tsk.due_date';
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
	public function gantt($id) {
		include('thirdparty/jpgraph/jpgraph.php');
		include('thirdparty/jpgraph/jpgraph_gantt.php');

		$pro = $this->phpcollab_model->get_project($id);

		$graph = new GanttGraph();
		$graph->SetBox();
		$graph->SetMarginColor('white');
		$graph->SetColor('white');
		$graph->title->Set($this->lang->line('project').' '.$pro->name);
		$graph->subtitle->Set('('.$this->lang->line('created').': '.$pro->created.')');
		$graph->title->SetFont(FF_FONT1);
		$graph->SetColor('white');
		$graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH | GANTT_HDAY | GANTT_HWEEK);
		$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY);
		$graph->scale->week->SetFont(FF_FONT0);
		$graph->scale->year->SetFont(FF_FONT1);

		$flt = array();
		$flt[] = 'tsk.project = \''.intval($id).'\'';
		$flt[] = 'tsk.due_date != \'--\'';
		$flt[] = 'tsk.due_date != \'0000-00-00\'';
		$flt[] = 'tsk.due_date != \'\'';
        $query = $this->db->query('SELECT tsk.id, tsk.name, tsk.priority, tsk.completion, tsk.start_date, tsk.due_date, mbr.login AS mbr_login FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('members').' mbr ON mbr.id = tsk.assigned_to WHERE '.implode(' AND ', $flt).' GROUP BY tsk.id ORDER BY tsk.due_date');
		if($query->num_rows() > 0) {
			$u = 0;
			foreach($query->result() as $row) {
				$progress = round($row->completion / 10, 2);
				$print_progress = $row->completion * 10;
				$activity = new GanttBar($u, $row->name, $row->start_date, $row->due_date);
				$activity->SetPattern(BAND_LDIAG, 'yellow');
				$activity->caption->Set($row->mbr_login.' ('.$print_progress.'%)');
				$activity->SetFillColor('gray');
				if($row->priority == '4' || $row->priority == '5') {
					$activity->progress->SetPattern(BAND_SOLID, '#BB0000');
				} else {
					$activity->progress->SetPattern(BAND_SOLID, '#0000BB');
				}
				$activity->progress->Set($progress);
				$graph->Add($activity);
				$u++;
			}
		}
		$graph->Stroke();
		exit(0);
	}
}
