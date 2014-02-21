<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
	public function index() {
		$this->load->library(array('form_validation'));

		$this->form_validation->set_rules('mbr_email', 'lang:mbr_email', 'required|valid_email|max_length[255]|callback_email');
		$this->form_validation->set_rules('mbr_password', 'lang:mbr_password');
		$this->form_validation->set_rules('mbr_password_confirm', 'lang:mbr_password_confirm', 'matches[mbr_password]');

		if($this->form_validation->run() == FALSE) {
			$data = array();
			$content = $this->load->view('profile/profile_index', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			if($this->input->post('mbr_password') != '' && $this->input->post('mbr_password_confirm') != '') {
				$this->db->set('mbr_password', $this->auth_library->salt_password($this->input->post('mbr_password')));
			}

			$this->db->set('mbr_email', $this->input->post('mbr_email'));
			$this->db->where('mbr_id', $this->phpcollab_member->mbr_id);
			$this->db->update('members');

			redirect($this->my_url);
		}
	}
	public function email() {
		if($this->input->post('mbr_email')) {
			$query = $this->db->query('SELECT mbr.* FROM '.$this->db->dbprefix('members').' AS mbr WHERE mbr.mbr_email = ? AND mbr.mbr_email != ? GROUP BY mbr.mbr_id', array($this->input->post('mbr_email'), $this->phpcollab_member->mbr_email));
			if($query->num_rows() > 0) {
				$this->form_validation->set_message('email', $this->lang->line('already_exists'));
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}
}
