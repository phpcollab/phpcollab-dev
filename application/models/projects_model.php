<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class projects_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($org = false) {
		$data = array();
		$filters = array();
		$filters[$this->router->class.'_projects_prj_name'] = array('prj.prj_name', 'like');
		$filters[$this->router->class.'_projects_prj_overdue'] = array('prj_overdue', 'prj_overdue');
		if($this->router->class != 'home') {
			$filters[$this->router->class.'_projects_stu_isclosed'] = array('stu.stu_isclosed', 'equal');
		}
		$filters[$this->router->class.'_projects_prj_status'] = array('prj.prj_status', 'equal');
		$filters[$this->router->class.'_projects_prj_priority'] = array('prj.prj_priority', 'equal');
		$flt = $this->my_library->build_filters($filters);
		if($org) {
			$data['org'] = $org;
			$flt[] = 'prj.org_id = \''.$org->org_id.'\'';
		}
		if($this->auth_library->permission('projects/read/any')) {

		} else if($this->auth_library->permission('projects/read/ifowner') && $this->auth_library->permission('projects/read/ifmember')) {
			$flt[] = '( prj.prj_owner = \''.intval($this->phpcollab_member->mbr_id).'\' OR prj_mbr.prj_mbr_id IS NOT NULL )';

		} else if($this->auth_library->permission('projects/read/ifowner')) {
			$flt[] = 'prj.prj_owner = \''.intval($this->phpcollab_member->mbr_id).'\'';

		} else if($this->auth_library->permission('projects/read/ifmember')) {
			$flt[] = 'prj_mbr.prj_mbr_id IS NOT NULL';

		} else {
			return '';
		}
		if($this->router->class == 'home') {
			$flt[] = 'prj_mbr.prj_mbr_id IS NOT NULL';
			$flt[] = 'stu.stu_isclosed = \'0\'';
		}
		if($this->auth_library->permission('projects/read/onlypublished')) {
			$flt[] = 'prj.prj_published = \'1\'';
		}
		$columns = array();
		$columns[] = 'prj.prj_id';
		$columns[] = 'prj.prj_name';
		if($this->router->class != 'organizations') {
			$columns[] = 'org.org_name';
		}
		$columns[] = 'prj.prj_date_start';
		$columns[] = 'prj.prj_date_due';
		$columns[] = 'stu.stu_ordering';
		$columns[] = 'tsk_completion';
		$columns[] = 'prj.prj_priority';
		$col = $this->my_library->build_columns($this->router->class.'_projects', $columns, 'prj.prj_id', 'DESC');
		$results = $this->get_total($flt);
		if($this->router->class == 'projects') {
			$limit = 30;
		} else {
			$limit = 10;
		}
		$build_pagination = $this->my_library->build_pagination($results->count, $limit, $this->router->class.'_projects');
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_projects');
		$data['dropdown_org_id'] = $this->dropdown_org_id();
		$data['dropdown_prj_owner'] = $this->dropdown_prj_owner();
		return $this->load->view('projects/projects_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(prj.prj_id) AS count FROM '.$this->db->dbprefix('projects').' AS prj LEFT JOIN '.$this->db->dbprefix('statuses').' AS stu ON stu.stu_id = prj.prj_status LEFT JOIN '.$this->db->dbprefix('projects_members').' AS prj_mbr ON prj_mbr.prj_id = prj.prj_id AND prj_mbr.prj_mbr_authorized = ? AND prj_mbr.mbr_id = ? WHERE '.implode(' AND ', $flt), array(1, $this->phpcollab_member->mbr_id));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT IF(prj.prj_date_due IS NOT NULL AND prj.prj_date_due <= ? AND stu.stu_isclosed = ?, 1, 0) AS prj_overdue, stu.stu_isclosed, IF(prj_mbr.prj_mbr_id IS NOT NULL, 1, 0) AS ismember, org.org_name, mbr.mbr_name, prj.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = prj.prj_id)  AS tsk_completion FROM '.$this->db->dbprefix('projects').' AS prj LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = prj.org_id LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj.prj_owner LEFT JOIN '.$this->db->dbprefix('statuses').' AS stu ON stu.stu_id = prj.prj_status LEFT JOIN '.$this->db->dbprefix('projects_members').' AS prj_mbr ON prj_mbr.prj_id = prj.prj_id AND prj_mbr.prj_mbr_authorized = ? AND prj_mbr.mbr_id = ? WHERE '.implode(' AND ', $flt).' GROUP BY prj.prj_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num, array(date('Y-m-d'), 0, 1, $this->phpcollab_member->mbr_id));
		return $query->result();
	}
	function get_row($prj_id) {
		$row = $this->db->query('SELECT IF(prj.prj_date_due IS NOT NULL AND prj.prj_date_due <= ? AND stu.stu_isclosed = ?, 1, 0) AS prj_overdue, stu.stu_isclosed, IF(prj_mbr.prj_mbr_id IS NOT NULL, 1, 0) AS ismember, org.org_name, mbr.mbr_name, prj.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = prj.prj_id)  AS tsk_completion FROM '.$this->db->dbprefix('projects').' AS prj LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = prj.org_id LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj.prj_owner LEFT JOIN '.$this->db->dbprefix('statuses').' AS stu ON stu.stu_id = prj.prj_status LEFT JOIN '.$this->db->dbprefix('projects_members').' AS prj_mbr ON prj_mbr.prj_id = prj.prj_id AND prj_mbr.prj_mbr_authorized = ? AND prj_mbr.mbr_id = ? WHERE prj.prj_id = ? GROUP BY prj.prj_id', array(date('Y-m-d'), 0, 1, $this->phpcollab_member->mbr_id, $prj_id))->row();
		if($row) {
			if($this->auth_library->permission('projects/read/any')) {
				$row->action_read = true;
			} else if($this->auth_library->permission('projects/read/ifowner') && $row->prj_owner == $this->phpcollab_member->mbr_id) {
				$row->action_read = true;
			} else if($this->auth_library->permission('projects/read/ifmember') && $row->ismember == 1) {
				$row->action_read = true;
			} else {
				$row->action_read = false;
			}
			if($this->auth_library->permission('projects/update/any')) {
				$row->action_update = true;
			} else if($this->auth_library->permission('projects/update/ifowner') && $row->prj_owner == $this->phpcollab_member->mbr_id) {
				$row->action_update = true;
			} else if($this->auth_library->permission('projects/update/ifmember') && $row->ismember == 1) {
				$row->action_update = true;
			} else {
				$row->action_update = false;
			}
			if($this->auth_library->permission('projects/delete/any')) {
				$row->action_delete = true;
			} else if($this->auth_library->permission('projects/delete/ifowner') && $row->prj_owner == $this->phpcollab_member->mbr_id) {
				$row->action_delete = true;
			} else {
				$row->action_delete = false;
			}

			if($this->auth_library->permission('projects_members/read/any')) {
				$row->action_read_team = true;
			} else if($this->auth_library->permission('projects_members/read/ifowner') && $row->prj_owner == $this->phpcollab_member->mbr_id) {
				$row->action_read_team = true;
			} else if($this->auth_library->permission('projects_members/read/ifmember') && $row->ismember == 1) {
				$row->action_read_team = true;
			} else {
				$row->action_read_team = false;
			}

			if($this->auth_library->permission('projects_members/manage/any')) {
				$row->action_create_team = true;
				$row->action_update_team = true;
				$row->action_delete_team = true;
			} else if($this->auth_library->permission('projects_members/manage/ifowner') && $row->prj_owner == $this->phpcollab_member->mbr_id) {
				$row->action_create_team = true;
				$row->action_update_team = true;
				$row->action_delete_team = true;
			} else {
				$row->action_create_team = false;
				$row->action_update_team = false;
				$row->action_delete_team = false;
			}

		}
		return $row;
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
