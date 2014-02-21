<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tasks_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($prj, $mln = false) {
		$data = array();
		$data['prj'] = $prj;
		if($mln) {
			$data['mln'] = $mln;
			$data['ref_filter'] = $this->router->class.'_tasks_'.$mln->mln_id;
		} else {
			$data['ref_filter'] = $this->router->class.'_tasks_'.$prj->prj_id;
		}
		$filters = array();
		$filters[$data['ref_filter'].'_trk_id'] = array('tsk.trk_id', 'equal');
		if($this->router->class != 'milestones') {
			$filters[$data['ref_filter'].'_mln_id'] = array('tsk.mln_id', 'equal');
		}
		$filters[$data['ref_filter'].'_tsk_assigned'] = array('tsk.tsk_assigned', 'like');
		$flt = $this->my_library->build_filters($filters);
		if($mln) {
			$flt[] = 'tsk.mln_id = \''.$mln->mln_id.'\'';
		} else {
			$flt[] = 'tsk.prj_id = \''.$prj->prj_id.'\'';
		}
		$columns = array();
		$columns[] = 'tsk.tsk_id';
		$columns[] = 'trk.trk_name';
		if($this->router->class != 'milestones') {
			$columns[] = 'mln.mln_name';
		}
		$columns[] = 'mbr_name_assigned';
		$columns[] = 'tsk.tsk_name';
		$columns[] = 'tsk.tsk_date_start';
		$columns[] = 'tsk.tsk_status';
		$columns[] = 'tsk.tsk_priority';
		$columns[] = 'tsk.tsk_completion';
		$col = $this->my_library->build_columns($data['ref_filter'], $columns, 'tsk.tsk_name', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $data['ref_filter']);
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $data['ref_filter']);
		$data['dropdown_trk_id'] = $this->dropdown_trk_id();
		$data['dropdown_mln_id'] = $this->dropdown_mln_id($prj->prj_id);
		$data['dropdown_tsk_owner'] = $this->dropdown_tsk_owner();
		$data['dropdown_tsk_assigned'] = $this->dropdown_tsk_assigned();
		$data['dropdown_tsk_parent'] = $this->dropdown_tsk_parent($prj->prj_id);
		return $content = $this->load->view('tasks/tasks_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(tsk.tsk_id) AS count FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT prj.prj_name, trk.trk_name, mln.mln_name, mbr.mbr_name, mbr_assigned.mbr_name AS mbr_name_assigned, tsk_parent.tsk_name AS tsk_name_parent, tsk.* FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('projects').' AS prj ON prj.prj_id = tsk.prj_id LEFT JOIN '.$this->db->dbprefix('trackers').' AS trk ON trk.trk_id = tsk.trk_id LEFT JOIN '.$this->db->dbprefix('milestones').' AS mln ON mln.mln_id = tsk.mln_id LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = tsk.tsk_owner LEFT JOIN '.$this->db->dbprefix('members').' AS mbr_assigned ON mbr_assigned.mbr_id = tsk.tsk_assigned LEFT JOIN '.$this->db->dbprefix('tasks').' AS tsk_parent ON tsk_parent.tsk_id = tsk.tsk_parent WHERE '.implode(' AND ', $flt).' GROUP BY tsk.tsk_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($tsk_id) {
		$query = $this->db->query('SELECT prj.prj_name, trk.trk_name, mln.mln_name, mbr.mbr_name,  mbr_assigned.mbr_name AS mbr_name_assigned, tsk_parent.tsk_name AS tsk_name_parent, tsk.* FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('projects').' AS prj ON prj.prj_id = tsk.prj_id LEFT JOIN '.$this->db->dbprefix('trackers').' AS trk ON trk.trk_id = tsk.trk_id LEFT JOIN '.$this->db->dbprefix('milestones').' AS mln ON mln.mln_id = tsk.mln_id LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = tsk.tsk_owner LEFT JOIN '.$this->db->dbprefix('members').' AS mbr_assigned ON mbr_assigned.mbr_id = tsk.tsk_assigned LEFT JOIN '.$this->db->dbprefix('tasks').' AS tsk_parent ON tsk_parent.tsk_id = tsk.tsk_parent WHERE tsk.tsk_id = ? GROUP BY tsk.tsk_id', array($tsk_id));
		return $query->row();
	}
	function dropdown_prj_id() {
		$select = array();
		$select[''] = '-';
		$query = $this->db->query('SELECT prj.prj_id AS field_key, prj.prj_name AS field_label FROM '.$this->db->dbprefix('projects').' AS prj GROUP BY prj.prj_id ORDER BY prj.prj_name ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select[$row->field_key] = $row->field_label;
			}
		}
		return $select;
	}
	function dropdown_trk_id() {
		$select = array();
		$select[''] = '-';
		$query = $this->db->query('SELECT trk.trk_id AS field_key, trk.trk_name AS field_label FROM '.$this->db->dbprefix('trackers').' AS trk GROUP BY trk.trk_id ORDER BY trk.trk_name ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select[$row->field_key] = $row->field_label;
			}
		}
		return $select;
	}
	function dropdown_mln_id($prj_id) {
		$select = array();
		$select[''] = '-';
		$query = $this->db->query('SELECT mln.mln_id AS field_key, mln.mln_name AS field_label FROM '.$this->db->dbprefix('milestones').' AS mln WHERE mln.prj_id = ? GROUP BY mln.mln_id ORDER BY mln.mln_name ASC', array($prj_id));
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select[$row->field_key] = $row->field_label;
			}
		}
		return $select;
	}
	function dropdown_tsk_owner() {
		$select = array();
		$select[''] = '-';
		$query = $this->db->query('SELECT mbr.mbr_id AS field_key, mbr.mbr_name AS field_label FROM '.$this->db->dbprefix('members').' AS mbr GROUP BY mbr.mbr_id ORDER BY mbr.mbr_name ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select[$row->field_key] = $row->field_label;
			}
		}
		return $select;
	}
	function dropdown_tsk_assigned() {
		$select = array();
		$select[''] = '-';
		$query = $this->db->query('SELECT mbr_assigned.mbr_id AS field_key, mbr_assigned.mbr_name AS field_label FROM '.$this->db->dbprefix('members').' AS mbr_assigned GROUP BY mbr_assigned.mbr_id ORDER BY mbr_assigned.mbr_name ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select[$row->field_key] = $row->field_label;
			}
		}
		return $select;
	}
	function dropdown_tsk_parent($prj_id) {
		$select = array();
		$select[''] = '-';
		$query = $this->db->query('SELECT tsk_parent.tsk_id AS field_key, tsk_parent.tsk_name AS field_label FROM '.$this->db->dbprefix('tasks').' AS tsk_parent WHERE tsk_parent.prj_id = ? GROUP BY tsk_parent.tsk_id ORDER BY tsk_parent.tsk_name ASC', array($prj_id));
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select[$row->field_key] = $row->field_label;
			}
		}
		return $select;
	}
}
