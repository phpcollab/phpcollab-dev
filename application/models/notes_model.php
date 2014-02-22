<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notes_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($prj) {
		$data = array();
		$data['ref_filter'] = $this->router->class.'_notes_'.$prj->prj_id;
		$filters = array();
		$filters[$data['ref_filter'].'_nte_name'] = array('nte.nte_name', 'like');
		$flt = $this->my_library->build_filters($filters);
		$flt[] = 'nte.prj_id = \''.$prj->prj_id.'\'';
		$columns = array();
		$columns[] = 'nte.nte_id';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'nte.nte_name';
		$columns[] = 'nte.nte_date';
		$col = $this->my_library->build_columns($data['ref_filter'], $columns, 'nte.nte_name', 'ASC');
		$results = $this->get_total($flt);
		if($this->router->class == 'notes') {
			$limit = 30;
		} else {
			$limit = 10;
		}
		$build_pagination = $this->my_library->build_pagination($results->count, $limit, $data['ref_filter']);
		$data['prj'] = $prj;
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $data['ref_filter']);
		$data['dropdown_nte_owner'] = $this->dropdown_nte_owner();
		return $content = $this->load->view('notes/notes_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(nte.nte_id) AS count FROM '.$this->db->dbprefix('notes').' AS nte WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, nte.* FROM '.$this->db->dbprefix('notes').' AS nte LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = nte.nte_owner WHERE '.implode(' AND ', $flt).' GROUP BY nte.nte_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($nte_id) {
		$query = $this->db->query('SELECT mbr.mbr_name, nte.* FROM '.$this->db->dbprefix('notes').' AS nte LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = nte.nte_owner WHERE nte.nte_id = ? GROUP BY nte.nte_id', array($nte_id));
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
	function dropdown_nte_owner() {
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
