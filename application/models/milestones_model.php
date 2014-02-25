<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class milestones_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($prj) {
		$data = array();
		$data['ref_filter'] = $this->router->class.'_milestones_'.$prj->prj_id;
		$filters = array();
		$filters[$data['ref_filter'].'_mln_name'] = array('mln.mln_name', 'like');
		$filters[$data['ref_filter'].'_stu_isclosed'] = array('stu.stu_isclosed', 'equal');
		$filters[$data['ref_filter'].'_mln_status'] = array('mln.mln_status', 'equal');
		$filters[$data['ref_filter'].'_mln_priority'] = array('mln.mln_priority', 'equal');
		$flt = $this->my_library->build_filters($filters);
		$flt[] = 'mln.prj_id = \''.$prj->prj_id.'\'';
		if($this->auth_library->permission('milestones/read/onlypublished')) {
			$flt[] = 'mln.mln_published = \'1\'';
		}
		$columns = array();
		$columns[] = 'mln.mln_id';
		$columns[] = 'mln.mln_name';
		$columns[] = 'mln.mln_date_start';
		$columns[] = 'mln.mln_date_due';
		$columns[] = 'stu.stu_ordering';
		$columns[] = 'tsk_completion';
		$columns[] = 'mln.mln_priority';
		$col = $this->my_library->build_columns($data['ref_filter'], $columns, 'mln.mln_id', 'DESC');
		$results = $this->get_total($flt);
		if($this->router->class == 'milestones') {
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
		$data['dropdown_mln_owner'] = $this->dropdown_mln_owner();
		return $this->load->view('milestones/milestones_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(mln.mln_id) AS count FROM '.$this->db->dbprefix('milestones').' AS mln LEFT JOIN '.$this->db->dbprefix('statuses').' AS stu ON stu.stu_id = mln.mln_status WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT stu.stu_isclosed, mbr.mbr_name, mln.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.mln_id = mln.mln_id)  AS tsk_completion FROM '.$this->db->dbprefix('milestones').' AS mln LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = mln.mln_owner LEFT JOIN '.$this->db->dbprefix('statuses').' AS stu ON stu.stu_id = mln.mln_status WHERE '.implode(' AND ', $flt).' GROUP BY mln.mln_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($mln_id) {
		$row = $this->db->query('SELECT stu.stu_isclosed, mbr.mbr_name, mln.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.mln_id = mln.mln_id)  AS tsk_completion FROM '.$this->db->dbprefix('milestones').' AS mln LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = mln.mln_owner LEFT JOIN '.$this->db->dbprefix('statuses').' AS stu ON stu.stu_id = mln.mln_status WHERE mln.mln_id = ? GROUP BY mln.mln_id', array($mln_id))->row();
		if($row) {
			if($this->auth_library->permission('milestones/delete/any')) {
				$row->action_delete = true;
			} else if($this->auth_library->permission('milestones/delete/ifowner') && $row->mln_owner == $this->phpcollab_member->mbr_id) {
				$row->action_delete = true;
			} else {
				$row->action_delete = false;
			}
		}
		return $row;
	}
	function dropdown_mln_owner() {
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
