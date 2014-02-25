<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class members_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($org = false) {
		$data = array();
		$filters = array();
		if($this->router->class != 'organizations') {
			$filters[$this->router->class.'_members_org_id'] = array('mbr.org_id', 'equal');
		}
		$filters[$this->router->class.'_members_mbr_name'] = array('mbr.mbr_name', 'like');
		$filters[$this->router->class.'_members_mbr_email'] = array('mbr.mbr_email', 'like');
		$filters[$this->router->class.'_members_mbr_authorized'] = array('mbr.mbr_authorized', 'equal');
		$flt = $this->my_library->build_filters($filters);
		if($org) {
			$data['org'] = $org;
			$flt[] = 'mbr.org_id = \''.$org->org_id.'\'';
		}
		$columns = array();
		$columns[] = 'mbr.mbr_id';
		$columns[] = 'mbr.mbr_name';
		if($this->router->class != 'organizations') {
			$columns[] = 'org.org_name';
		}
		$columns[] = 'mbr.mbr_email';
		$columns[] = 'mbr.mbr_authorized';
		$columns[] = 'roles';
		$columns[] = 'mbr.mbr_datecreated';
		$col = $this->my_library->build_columns($this->router->class.'_members', $columns, 'mbr.mbr_id', 'DESC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_members');
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_members');
		$data['dropdown_org_id'] = $this->dropdown_org_id();
		return $this->load->view('members/members_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(mbr.mbr_id) AS count FROM '.$this->db->dbprefix('members').' AS mbr WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT org.org_name, mbr.*, GROUP_CONCAT(DISTINCT rol.rol_code ORDER BY rol.rol_code ASC SEPARATOR \', \') AS roles FROM '.$this->db->dbprefix('members').' AS mbr LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = mbr.org_id LEFT JOIN '.$this->db->dbprefix('members_roles').' AS mbr_rol ON mbr_rol.mbr_id = mbr.mbr_id LEFT JOIN '.$this->db->dbprefix('roles').' AS rol ON rol.rol_id = mbr_rol.rol_id WHERE '.implode(' AND ', $flt).' GROUP BY mbr.mbr_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($mbr_id) {
		$query = $this->db->query('SELECT org.org_name, mbr.*, GROUP_CONCAT(DISTINCT rol.rol_code ORDER BY rol.rol_code ASC SEPARATOR \', \') AS roles FROM '.$this->db->dbprefix('members').' AS mbr LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = mbr.org_id LEFT JOIN '.$this->db->dbprefix('members_roles').' AS mbr_rol ON mbr_rol.mbr_id = mbr.mbr_id LEFT JOIN '.$this->db->dbprefix('roles').' AS rol ON rol.rol_id = mbr_rol.rol_id WHERE mbr.mbr_id = ? GROUP BY mbr.mbr_id', array($mbr_id));
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
}
