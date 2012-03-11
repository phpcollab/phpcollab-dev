<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class phpcollab_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
	function login($user_name, $password) {
		$this->session->unset_userdata('id');
		$login = false;
        $query = $this->db->query('SELECT mbr.* FROM '.$this->db->dbprefix('members').' AS mbr WHERE mbr.login = ? GROUP BY mbr.id', array($user_name));
		if($query->num_rows() > 0) {
			$mbr = $query->row();
			$login = $this->password_check($password, $mbr->password);
			if($login == true) {
				$this->session->set_userdata('id', $mbr->id);
				$salt = substr($password, 0, 2); 
				$password = crypt($password, $salt);

				$this->db->set('login', $user_name);
				$this->db->set('password', $password);
				$this->db->set('ip', filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP));
				$this->db->set('session', $this->session->userdata('session_id'));
				$this->db->set('last_visite', date('Y-m-d H:i'));

				$query = $this->db->query('SELECT log.* FROM '.$this->db->dbprefix('logs').' AS log WHERE log.login = ? GROUP BY log.id', array($user_name));
				if($query->num_rows() > 0) {
					$this->db->set('compt', 'compt + 1', false);
					$this->db->where('login', $user_name);
					$this->db->update('logs');

				} else {
					$this->db->set('compt', 1);
					$this->db->insert('logs');
				} 
			}
		}
		return $login;
	}
    function password_check($input, $saved) {
		if($this->config->item('phpcollab_password') == 'MD5') {
			if(md5($input) == $saved) {
				return true;
			}
		}
		if($this->config->item('phpcollab_password') == 'CRYPT') {
			$salt = substr($saved, 0, 2);
			if(crypt($input, $salt) == $saved) {
				return true;
			}
		}
		if($this->config->item('phpcollab_password') == 'PLAIN') {
			if($input == $saved) {
				return true;
			}
		}
		return false;
	}
    function password_save($input) {
		if($this->config->item('phpcollab_password') == 'MD5') {
			return md5($input);
		}
		if($this->config->item('phpcollab_password') == 'CRYPT') {
			$salt = substr($input, 0, 2);
			return crypt($input, $salt);
		}
		if($this->config->item('phpcollab_password') == 'PLAIN') {
			return $input;
		}
	}
    function get_member($id) {
        $query = $this->db->query('SELECT mbr.* FROM '.$this->db->dbprefix('members').' AS mbr WHERE mbr.id = ? GROUP BY mbr.id', array($id));
        return $query->row();
    }
    function get_logs_count($flt) {
        $query = $this->db->query('SELECT COUNT(log.id) AS count FROM '.$this->db->dbprefix('logs').' AS log WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_logs_limit($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT log.* FROM '.$this->db->dbprefix('logs').' AS log WHERE '.implode(' AND ', $flt).' GROUP BY log.id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_projects_count($flt) {
        $query = $this->db->query('SELECT COUNT(pro.id) AS count FROM '.$this->db->dbprefix('projects').' AS pro WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_projects_limit($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT pro.id, pro.name, pro.priority, pro.organization, pro.status, org.id AS org_id, org.name AS org_name FROM '.$this->db->dbprefix('projects').' AS pro LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.id = pro.organization WHERE '.implode(' AND ', $flt).' GROUP BY pro.id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
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
        $query = $this->db->query('SELECT tsk.id, tsk.name, tsk.priority, tsk.status, tsk.due_date, tsk.published, tsk.completion * 10 AS completion_percent FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE '.implode(' AND ', $flt).' GROUP BY tsk.id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_task($id) {
        $query = $this->db->query('SELECT tsk.*, tsk.completion * 10 AS completion_percent FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.id = ? GROUP BY tsk.id', array($id));
        return $query->row();
    }
    function get_topics_count($flt) {
        $query = $this->db->query('SELECT COUNT(tpc.id) AS count FROM '.$this->db->dbprefix('topics').' AS tpc WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_topics_limit($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT tpc.id, tpc.subject, tpc.status, tpc.posts, tpc.last_post FROM '.$this->db->dbprefix('topics').' AS tpc WHERE '.implode(' AND ', $flt).' GROUP BY tpc.id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_topic($id) {
        $query = $this->db->query('SELECT tpc.* FROM '.$this->db->dbprefix('topics').' AS tpc WHERE tpc.id = ? GROUP BY tpc.id', array($id));
        return $query->row();
    }
	function select_priority() {
		$select_priority = array();
		for($i=0;$i<=5;$i++) {
			$select_priority[$i] = $this->lang->line('priority_'.$i);
		}
        return $select_priority;
    }
    function select_status() {
		$select_status = array();
		for($i=0;$i<=4;$i++) {
			$select_status[$i] = $this->lang->line('status_'.$i);
		}
        return $select_status;
    }
    function select_completion() {
		$select_completion = array();
		for($i=0;$i<=10;$i++) {
			$percent = $i * 10;
			$select_completion[$i] = $percent.' %';
		}
        return $select_completion;
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
