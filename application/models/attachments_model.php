<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class attachments_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($tsk) {
		$data = array();
		$data['ref_filter'] = $this->router->class.'_attachments_'.$tsk->tsk_id;
		$filters = array();
		$filters[$data['ref_filter'].'_att_name'] = array('att.att_name', 'like');
		$flt = $this->my_library->build_filters($filters);
		$flt[] = 'att.tsk_id = \''.$tsk->tsk_id.'\'';
		$columns = array();
		$columns[] = 'att.att_id';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'att.att_name';
		$columns[] = 'att.att_size';
		$columns[] = 'att.att_datecreated';
		$col = $this->my_library->build_columns($data['ref_filter'], $columns, 'att.att_datecreated', 'DESC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 10, $data['ref_filter']);
		$data['tsk'] = $tsk;
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $data['ref_filter']);
		return $this->load->view('attachments/attachments_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(att.att_id) AS count FROM '.$this->db->dbprefix('attachments').' AS att WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, att.* FROM '.$this->db->dbprefix('attachments').' AS att LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = att.att_owner WHERE '.implode(' AND ', $flt).' GROUP BY att.att_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($att_id) {
		$query = $this->db->query('SELECT mbr.mbr_name, att.* FROM '.$this->db->dbprefix('attachments').' AS att LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = att.att_owner WHERE att.att_id = ? GROUP BY att.att_id', array($att_id));
		return $query->row();
	}
}
