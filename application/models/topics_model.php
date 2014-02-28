<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class topics_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($prj) {
		$data = array();
		$data['ref_filter'] = $this->router->class.'_topics_'.$prj->prj_id;
		$filters = array();
		$filters[$data['ref_filter'].'_tcs_name'] = array('tcs.tcs_name', 'like');
		$filters[$data['ref_filter'].'_tcs_status'] = array('tcs.tcs_status', 'equal');
		$filters[$data['ref_filter'].'_tcs_priority'] = array('tcs.tcs_priority', 'equal');
		$flt = $this->my_library->build_filters($filters);
		$flt[] = 'tcs.prj_id = \''.$prj->prj_id.'\'';
		if($this->auth_library->permission('topics/read/onlypublished')) {
			$flt[] = 'tcs.tcs_published = \'1\'';
		}
		$columns = array();
		$columns[] = 'tcs.tcs_id';
		$columns[] = 'tcs.tcs_name';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'tcs.tcs_datecreated';
		$columns[] = 'last_post';
		$columns[] = 'count_posts';
		$columns[] = 'tcs.tcs_status';
		$columns[] = 'tcs.tcs_priority';
		$col = $this->my_library->build_columns($data['ref_filter'], $columns, 'last_post', 'DESC');
		$results = $this->get_total($flt);
		if($this->router->class == 'topics') {
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
		$data['dropdown_tcs_owner'] = $this->dropdown_tcs_owner();
		return $this->load->view('topics/topics_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(tcs.tcs_id) AS count FROM '.$this->db->dbprefix('topics').' AS tcs WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, tcs.*, (SELECT COUNT(pst.pst_id) FROM '.$this->db->dbprefix('posts').' AS pst WHERE pst.tcs_id = tcs.tcs_id) AS count_posts, (SELECT MAX(pst.pst_datecreated) FROM '.$this->db->dbprefix('posts').' AS pst WHERE pst.tcs_id = tcs.tcs_id) AS last_post FROM '.$this->db->dbprefix('topics').' AS tcs LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = tcs.tcs_owner WHERE '.implode(' AND ', $flt).' GROUP BY tcs.tcs_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($tcs_id) {
		$row = $this->db->query('SELECT mbr.mbr_name, tcs.* FROM '.$this->db->dbprefix('topics').' AS tcs LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = tcs.tcs_owner WHERE tcs.tcs_id = ? GROUP BY tcs.tcs_id', array($tcs_id))->row();
		if($row) {
			if($this->auth_library->permission('topics/delete/any')) {
				$row->action_delete = true;
			} else if($this->auth_library->permission('topics/delete/ifowner') && $row->tcs_owner == $this->phpcollab_member->mbr_id) {
				$row->action_delete = true;
			} else {
				$row->action_delete = false;
			}
		}
		return $row;
	}
	function dropdown_tcs_owner() {
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
