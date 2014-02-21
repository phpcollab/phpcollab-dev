<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class organizations_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list() {
		$filters = array();
		$filters[$this->router->class.'_organizations_org_owner'] = array('org.org_owner', 'like');
		$filters[$this->router->class.'_organizations_org_name'] = array('org.org_name', 'like');
		$filters[$this->router->class.'_organizations_org_authorized'] = array('org.org_authorized', 'like');
		$filters[$this->router->class.'_organizations_org_datecreated'] = array('org.org_datecreated', 'like');
		$flt = $this->my_library->build_filters($filters);
		$columns = array();
		$columns[] = 'org.org_id';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'org.org_name';
		$columns[] = 'org.org_authorized';
		$columns[] = 'tsk_completion';
		$columns[] = 'org.org_datecreated';
		$col = $this->my_library->build_columns($this->router->class.'_organizations', $columns, 'org.org_name', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_organizations');
		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_organizations');
		$data['dropdown_org_owner'] = $this->dropdown_org_owner();
		return $content = $this->load->view('organizations/organizations_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(org.org_id) AS count FROM '.$this->db->dbprefix('organizations').' AS org WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, org.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = org.org_id)) AS tsk_completion FROM '.$this->db->dbprefix('organizations').' AS org LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = org.org_owner WHERE '.implode(' AND ', $flt).' GROUP BY org.org_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($org_id) {
		$query = $this->db->query('SELECT mbr.mbr_name, org.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = org.org_id)) AS tsk_completion FROM '.$this->db->dbprefix('organizations').' AS org LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = org.org_owner WHERE org.org_id = ? GROUP BY org.org_id', array($org_id));
		return $query->row();
	}
	function dropdown_org_owner() {
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
