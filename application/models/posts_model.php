<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class posts_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($tcs) {
		$data = array();
		$flt = array();
		$flt[] = 'pst.tcs_id = \''.$tcs->tcs_id.'\'';
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, 'posts_'.$tcs->tcs_id);
		$data['tcs'] = $tcs;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], 'posts_'.$tcs->tcs_id);
		return $this->load->view('posts/posts_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(pst.pst_id) AS count FROM '.$this->db->dbprefix('posts').' AS pst WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, pst.* FROM '.$this->db->dbprefix('posts').' AS pst LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = pst.pst_owner WHERE '.implode(' AND ', $flt).' GROUP BY pst.pst_id ORDER BY pst.pst_datecreated DESC LIMIT '.$offset.', '.$num);
		return $query->result();
	}
}
