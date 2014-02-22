<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function save_log($type, $reference, $row) {
		$diff = array();
		foreach($row as $k => $v) {
			if($this->input->post($k) != '' && $this->input->post($k) != $v && $k != 'mbr_password') {
				$diff[$k] = array('old' => $v, 'new' => $this->input->post($k));
			}
		}
		if(count($diff) > 0 || $this->input->post('log_comments') != '') {
			$this->db->set('mbr_id', $this->phpcollab_member->mbr_id);
			$this->db->set('log_type', $type);
			$this->db->set('log_reference', $reference);
			$this->db->set('log_comments', $this->input->post('log_comments'));
			$this->db->set('log_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('logs');
			$log_id = $this->db->insert_id();

			if(count($diff) > 0) {
				foreach($diff as $k => $v) {
					$this->db->set('log_id', $log_id);
					$this->db->set('log_dls_field', $k);
					$this->db->set('log_dls_old', $v['old']);
					$this->db->set('log_dls_new', $v['new']);
					$this->db->insert('logs_details');
				}
			}
		}
	}
	function get_logs($type, $reference) {
		$data = array();
		$flt = array();
		$flt[] = 'log.log_type = \''.$type.'\'';
		$flt[] = 'log.log_reference = \''.$reference.'\'';
		$results = $this->get_total_logs($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 10, $type.'_'.$reference);
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows_logs($flt, $build_pagination['limit'], $build_pagination['start'], $type.'_'.$reference);
		return $content = $this->load->view('logs/logs_index', $data, TRUE);
	}
	function get_total_logs($flt) {
		$query = $this->db->query('SELECT COUNT(log.log_id) AS count FROM '.$this->db->dbprefix('logs').' AS log WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows_logs($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT mbr.mbr_name, log.* FROM '.$this->db->dbprefix('logs').' AS log LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = log.mbr_id WHERE '.implode(' AND ', $flt).' GROUP BY log.log_id ORDER BY log.log_datecreated DESC LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_log_details($log_id) {
		$fields = array();
		$query = $this->db->query('SELECT log_dls.* FROM '.$this->db->dbprefix('logs_details').' AS log_dls WHERE log_dls.log_id = ? GROUP BY log_dls.log_dls_id', array($log_id));
		foreach($query->result() as $row) {
			$field = $row->log_dls_field;
			$old = $row->log_dls_old;
			$new = $row->log_dls_new;

			if(strstr($field, 'priority')) {
				if($old != '') {
					$old = '<span class="color_percent priority_'.$old.'" style="text-decoration:line-through;width:100%;">'.$this->priority($old).'</span>';
				}
				if($new != '') {
					$new = '<span class="color_percent priority_'.$new.'" style="text-decoration:line-through;width:100%;">'.$this->priority($new).'</span>';
				}

			} else if(strstr($field, 'status')) {
				if($old != '') {
					$old = $this->status($old);
				}
				if($new != '') {
					$new = $this->status($new);
				}

			} else if(strstr($field, 'published') || strstr($field, 'authorized')) {
				if($old != '') {
					$old = $this->lang->line('reply_'.$old);
				}
				if($new != '') {
					$new = $this->lang->line('reply_'.$new);
				}

			} else if(strstr($field, 'completion')) {
				if($old != '') {
					$old = '<span class="color_percent" style="text-decoration:line-through;width:'.intval($old).'%;">'.intval($old).'%</span>';
				}
				if($new != '') {
					$new = '<span class="color_percent" style="text-decoration:line-through;width:'.intval($new).'%;">'.intval($new).'%</span>';
				}
			}

			if($old == '') {
				$old = '-';
			}
			if($new == '') {
				$new = '-';
			}
			$fields[$field] = array('old' => $old, 'new' => $new);
		}
		return $fields;
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
