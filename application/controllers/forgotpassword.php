<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgotpassword extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->today = date('Y-m-d H:i:s');
	}
	public function index() {
		if($this->session->userdata('phpcollab_member')) {
			redirect($this->my_url);
		}

		$this->load->library(array('form_validation', 'email_library'));

		$this->form_validation->set_rules('mbr_email', 'lang:mbr_email', 'required|valid_email|max_length[255]|callback_email');

		if($this->form_validation->run() == FALSE) {
			$data = array();
			$content = $this->load->view('forgotpassword/forgotpassword_index', $data, TRUE);
		} else {
			$query = $this->db->query('SELECT mbr.* FROM '.$this->db->dbprefix('members').' AS mbr WHERE mbr.mbr_email = ? GROUP BY mbr.mbr_id', array($this->input->post('mbr_email')));
			if($query->num_rows() > 0) {
				$user = $query->row();

				$token_forgotpassword = sha1(uniqid($user->mbr_id, 1).mt_rand());
				$this->db->set('token_forgotpassword', $token_forgotpassword);
				$this->db->where('mbr_id', $user->mbr_id);
				$this->db->update('members');

				$to = $user->mbr_email;
				$template = 'backend_forgotpassword';
				$tags = array(
					'[mbr_email]' => $user->mbr_email,
					'[confirmation_url]' => $this->my_url.'forgotpassword/confirmation/'.$token_forgotpassword,
				);
				$this->email_library->send($to, $this->config->item('language'), $template, $tags);

				$data = array();
				$content = $this->load->view('forgotpassword/forgotpassword_sent', $data, TRUE);
			}
		}
		$this->my_library->set_zone('content', $content);
	}
	public function confirmation($token_forgotpassword) {
		if($this->session->userdata('phpcollab_member')) {
			redirect($this->my_url);
		}

		if(isset($_SERVER['REQUEST_METHOD']) == 1 && $_SERVER['REQUEST_METHOD'] == 'HEAD') {
			exit(0);
		}

		$query = $this->db->query('SELECT mbr.* FROM '.$this->db->dbprefix('members').' AS mbr WHERE mbr.token_forgotpassword = ? GROUP BY mbr.mbr_id', array($token_forgotpassword));
		if($query->num_rows() > 0) {
			$member = $query->row();
			$mbr_password = generate_string(6);
			$this->db->set('mbr_password', $this->auth_library->salt_password($mbr_password));
			$this->db->set('token_forgotpassword', '');
			$this->db->where('mbr_id', $member->mbr_id);
			$this->db->update('members');

			$data = array();
			$data['mbr_password'] = $mbr_password;
			$content = $this->load->view('forgotpassword/forgotpassword_confirmation', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function email() {
		if($this->input->post('mbr_email')) {
			$query = $this->db->query('SELECT mbr.* FROM '.$this->db->dbprefix('members').' AS mbr WHERE mbr.mbr_email = ? GROUP BY mbr.mbr_id', array($this->input->post('mbr_email')));
			if($query->num_rows() > 0) {
				return TRUE;
			} else {
				$this->form_validation->set_message('email', $this->lang->line('not_found'));
				return FALSE;
			}
		}
	}
}
