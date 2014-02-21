<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _configuration_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(cfg.cfg_id) AS count FROM '.$this->db->dbprefix('_configuration').' AS cfg WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT cfg.* FROM '.$this->db->dbprefix('_configuration').' AS cfg WHERE '.implode(' AND ', $flt).' GROUP BY cfg.cfg_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($cfg_id) {
		$query = $this->db->query('SELECT cfg.* FROM '.$this->db->dbprefix('_configuration').' AS cfg WHERE cfg.cfg_id = ? GROUP BY cfg.cfg_id', array($cfg_id));
		return $query->row();
	}
}
