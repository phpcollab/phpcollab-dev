<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_languages() {
		$languages = array();
		$query = $this->db->query('SELECT lng.* FROM '.$this->db->dbprefix('_languages').' AS lng GROUP BY lng.lng_id');
		foreach($query->result() as $row) {
			if($row->lng_default == 1) {
				$language_default = $row->lng_code;
			}
			$languages[$row->lng_code] = $row->lng_name;
		}
		return array('languages' => $languages, 'language_default' => $language_default);
	}
	function get_statuses() {
		$this->statuses = array();
		$this->statuses_closed = array();
		$query = $this->db->query('SELECT stu.* FROM '.$this->db->dbprefix('statuses').' AS stu GROUP BY stu.stu_id');
		foreach($query->result() as $row) {
			$this->statuses[$row->stu_id] = $row->stu_name;
			if($row->stu_isclosed == 1) {
				$this->statuses_closed[] = $row->stu_id;
			}
		}
	}
	function status($stu_id) {
		if(isset($this->statuses[$stu_id]) == 1) {
			if(!in_array($stu_id, $this->statuses_closed)) {
				return '<strong>'.$this->statuses[$stu_id].'</strong>';
			} else {
				return $this->statuses[$stu_id];
			}
		} else {
			return '-';
		}
	}
	function get_priorities() {
		$this->priorities = array();
		$this->priorities[1] = $this->lang->line('priority_1');
		$this->priorities[2] = $this->lang->line('priority_2');
		$this->priorities[3] = $this->lang->line('priority_3');
		$this->priorities[4] = $this->lang->line('priority_4');
		$this->priorities[5] = $this->lang->line('priority_5');
	}
	function priority($pry_id) {
		if(isset($this->priorities[$pry_id]) == 1) {
			return $this->priorities[$pry_id];
		} else {
			return '-';
		}
	}
	function dropdown_status() {
		$select = array();
		$select[''] = '-';
		$query = $this->db->query('SELECT stu.* FROM '.$this->db->dbprefix('statuses').' AS stu GROUP BY stu.stu_id');
		foreach($query->result() as $row) {
			$select[$this->lang->line('stu_isclosed_'.$row->stu_isclosed)][$row->stu_id] = $row->stu_name;
		}
		return $select;
	}
	function dropdown_priority() {
		$select = array();
		$select[''] = '-';
		$select[1] = $this->lang->line('priority_1');
		$select[2] = $this->lang->line('priority_2');
		$select[3] = $this->lang->line('priority_3');
		$select[4] = $this->lang->line('priority_4');
		$select[5] = $this->lang->line('priority_5');
		return $select;
	}
	function dropdown_completion() {
		$dropdown_completion = array();
		for($i=0;$i<=100;$i=$i+10) {
			$dropdown_completion[$i] = $i;
		}
		return $dropdown_completion;
	}
	function dropdown_reply() {
		$select = array();
		$select[''] = '-';
		$select[1] = $this->lang->line('reply_1');
		$select[0] = $this->lang->line('reply_0');
		return $select;
	}
}
