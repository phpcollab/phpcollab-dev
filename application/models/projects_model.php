<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class projects_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($org = false) {
		$data = array();
		$filters = array();
		$filters[$this->router->class.'_projects_prj_name'] = array('prj.prj_name', 'like');
		$flt = $this->my_library->build_filters($filters);
		if($org) {
			$data['org'] = $org;
			$flt[] = 'prj.org_id = \''.$org->org_id.'\'';
		}
		$columns = array();
		$columns[] = 'prj.prj_id';
		if($this->router->class != 'organizations') {
			$columns[] = 'org.org_name';
		}
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'prj.prj_name';
		$columns[] = 'prj.prj_date_start';
		$columns[] = 'prj.prj_status';
		$columns[] = 'prj.prj_priority';
		$columns[] = 'tsk_completion';
		$columns[] = 'prj.prj_datecreated';
		$col = $this->my_library->build_columns($this->router->class.'_projects', $columns, 'prj.prj_name', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_projects');
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_projects');
		$data['dropdown_org_id'] = $this->dropdown_org_id();
		$data['dropdown_prj_owner'] = $this->dropdown_prj_owner();
		return $content = $this->load->view('projects/projects_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(prj.prj_id) AS count FROM '.$this->db->dbprefix('projects').' AS prj WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT org.org_name, mbr.mbr_name, prj.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = prj.prj_id)  AS tsk_completion FROM '.$this->db->dbprefix('projects').' AS prj LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = prj.org_id LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj.prj_owner WHERE '.implode(' AND ', $flt).' GROUP BY prj.prj_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($prj_id) {
		$query = $this->db->query('SELECT org.org_name, mbr.mbr_name, prj.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = prj.prj_id)  AS tsk_completion FROM '.$this->db->dbprefix('projects').' AS prj LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = prj.org_id LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj.prj_owner WHERE prj.prj_id = ? GROUP BY prj.prj_id', array($prj_id));
		return $query->row();
	}
	function dropdown_org_id() {
		$select = array();
		$select[''] = '-';
		$query = $this->db->query('SELECT org.org_id AS field_key, org.org_name AS field_label FROM '.$this->db->dbprefix('organizations').' AS org GROUP BY org.org_id ORDER BY org.org_name ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select[$row->field_key] = $row->field_label;
			}
		}
		return $select;
	}
	function dropdown_prj_owner() {
		$select = array();
		$select[''] = '-';
		$query = $this->db->query('SELECT mbr.mbr_id AS field_key, org.org_name AS field_optgroup, mbr.mbr_name AS field_label FROM '.$this->db->dbprefix('members').' AS mbr LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = mbr.org_id GROUP BY mbr.mbr_id ORDER BY org.org_name ASC, mbr.mbr_name ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select[$row->field_optgroup][$row->field_key] = $row->field_label;
			}
		}
		return $select;
	}
}
