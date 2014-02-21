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
