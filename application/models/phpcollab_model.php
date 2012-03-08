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
        $query = $this->db->query('SELECT COUNT(pro.id) AS count FROM '.$this->db->dbprefix('projects').' AS pro WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_projects_limit($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT pro.id, pro.name FROM '.$this->db->dbprefix('projects').' AS pro WHERE '.implode(' AND ', $flt).' GROUP BY pro.id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_project($id) {
        $query = $this->db->query('SELECT pro.* FROM '.$this->db->dbprefix('projects').' AS pro WHERE pro.id = ? GROUP BY pro.id', array($id));
        return $query->row();
    }
    function get_organizations_count($flt) {
        $query = $this->db->query('SELECT COUNT(org.id) AS count FROM '.$this->db->dbprefix('organizations').' AS org WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_organizations_limit($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT org.id, org.name, COUNT(pro.id) AS count_projects FROM '.$this->db->dbprefix('organizations').' AS org LEFT JOIN '.$this->db->dbprefix('projects').' AS pro ON pro.organization = org.id WHERE '.implode(' AND ', $flt).' GROUP BY org.id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_organization($id) {
        $query = $this->db->query('SELECT org.* FROM '.$this->db->dbprefix('organizations').' AS org WHERE org.id = ? GROUP BY org.id', array($id));
        return $query->row();
    }
    function get_tasks_count($flt) {
        $query = $this->db->query('SELECT COUNT(tsk.id) AS count FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_tasks_limit($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT tsk.id, tsk.name FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE '.implode(' AND ', $flt).' GROUP BY tsk.id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_task($id) {
        $query = $this->db->query('SELECT tsk.* FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.id = ? GROUP BY tsk.id', array($id));
        return $query->row();
    }
    function select_organization() {
		$select_organization = array();
		$select_organization[''] = $this->lang->line('none');
		$this->db->cache_on();
        $query = $this->db->query('SELECT org.id, org.name, SUBSTRING(org.name, 1, 1) AS optgroup FROM '.$this->db->dbprefix('organizations').' AS org WHERE org.id != \'1\' GROUP BY org.id ORDER BY org.name ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				if(isset($select_organization[$row->optgroup]) == 0) {
					$select_organization[$row->optgroup] = array();
				}
				$select_organization[$row->optgroup][$row->id] = $row->name;
			}
		}
		$this->db->cache_off();
        return $select_organization;
    }
    function select_project() {
		$select_project = array();
		$this->db->cache_on();
        $query = $this->db->query('SELECT pro.id, pro.name, SUBSTRING(pro.name, 1, 1) AS optgroup FROM '.$this->db->dbprefix('projects').' AS pro GROUP BY pro.id ORDER BY pro.name ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				if(isset($select_project[$row->optgroup]) == 0) {
					$select_project[$row->optgroup] = array();
				}
				$select_project[$row->optgroup][$row->id] = $row->name;
			}
		}
		$this->db->cache_off();
        return $select_project;
    }
}
