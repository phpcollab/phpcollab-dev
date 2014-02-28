<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class roles_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list() {
		$filters = array();
		$filters[$this->router->class.'_roles_rol_code'] = array('rol.rol_code', 'like');
		$flt = $this->my_library->build_filters($filters);
		$columns = array();
		$columns[] = 'rol.rol_id';
		$columns[] = 'rol.rol_code';
		$columns[] = 'rol.rol_datecreated';
		$col = $this->my_library->build_columns($this->router->class.'_roles', $columns, 'rol.rol_code', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_roles');
		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_roles');
		return $this->load->view('roles/roles_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(rol.rol_id) AS count FROM '.$this->db->dbprefix('roles').' AS rol WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT rol.* FROM '.$this->db->dbprefix('roles').' AS rol WHERE '.implode(' AND ', $flt).' GROUP BY rol.rol_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($rol_id) {
		$query = $this->db->query('SELECT rol.* FROM '.$this->db->dbprefix('roles').' AS rol WHERE rol.rol_id = ? GROUP BY rol.rol_id', array($rol_id));
		return $query->row();
	}
}
