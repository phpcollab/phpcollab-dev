<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_library_default extends CI_Driver {
	private $CI;
	public function __construct() {
		$this->CI =& get_instance();
	}
	function login($email, $password) {
		$this->CI->session->unset_userdata('phpcollab_member');
		$query = $this->CI->db->query('SELECT mbr.* FROM '.$this->CI->db->dbprefix('members').' AS mbr WHERE mbr.mbr_email = ? GROUP BY mbr.mbr_id', array($email));
		if($query->num_rows() > 0) {
			$member = $query->row();
			if($this->salt_password($password) == $member->mbr_password) {
				$this->connect($member->mbr_id);

				return TRUE;
			}
		}
		return FALSE;
	}
	function salt_password($password) {
		return sha1($password.$this->CI->config->item('phpcollab/driver/auth/default/salt'));
	}
	function connect($mbr_id) {
		$this->CI->session->set_userdata('phpcollab_member', $mbr_id);

		$token_connection = sha1(uniqid($mbr_id, 1).mt_rand());
		$this->CI->db->set('token_connection', $token_connection);
		$this->CI->db->set('mbr_id', $mbr_id);
		$this->CI->db->set('cnt_ip', $this->CI->input->ip_address());
		$this->CI->db->set('cnt_agent', $this->CI->input->user_agent());
		$this->CI->db->set('cnt_datecreated', date('Y-m-d H:i:s'));
		$this->CI->db->insert('_connections');

		$this->CI->input->set_cookie('phpcollab_member', $token_connection, 0, NULL, '/', NULL, NULL);
	}
	function logout() {
		if($this->CI->session->userdata('phpcollab_member') && $this->CI->input->cookie('phpcollab_member')) {
			$this->CI->db->where('token_connection', $this->CI->input->cookie('phpcollab_member'));
			$this->CI->db->where('mbr_id', $this->CI->session->userdata('phpcollab_member'));
			$this->CI->db->delete('_connections');
		}
		$this->CI->input->set_cookie('phpcollab_member', NULL, 0, NULL, '/', NULL, NULL);
		$this->CI->session->unset_userdata('phpcollab_member');
		session_regenerate_id();
	}
	function get() {
		$member = FALSE;
		$query = $this->CI->db->query('SELECT cnt.* FROM '.$this->CI->db->dbprefix('_connections').' AS cnt WHERE cnt.mbr_id = ? AND cnt.token_connection = ? GROUP BY cnt.cnt_id', array($this->CI->session->userdata('phpcollab_member'), $this->CI->input->cookie('phpcollab_member')));
		if($query->num_rows() > 0) {
			$query = $this->CI->db->query('SELECT mbr.*, org.org_name FROM '.$this->CI->db->dbprefix('members').' AS mbr LEFT JOIN '.$this->CI->db->dbprefix('organizations').' AS org ON org.org_id = mbr.org_id WHERE mbr.mbr_id = ? GROUP BY mbr.mbr_id', array($this->CI->session->userdata('phpcollab_member')));
			if($query->num_rows() > 0) {
				$member = $query->row();
			}
		}
		return $member;
	}
}
