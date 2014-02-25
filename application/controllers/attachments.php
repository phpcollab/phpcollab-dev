<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class attachments extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('tasks_model');
		$this->load->model('attachments_model');
	}
	public function download($att_id) {
		$data = array();
		$data['row'] = $this->attachments_model->get_row($att_id);
		if($data['row']) {
			$data['tsk'] = $this->tasks_model->get_row($data['row']->tsk_id);
			if($data['tsk']) {
				$data['prj'] = $this->projects_model->get_row($data['tsk']->prj_id);
				if($data['prj']) {
					if(file_exists('storage/projects/'.$data['tsk']->prj_id.'/'.$data['row']->att_name)) {
						download_header($data['row']->att_name, $data['row']->att_size);
						readfile('storage/projects/'.$data['tsk']->prj_id.'/'.$data['row']->att_name);
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
		} else {
			redirect($this->my_url);
		}
	}
}
