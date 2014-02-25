<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class projects_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($org = false) {
		$data = array();
		$filters = array();
		$filters[$this->router->class.'_projects_prj_name'] = array('prj.prj_name', 'like');
		$filters[$this->router->class.'_projects_stu_isclosed'] = array('stu.stu_isclosed', 'equal');
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
		if($this->auth_library->permission('projects/read/onlypublished')) {
			$flt[] = 'prj.prj_published = \'1\'';
		}
		$columns = array();
		$columns[] = 'prj.prj_id';
		if($this->router->class != 'organizations') {
			$columns[] = 'org.org_name';
		}
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'prj.prj_name';
		$columns[] = 'prj.prj_date_start';
		$columns[] = 'prj.prj_date_due';
		$columns[] = 'stu.stu_ordering';
		$columns[] = 'prj.prj_priority';
		$columns[] = 'tsk_completion';
		$columns[] = 'count_tasks';
		$col = $this->my_library->build_columns($this->router->class.'_projects', $columns, 'prj.prj_name', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_projects');
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
		$query = $this->db->query('SELECT stu.stu_isclosed, IF(prj_mbr.prj_mbr_id IS NOT NULL, 1, 0) AS ismember, org.org_name, mbr.mbr_name, prj.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = prj.prj_id)  AS tsk_completion, (SELECT COUNT(tsk.tsk_id) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = prj.prj_id) AS count_tasks FROM '.$this->db->dbprefix('projects').' AS prj LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = prj.org_id LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj.prj_owner LEFT JOIN '.$this->db->dbprefix('statuses').' AS stu ON stu.stu_id = prj.prj_status LEFT JOIN '.$this->db->dbprefix('projects_members').' AS prj_mbr ON prj_mbr.prj_id = prj.prj_id AND prj_mbr.prj_mbr_authorized = ? AND prj_mbr.mbr_id = ? WHERE '.implode(' AND ', $flt).' GROUP BY prj.prj_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num, array(1, $this->phpcollab_member->mbr_id));
		return $query->result();
	}
	function get_row($prj_id) {
		$query = $this->db->query('SELECT stu.stu_isclosed, IF(prj_mbr.prj_mbr_id IS NOT NULL, 1, 0) AS ismember, org.org_name, mbr.mbr_name, prj.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = prj.prj_id)  AS tsk_completion FROM '.$this->db->dbprefix('projects').' AS prj LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = prj.org_id LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj.prj_owner LEFT JOIN '.$this->db->dbprefix('statuses').' AS stu ON stu.stu_id = prj.prj_status LEFT JOIN '.$this->db->dbprefix('projects_members').' AS prj_mbr ON prj_mbr.prj_id = prj.prj_id AND prj_mbr.prj_mbr_authorized = ? AND prj_mbr.mbr_id = ? WHERE prj.prj_id = ? GROUP BY prj.prj_id', array(1, $this->phpcollab_member->mbr_id, $prj_id));
		return $query->row();
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
