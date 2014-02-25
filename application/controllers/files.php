<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class files extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('files_model');
	}
	public function index($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($data['prj']->prj_name.' | '.$this->lang->line('files'));
			$content = $this->files_model->get_index_list($data['prj']);
			$this->my_library->set_zone('content', $content);
		} else {
			redirect($this->my_url);
		}
	}
	public function create($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($data['prj']->prj_name.' | '.$this->lang->line('files').' | '.$this->lang->line('create'));
			$this->load->library('form_validation');
			$data['dropdown_fle_owner'] = $this->files_model->dropdown_fle_owner();
			$this->form_validation->set_rules('fle_owner', 'lang:fle_owner', 'required|numeric');
			$this->form_validation->set_rules('fle_name', 'lang:fle_name', 'max_length[255]|callback_name');
			$this->form_validation->set_rules('fle_description', 'lang:fle_description', '');
			$this->form_validation->set_rules('fle_published', 'lang:fle_published', 'numeric');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('files/files_create', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				if(!is_dir('storage/projects/'.$prj_id)) {
					mkdir('storage/projects/'.$prj_id);
					copy('storage/projects/index.html', 'storage/projects/'.$prj_id.'/index.html');
				}

				$fle_name = clean_string($_FILES['fle_name']['name']);
				$fle_name = generate_string(6).'-'.$fle_name;

				move_uploaded_file($_FILES['fle_name']['tmp_name'], 'storage/projects/'.$prj_id.'/'.$fle_name);

				$this->db->set('prj_id', $prj_id);
				$this->db->set('fle_owner', $this->input->post('fle_owner'));
				$this->db->set('fle_name', $fle_name);
				$this->db->set('fle_description', $this->input->post('fle_description'));
				$this->db->set('fle_status', 1);//TODO
				$this->db->set('fle_size', $_FILES['fle_name']['size']);
				$this->db->set('fle_published', checkbox2database($this->input->post('fle_published')));
				$this->db->set('fle_datecreated', date('Y-m-d H:i:s'));
				$this->db->insert('files');
				$fle_id = $this->db->insert_id();

				redirect($this->my_url.'files/read/'.$fle_id);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function read($fle_id) {
		$data = array();
		$data['row'] = $this->files_model->get_row($fle_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				if($this->auth_library->permission('files/read/onlypublished') && $data['row']->fle_published == 0) {
					redirect($this->my_url);
				}
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->fle_name);
				$content = $this->load->view('files/files_read', $data, TRUE);
				$content .= $this->my_model->get_logs('file', $fle_id);
				$this->my_library->set_zone('content', $content);
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function update($fle_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->files_model->get_row($fle_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->fle_name);
				$data['dropdown_fle_owner'] = $this->files_model->dropdown_fle_owner();
				$this->form_validation->set_rules('fle_owner', 'lang:fle_owner', 'required|numeric');
				$this->form_validation->set_rules('fle_description', 'lang:fle_description', '');
				$this->form_validation->set_rules('fle_published', 'lang:fle_published', 'numeric');
				$this->form_validation->set_rules('log_comments', 'lang:log_comments', '');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('files/files_update', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					$this->db->set('fle_owner', $this->input->post('fle_owner'));
					$this->db->set('fle_description', $this->input->post('fle_description'));
					$this->db->set('fle_published', checkbox2database($this->input->post('fle_published')));
					$this->db->where('fle_id', $fle_id);
					$this->db->update('files');

					$this->my_model->save_log('file', $fle_id, $data['row']);

					redirect($this->my_url.'files/read/'.$fle_id);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function delete($fle_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->files_model->get_row($fle_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				if(!$data['row']->action_delete) {
					redirect($this->my_url);
				}
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->fle_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('files/files_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					if(file_exists('storage/projects/'.$data['row']->prj_id.'/'.$data['row']->fle_name)) {
						unlink('storage/projects/'.$data['row']->prj_id.'/'.$data['row']->fle_name);
					}
					$this->db->where('fle_id', $fle_id);
					$this->db->delete('files');

					$this->db->where('fle_id', $fle_id);
					$this->db->delete('files_milestones');

					$this->db->where('fle_id', $fle_id);
					$this->db->delete('files_tasks');

					redirect($this->my_url.'projects/read/'.$data['row']->prj_id);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function download($fle_id) {
		$data = array();
		$data['row'] = $this->files_model->get_row($fle_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				if($this->auth_library->permission('files/read/onlypublished') && $data['row']->fle_published == 0) {
					redirect($this->my_url);
				}
				if(file_exists('storage/projects/'.$data['row']->prj_id.'/'.$data['row']->fle_name)) {
					download_header($data['row']->fle_name, $data['row']->fle_size);
					readfile('storage/projects/'.$data['row']->prj_id.'/'.$data['row']->fle_name);
					session_write_close();
					exit(0);
				} else {
					redirect($this->my_url);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function name() {
		if(isset($_FILES['fle_name']) == 1 && $_FILES['fle_name']['error'] == 0) {
			$extension = strtolower(substr(strrchr($_FILES['fle_name']['name'], '.'), 1));
			if($extension != 'php') {
				return true;
			}
		}
		$this->form_validation->set_message('name', $this->lang->line('file_error'));
		return false;
	}
}
