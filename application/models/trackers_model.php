<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class trackers_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list() {
		$filters = array();
		$filters[$this->router->class.'_trackers_trk_name'] = array('trk.trk_name', 'like');
		$flt = $this->my_library->build_filters($filters);
		$columns = array();
		$columns[] = 'trk.trk_owner';
		$columns[] = 'trk.trk_name';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'trk.tsk_description';
		$columns[] = 'trk.trk_datecreated';
		$col = $this->my_library->build_columns($this->router->class.'_trackers', $columns, 'trk.trk_name', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_trackers');
		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_trackers');
		$data['dropdown_trk_owner'] = $this->dropdown_trk_owner();
		return $this->load->view('trackers/trackers_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(trk.trk_id) AS count FROM '.$this->db->dbprefix('trackers').' AS trk WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, trk.* FROM '.$this->db->dbprefix('trackers').' AS trk LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = trk.trk_owner WHERE '.implode(' AND ', $flt).' GROUP BY trk.trk_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($trk_id) {
		$query = $this->db->query('SELECT mbr.mbr_name, trk.* FROM '.$this->db->dbprefix('trackers').' AS trk LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = trk.trk_owner WHERE trk.trk_id = ? GROUP BY trk.trk_id', array($trk_id));
		return $query->row();
	}
	function dropdown_trk_owner() {
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
