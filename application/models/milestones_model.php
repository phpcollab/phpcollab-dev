<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class milestones_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($prj) {
		$filters = array();
		$filters[$this->router->class.'_milestones_mln_owner'] = array('mln.mln_owner', 'equal');
		$flt = $this->my_library->build_filters($filters);
		$flt[] = 'mln.prj_id = \''.$prj->prj_id.'\'';
		$columns = array();
		$columns[] = 'mln.mln_id';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'mln.mln_name';
		$columns[] = 'mln.mln_date_start';
		$columns[] = 'mln.mln_status';
		$columns[] = 'mln.mln_priority';
		$columns[] = 'tsk_completion';
		$col = $this->my_library->build_columns($this->router->class.'_milestones', $columns, 'mln.mln_name', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_milestones');
		$data = array();
		$data['prj'] = $prj;
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_milestones');
		$data['dropdown_mln_owner'] = $this->dropdown_mln_owner();
		return $content = $this->load->view('milestones/milestones_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(mln.mln_id) AS count FROM '.$this->db->dbprefix('milestones').' AS mln WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, mln.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.mln_id = mln.mln_id)  AS tsk_completion FROM '.$this->db->dbprefix('milestones').' AS mln LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = mln.mln_owner WHERE '.implode(' AND ', $flt).' GROUP BY mln.mln_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($mln_id) {
		$query = $this->db->query('SELECT mbr.mbr_name, mln.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.mln_id = mln.mln_id)  AS tsk_completion FROM '.$this->db->dbprefix('milestones').' AS mln LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = mln.mln_owner WHERE mln.mln_id = ? GROUP BY mln.mln_id', array($mln_id));
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
	function dropdown_mln_owner() {
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
}
