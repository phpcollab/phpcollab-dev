<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _database extends CI_Controller {
	public function index() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('database'));

		$query = $this->db->query('SHOW TABLE STATUS');
		$data = array();
		$data['rows'] = $query->result();
		$content = $this->load->view('_database/_database_index', $data, TRUE);
		$this->my_library->set_zone('content', $content);
	}
	public function show($table) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('database'));

		$query = $this->db->query('SHOW FULL COLUMNS FROM '.$table);
		if($query->num_rows() > 0) {
			$data = array();
			$data['table'] = $table;
			$data['rows'] = $query->result();
			$data['status'] = $this->db->query('SHOW TABLE STATUS WHERE name = ?', array($table))->row();
			$content = $this->load->view('_database/_database_show', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function optimize() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$query = $this->db->query('SHOW TABLE STATUS');
		foreach($query->result() as $row) {
			$this->db->query('OPTIMIZE TABLE '.$row->Name);
		}
		$this->index();
	}
}
