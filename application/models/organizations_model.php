<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class organizations_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list() {
		$filters = array();
		$filters[$this->router->class.'_organizations_org_owner'] = array('org.org_owner', 'equal');
		$filters[$this->router->class.'_organizations_org_name'] = array('org.org_name', 'like');
		$filters[$this->router->class.'_organizations_org_authorized'] = array('org.org_authorized', 'equal');
		$flt = $this->my_library->build_filters($filters);
		if($this->auth_library->permission('organizations/read/any')) {

		} else if($this->auth_library->permission('organizations/read/ifowner') && $this->auth_library->permission('organizations/read/ifmember')) {
			$flt[] = '( org.org_owner = \''.intval($this->phpcollab_member->mbr_id).'\' OR mbr_org.mbr_id IS NOT NULL )';

		} else if($this->auth_library->permission('organizations/read/ifowner')) {
			$flt[] = 'org.org_owner = \''.intval($this->phpcollab_member->mbr_id).'\'';

		} else if($this->auth_library->permission('organizations/read/ifmember')) {
			$flt[] = 'mbr_org.mbr_id IS NOT NULL';

		} else {
			return '';
		}
		$columns = array();
		$columns[] = 'org.org_id';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'org.org_name';
		$columns[] = 'org.org_authorized';
		$columns[] = 'count_members';
		$columns[] = 'count_projects';
		$col = $this->my_library->build_columns($this->router->class.'_organizations', $columns, 'org.org_name', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_organizations');
		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_organizations');
		$data['dropdown_org_owner'] = $this->dropdown_org_owner();
		return $this->load->view('organizations/organizations_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(DISTINCT(org.org_id)) AS count FROM '.$this->db->dbprefix('organizations').' AS org LEFT JOIN '.$this->db->dbprefix('members').' AS mbr_org ON mbr_org.org_id = org.org_id AND mbr_org.mbr_authorized = ? AND mbr_org.mbr_id = ? WHERE '.implode(' AND ', $flt), array(1, $this->phpcollab_member->mbr_id));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT IF(mbr_org.mbr_id IS NOT NULL, 1, 0) AS ismember, mbr.mbr_name, org.*, (SELECT COUNT(mbr.mbr_id) FROM '.$this->db->dbprefix('members').' AS mbr WHERE mbr.org_id = org.org_id) AS count_members, (SELECT COUNT(prj.prj_id) FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = org.org_id) AS count_projects FROM '.$this->db->dbprefix('organizations').' AS org LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = org.org_owner LEFT JOIN '.$this->db->dbprefix('members').' AS mbr_org ON mbr_org.org_id = org.org_id AND mbr_org.mbr_authorized = ? AND mbr_org.mbr_id = ? WHERE '.implode(' AND ', $flt).' GROUP BY org.org_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num, array(1, $this->phpcollab_member->mbr_id));
		return $query->result();
	}
	function get_row($org_id) {
		$query = $this->db->query('SELECT IF(mbr_org.mbr_id IS NOT NULL, 1, 0) AS ismember, mbr.mbr_name, org.*, (SELECT ROUND( (SUM(tsk.tsk_completion) * 100) / (COUNT(tsk.tsk_id) * 100) ) FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = org.org_id)) AS tsk_completion FROM '.$this->db->dbprefix('organizations').' AS org LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = org.org_owner LEFT JOIN '.$this->db->dbprefix('members').' AS mbr_org ON mbr_org.org_id = org.org_id AND mbr_org.mbr_authorized = ? AND mbr_org.mbr_id = ? WHERE org.org_id = ? GROUP BY org.org_id', array(1, $this->phpcollab_member->mbr_id, $org_id));
		return $query->row();
	}
	function dropdown_org_owner() {
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
