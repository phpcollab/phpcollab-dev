<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class statuses_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list() {
		$filters = array();
		$filters[$this->router->class.'_statuses_stu_name'] = array('stu.stu_name', 'like');
		$filters[$this->router->class.'_statuses_stu_isclosed'] = array('stu.stu_isclosed', 'like');
		$flt = $this->my_library->build_filters($filters);
		$columns = array();
		$columns[] = 'stu.stu_id';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'stu.stu_name';
		$columns[] = 'stu.stu_isclosed';
		$columns[] = 'stu.stu_ordering';
		$columns[] = 'stu.stu_datecreated';
		$col = $this->my_library->build_columns($this->router->class.'_statuses', $columns, 'stu.stu_name', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_statuses');
		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_statuses');
		$data['dropdown_stu_owner'] = $this->dropdown_stu_owner();
		return $content = $this->load->view('statuses/statuses_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(stu.stu_id) AS count FROM '.$this->db->dbprefix('statuses').' AS stu WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, stu.* FROM '.$this->db->dbprefix('statuses').' AS stu LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = stu.stu_owner WHERE '.implode(' AND ', $flt).' GROUP BY stu.stu_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($stu_id) {
		$query = $this->db->query('SELECT mbr.mbr_name, stu.* FROM '.$this->db->dbprefix('statuses').' AS stu LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = stu.stu_owner WHERE stu.stu_id = ? GROUP BY stu.stu_id', array($stu_id));
		return $query->row();
	}
	function dropdown_stu_owner() {
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
