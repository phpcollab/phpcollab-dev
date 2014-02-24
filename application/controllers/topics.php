<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class topics extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('topics_model');
		$this->load->model('posts_model');

		$this->storage_table = 'topics';
		$this->storage_fields = array();
	}
	public function index($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($this->lang->line('topics'));
			$content = $this->topics_model->get_index_list($data['prj']);
			$this->my_library->set_zone('content', $content);
		} else {
			redirect($this->my_url);
		}
	}
	public function create($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($this->lang->line('topics'));
			$this->load->library('form_validation');
			$data['dropdown_tcs_owner'] = $this->topics_model->dropdown_tcs_owner();
			$this->form_validation->set_rules('tcs_owner', 'lang:tcs_owner', 'required|numeric');
			$this->form_validation->set_rules('tcs_name', 'lang:tcs_name', 'required|max_length[255]');
			$this->form_validation->set_rules('pst_description', 'lang:pst_description', 'required');
			$this->form_validation->set_rules('tcs_status', 'lang:tcs_status', 'required|numeric');
			$this->form_validation->set_rules('tcs_priority', 'lang:tcs_priority', 'required|numeric');
			$this->form_validation->set_rules('tcs_published', 'lang:tcs_published', 'numeric');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('topics/topics_create', $data, TRUE);
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
				$this->db->set('tcs_owner', $this->input->post('tcs_owner'));
				$this->db->set('tcs_name', $this->input->post('tcs_name'));
				$this->db->set('tcs_status', $this->input->post('tcs_status'));
				$this->db->set('tcs_priority', $this->input->post('tcs_priority'));
				$this->db->set('tcs_published', checkbox2database($this->input->post('tcs_published')));
				$this->db->set('tcs_datecreated', date('Y-m-d H:i:s'));
				$this->db->insert('topics');
				$tcs_id = $this->db->insert_id();

				$this->db->set('tcs_id', $tcs_id);
				$this->db->set('pst_owner', $this->phpcollab_member->mbr_id);
				$this->db->set('pst_description', $this->input->post('pst_description'));
				$this->db->set('pst_datecreated', date('Y-m-d H:i:s'));
				$this->db->insert('posts');

				redirect($this->my_url.'topics/read/'.$tcs_id);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function read($tcs_id) {
		$data = array();
		$data['row'] = $this->topics_model->get_row($tcs_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				if($this->auth_library->permission('topics/read/onlypublished') && $data['row']->tcs_published == 0) {
					redirect($this->my_url);
				}
				$this->my_library->set_title($this->lang->line('topics').' / '.$data['row']->tcs_name);
				$content = $this->load->view('topics/topics_read', $data, TRUE);
				$content .= $this->posts_model->get_index_list($data['row']);
				$content .= $this->my_model->get_logs('topic', $tcs_id);
				$this->my_library->set_zone('content', $content);
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function update($tcs_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->topics_model->get_row($tcs_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('topics').' / '.$data['row']->tcs_name);
				$data['dropdown_tcs_owner'] = $this->topics_model->dropdown_tcs_owner();
				$this->form_validation->set_rules('tcs_owner', 'lang:tcs_owner', 'required|numeric');
				$this->form_validation->set_rules('tcs_name', 'lang:tcs_name', 'required|max_length[255]');
				$this->form_validation->set_rules('tcs_status', 'lang:tcs_status', 'required|numeric');
				$this->form_validation->set_rules('tcs_priority', 'lang:tcs_priority', 'required|numeric');
				$this->form_validation->set_rules('tcs_published', 'lang:tcs_published', 'numeric');
				$this->form_validation->set_rules('log_comments', 'lang:log_comments', '');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('topics/topics_update', $data, TRUE);
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
					$this->db->set('tcs_owner', $this->input->post('tcs_owner'));
					$this->db->set('tcs_name', $this->input->post('tcs_name'));
					$this->db->set('tcs_status', $this->input->post('tcs_status'));
					$this->db->set('tcs_priority', $this->input->post('tcs_priority'));
					$this->db->set('tcs_published', checkbox2database($this->input->post('tcs_published')));
					$this->db->set('tcs_datemodified', date('Y-m-d H:i:s'));
					$this->db->where('tcs_id', $tcs_id);
					$this->db->update('topics');

					$this->my_model->save_log('topic', $tcs_id, $data['row']);

					redirect($this->my_url.'topics/read/'.$tcs_id);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function delete($tcs_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->topics_model->get_row($tcs_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('topics').' / '.$data['row']->tcs_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('topics/topics_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					if(count($this->storage_fields) > 0) {
						foreach($this->storage_fields as $field) {
							if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
								unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
							}
						}
					}
					$this->db->where('tcs_id', $tcs_id);
					$this->db->delete('topics');

					$this->db->where('tcs_id', $tcs_id);
					$this->db->delete('posts');

					redirect($this->my_url.'projects/read/'.$data['row']->prj_id);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function post($tcs_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->topics_model->get_row($tcs_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('topics').' / '.$data['row']->tcs_name);
				$this->form_validation->set_rules('pst_description', 'lang:pst_description', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('posts/posts_create', $data, TRUE);
					$content .= $this->posts_model->get_index_list($data['row']);
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
					$this->db->set('tcs_id', $tcs_id);
					$this->db->set('pst_owner', $this->phpcollab_member->mbr_id);
					$this->db->set('pst_description', $this->input->post('pst_description'));
					$this->db->set('pst_datecreated', date('Y-m-d H:i:s'));
					$this->db->insert('posts');

					redirect($this->my_url.'topics/read/'.$tcs_id);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
}
