<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class projects_members_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list($prj) {
		$data = array();
		$data['ref_filter'] = $this->router->class.'_projects_members_'.$prj->prj_id;
		$filters = array();
		$filters[$data['ref_filter'].'_mbr_name'] = array('mbr.mbr_name', 'like');
		$filters[$data['ref_filter'].'_mbr_email'] = array('mbr.mbr_email', 'like');
		$filters[$data['ref_filter'].'_mbr_authorized'] = array('prj_mbr.prj_mbr_authorized', 'equal');
		$flt = $this->my_library->build_filters($filters);
		$flt[] = 'prj_mbr.prj_id = \''.$prj->prj_id.'\'';
		$columns = array();
		$columns[] = 'prj_mbr.prj_mbr_id';
		$columns[] = 'org.org_name';
		$columns[] = 'mbr.mbr_name';
		$columns[] = 'prj_mbr.prj_mbr_authorized';
		$columns[] = 'prj_mbr.prj_mbr_published';
		$columns[] = 'roles';
		$columns[] = 'prj_mbr.prj_mbr_datecreated';
		$col = $this->my_library->build_columns($data['ref_filter'], $columns, 'prj_mbr.prj_mbr_id', 'ASC');
		$results = $this->get_total($flt);
		if($this->router->class == 'projects_members') {
			$limit = 30;
		} else {
			$limit = 10;
		}
		$build_pagination = $this->my_library->build_pagination($results->count, $limit, $data['ref_filter'].'');
		$data['prj'] = $prj;
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $data['ref_filter'].'');
		$data['dropdown_mbr_id'] = $this->dropdown_mbr_id();
		return $this->load->view('projects_members/projects_members_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(prj_mbr.prj_mbr_id) AS count FROM '.$this->db->dbprefix('projects_members').' AS prj_mbr LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj_mbr.mbr_id WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, org.org_name, prj_mbr.*, GROUP_CONCAT(DISTINCT rol.rol_code ORDER BY rol.rol_code ASC SEPARATOR \', \') AS roles FROM '.$this->db->dbprefix('projects_members').' AS prj_mbr LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj_mbr.mbr_id LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = mbr.org_id LEFT JOIN '.$this->db->dbprefix('members_roles').' AS mbr_rol ON mbr_rol.mbr_id = mbr.mbr_id LEFT JOIN '.$this->db->dbprefix('roles').' AS rol ON rol.rol_id = mbr_rol.rol_id WHERE '.implode(' AND ', $flt).' GROUP BY prj_mbr.prj_mbr_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($prj_mbr_id) {
		$query = $this->db->query('SELECT mbr.mbr_name, org.org_name, prj_mbr.*, GROUP_CONCAT(DISTINCT rol.rol_code ORDER BY rol.rol_code ASC SEPARATOR \', \') AS roles FROM '.$this->db->dbprefix('projects_members').' AS prj_mbr LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = prj_mbr.mbr_id LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = mbr.org_id LEFT JOIN '.$this->db->dbprefix('members_roles').' AS mbr_rol ON mbr_rol.mbr_id = mbr.mbr_id LEFT JOIN '.$this->db->dbprefix('roles').' AS rol ON rol.rol_id = mbr_rol.rol_id WHERE prj_mbr.prj_mbr_id = ? GROUP BY prj_mbr.prj_mbr_id', array($prj_mbr_id));
		return $query->row();
	}
	function dropdown_mbr_id($prj_id = false) {
		$select = array();
		$select[''] = '-';
		if($prj_id) {
			$query = $this->db->query('SELECT mbr.mbr_id AS field_key, org.org_name AS field_optgroup, mbr.mbr_name AS field_label FROM '.$this->db->dbprefix('members').' AS mbr LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = mbr.org_id WHERE mbr.mbr_id NOT IN(SELECT prj_mbr.mbr_id FROM '.$this->db->dbprefix('projects_members').' AS prj_mbr WHERE prj_mbr.prj_id = ?)GROUP BY mbr.mbr_id ORDER BY org.org_name ASC, mbr.mbr_name ASC', array($prj_id));
		} else {
			$query = $this->db->query('SELECT mbr.mbr_id AS field_key, org.org_name AS field_optgroup, mbr.mbr_name AS field_label FROM '.$this->db->dbprefix('members').' AS mbr LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = mbr.org_id GROUP BY mbr.mbr_id ORDER BY org.org_name ASC, mbr.mbr_name ASC');
		}
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select[$row->field_optgroup][$row->field_key] = $row->field_label;
			}
		}
		return $select;
	}
}
