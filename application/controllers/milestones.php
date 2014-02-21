<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class milestones extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('milestones_model');
		$this->load->model('tasks_model');

		$this->storage_table = 'milestones';
		$this->storage_fields = array();
	}
	public function index($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($this->lang->line('milestones'));
			$content = $this->milestones_model->get_index_list($data['prj']);
			$this->my_library->set_zone('content', $content);
		} else {
			redirect($this->my_url);
		}
	}
	public function create($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($this->lang->line('milestones'));
			$this->load->library('form_validation');
			$data['dropdown_mln_owner'] = $this->milestones_model->dropdown_mln_owner();
			$this->form_validation->set_rules('mln_owner', 'lang:mln_owner', 'required|numeric');
			$this->form_validation->set_rules('mln_name', 'lang:mln_name', 'required|max_length[255]');
			$this->form_validation->set_rules('mln_description', 'lang:mln_description', '');
			$this->form_validation->set_rules('mln_date_start', 'lang:mln_date_start', 'required');
			$this->form_validation->set_rules('mln_date_due', 'lang:mln_date_due', '');
			$this->form_validation->set_rules('mln_date_complete', 'lang:mln_date_complete', '');
			$this->form_validation->set_rules('mln_status', 'lang:mln_status', 'required|numeric');
			$this->form_validation->set_rules('mln_priority', 'lang:mln_priority', 'required|numeric');
			$this->form_validation->set_rules('mln_comments', 'lang:mln_comments', '');
			$this->form_validation->set_rules('mln_published', 'lang:mln_published', 'numeric');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('milestones/milestones_create', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				if(count($this->storage_fields) > 0) {
					foreach($this->storage_fields as $field) {
						$config = array();
						$config['allowed_types'] = 'gif|jpg|png';
						$config['encrypt_name'] = true;
						$config['upload_path'] = './storage/'.$this->storage_table.'/'.$field;
						$this->upload->initialize($config);
						if($this->upload->do_upload($field)) {
							$upload = $this->upload->data();
							$this->db->set($field, $upload['file_name']);
						}
					}
				}
				$this->db->set('prj_id', $prj_id);
				$this->db->set('mln_owner', $this->input->post('mln_owner'));
				$this->db->set('mln_name', $this->input->post('mln_name'));
				$this->db->set('mln_description', $this->input->post('mln_description'));
				$this->db->set('mln_date_start', $this->input->post('mln_date_start'));
				$this->db->set('mln_date_due', $this->input->post('mln_date_due'));
				$this->db->set('mln_date_complete', $this->input->post('mln_date_complete'));
				$this->db->set('mln_status', $this->input->post('mln_status'));
				$this->db->set('mln_priority', $this->input->post('mln_priority'));
				$this->db->set('mln_comments', $this->input->post('mln_comments'));
				$this->db->set('mln_published', checkbox2database($this->input->post('mln_published')));
				$this->db->set('mln_datecreated', date('Y-m-d H:i:s'));
				$this->db->insert('milestones');
				$mln_id = $this->db->insert_id();
				$this->read($mln_id);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function read($mln_id) {
		$data = array();
		$data['row'] = $this->milestones_model->get_row($mln_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('milestones').' / '.$data['row']->mln_name);
				$content = $this->load->view('milestones/milestones_read', $data, TRUE);
				$content .= $this->tasks_model->get_index_list($data['prj'], $data['row']);
				$this->my_library->set_zone('content', $content);
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function update($mln_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->milestones_model->get_row($mln_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('milestones').' / '.$data['row']->mln_name);
				$data['dropdown_mln_owner'] = $this->milestones_model->dropdown_mln_owner();
				$this->form_validation->set_rules('mln_owner', 'lang:mln_owner', 'required|numeric');
				$this->form_validation->set_rules('mln_name', 'lang:mln_name', 'required|max_length[255]');
				$this->form_validation->set_rules('mln_description', 'lang:mln_description', '');
				$this->form_validation->set_rules('mln_date_start', 'lang:mln_date_start', 'required');
				$this->form_validation->set_rules('mln_date_due', 'lang:mln_date_due', '');
				$this->form_validation->set_rules('mln_date_complete', 'lang:mln_date_complete', '');
				$this->form_validation->set_rules('mln_status', 'lang:mln_status', 'required|numeric');
				$this->form_validation->set_rules('mln_priority', 'lang:mln_priority', 'required|numeric');
				$this->form_validation->set_rules('mln_comments', 'lang:mln_comments', '');
				$this->form_validation->set_rules('mln_published', 'lang:mln_published', 'numeric');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('milestones/milestones_update', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					if(count($this->storage_fields) > 0) {
						foreach($this->storage_fields as $field) {
							$config = array();
							$config['allowed_types'] = 'gif|jpg|png';
							$config['encrypt_name'] = true;
							$config['upload_path'] = './storage/'.$this->storage_table.'/'.$field;
							$this->upload->initialize($config);
							if($this->upload->do_upload($field)) {
								if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
									unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
								}
								$upload = $this->upload->data();
								$this->db->set($field, $upload['file_name']);
							}
						}
					}
					$this->db->set('mln_owner', $this->input->post('mln_owner'));
					$this->db->set('mln_name', $this->input->post('mln_name'));
					$this->db->set('mln_description', $this->input->post('mln_description'));
					$this->db->set('mln_date_start', $this->input->post('mln_date_start'));
					$this->db->set('mln_date_due', $this->input->post('mln_date_due'));
					$this->db->set('mln_date_complete', $this->input->post('mln_date_complete'));
					$this->db->set('mln_status', $this->input->post('mln_status'));
					$this->db->set('mln_priority', $this->input->post('mln_priority'));
					$this->db->set('mln_comments', $this->input->post('mln_comments'));
					$this->db->set('mln_published', checkbox2database($this->input->post('mln_published')));
					$this->db->set('mln_datemodified', date('Y-m-d H:i:s'));
					$this->db->where('mln_id', $mln_id);
					$this->db->update('milestones');
					$this->read($mln_id);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function delete($mln_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->milestones_model->get_row($mln_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('milestones').' / '.$data['row']->mln_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('milestones/milestones_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					if(count($this->storage_fields) > 0) {
						foreach($this->storage_fields as $field) {
							if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
								unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
							}
						}
					}
					$this->db->where('mln_id', $mln_id);
					$this->db->delete('milestones');
					$this->index();
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
}
