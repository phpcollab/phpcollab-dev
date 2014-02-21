<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class projects_members_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($prj) {
		$filters = array();
		$filters[$this->router->class.'_projects_members_mbr_id'] = array('prj_mbr.mbr_id', 'like');
		$flt = $this->my_library->build_filters($filters);
		$flt[] = 'prj_mbr.prj_id = \''.$prj->prj_id.'\'';
		$columns = array();
		$columns[] = 'prj_mbr.prj_mbr_id';
		$columns[] = 'prj_mbr.mbr_id';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'prj_mbr.prj_mbr_authorized';
		$columns[] = 'prj_mbr.prj_mbr_published';
		$columns[] = 'prj_mbr.prj_mbr_datecreated';
		$col = $this->my_library->build_columns($this->router->class.'_projects_members', $columns, 'prj_mbr.prj_mbr_id', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_projects_members');
		$data = array();
		$data['prj'] = $prj;
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_projects_members');
		$data['dropdown_prj_id'] = $this->dropdown_prj_id();
		$data['dropdown_mbr_id'] = $this->dropdown_mbr_id();
		$data['dropdown_reply'] = $this->my_model->dropdown_reply();
		return $content = $this->load->view('projects_members/projects_members_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(prj_mbr.prj_mbr_id) AS count FROM '.$this->db->dbprefix('projects_members').' AS prj_mbr WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT prj.prj_name, mbr.mbr_name, prj_mbr.* FROM '.$this->db->dbprefix('projects_members').' AS prj_mbr LEFT JOIN '.$this->db->dbprefix('projects').' AS prj ON prj.prj_id = prj_mbr.prj_id LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj_mbr.mbr_id WHERE '.implode(' AND ', $flt).' GROUP BY prj_mbr.prj_mbr_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($prj_mbr_id) {
		$query = $this->db->query('SELECT prj.prj_name, mbr.mbr_name, prj_mbr.* FROM '.$this->db->dbprefix('projects_members').' AS prj_mbr LEFT JOIN '.$this->db->dbprefix('projects').' AS prj ON prj.prj_id = prj_mbr.prj_id LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj_mbr.mbr_id WHERE prj_mbr.prj_mbr_id = ? GROUP BY prj_mbr.prj_mbr_id', array($prj_mbr_id));
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
	function dropdown_mbr_id() {
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
