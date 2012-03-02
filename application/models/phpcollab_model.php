<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class phpcollab_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_projects_count($flt) {
        $query = $this->db->query('SELECT COUNT(pro.pro_id) AS count FROM '.$this->db->dbprefix('projects').' AS pro WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_projects_limit($flt, $num, $offset) {
        $query = $this->db->query('SELECT pro.pro_id, pro.pro_name FROM '.$this->db->dbprefix('projects').' AS pro WHERE '.implode(' AND ', $flt).' GROUP BY pro.pro_id ORDER BY pro.pro_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_project($pro_id) {
        $query = $this->db->query('SELECT pro.* FROM '.$this->db->dbprefix('projects').' AS pro WHERE pro.pro_id = ? GROUP BY pro.pro_id', array($pro_id));
        return $query->row();
    }
}
