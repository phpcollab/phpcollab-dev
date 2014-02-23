<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class files_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($prj) {
		$data = array();
		$data['ref_filter'] = $this->router->class.'_files_'.$prj->prj_id;
		$filters = array();
		$filters[$data['ref_filter'].'_fle_name'] = array('fle.fle_name', 'like');
		$flt = $this->my_library->build_filters($filters);
		$flt[] = 'fle.prj_id = \''.$prj->prj_id.'\'';
		$columns = array();
		$columns[] = 'fle.fle_id';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'fle.fle_name';
		$columns[] = 'fle.fle_size';
		if($this->auth_library->permission('files/read/onlypublished')) {
			$flt[] = 'fle.fle_published = \'1\'';
		}
		$col = $this->my_library->build_columns($data['ref_filter'], $columns, 'fle.fle_name', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $data['ref_filter']);
		$data['prj'] = $prj;
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $data['ref_filter']);
		$data['dropdown_fle_owner'] = $this->dropdown_fle_owner();
		return $this->load->view('files/files_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(fle.fle_id) AS count FROM '.$this->db->dbprefix('files').' AS fle WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, fle.* FROM '.$this->db->dbprefix('files').' AS fle LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = fle.fle_owner WHERE '.implode(' AND ', $flt).' GROUP BY fle.fle_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($fle_id) {
		$query = $this->db->query('SELECT mbr.mbr_name, fle.* FROM '.$this->db->dbprefix('files').' AS fle LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = fle.fle_owner WHERE fle.fle_id = ? GROUP BY fle.fle_id', array($fle_id));
		return $query->row();
	}
	function dropdown_fle_owner() {
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
