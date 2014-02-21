<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_library_default extends CI_Driver {
	private $CI;
	public function __construct() {
		$this->CI =& get_instance();
	}
	function login($email, $password) {
		$this->CI->session->unset_userdata('phpcollab_member');
		$query = $this->CI->db->query('SELECT mbr.* FROM '.$this->CI->db->dbprefix('members').' AS mbr WHERE mbr.mbr_email = ? AND mbr.mbr_authorized = ? GROUP BY mbr.mbr_id', array($email, 1));
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
	function permission($per_code) {
		if(isset($this->CI->phpcollab_member->permissions[$per_code]) == 1 && $this->CI->phpcollab_member->permissions[$per_code] == 1) {
			return true;
		} else {
			return false;
		}
	}
	function get() {
		$member = FALSE;
		$query = $this->CI->db->query('SELECT cnt.* FROM '.$this->CI->db->dbprefix('_connections').' AS cnt WHERE cnt.mbr_id = ? AND cnt.token_connection = ? GROUP BY cnt.cnt_id', array($this->CI->session->userdata('phpcollab_member'), $this->CI->input->cookie('phpcollab_member')));
		if($query->num_rows() > 0) {
			$query = $this->CI->db->query('SELECT mbr.*, org.org_name, GROUP_CONCAT(DISTINCT rol.rol_code ORDER BY rol.rol_code ASC SEPARATOR \', \') AS roles FROM '.$this->CI->db->dbprefix('members').' AS mbr LEFT JOIN '.$this->CI->db->dbprefix('organizations').' AS org ON org.org_id = mbr.org_id LEFT JOIN '.$this->CI->db->dbprefix('members_roles').' AS mbr_rol ON mbr_rol.mbr_id = mbr.mbr_id LEFT JOIN '.$this->CI->db->dbprefix('roles').' AS rol ON rol.rol_id = mbr_rol.rol_id WHERE mbr.mbr_id = ? AND mbr.mbr_authorized = ? GROUP BY mbr.mbr_id', array($this->CI->session->userdata('phpcollab_member'), 1));
			if($query->num_rows() > 0) {
				$member = $query->row();

				$member->permissions = array();
				$query = $this->CI->db->query('SELECT per.*, COUNT(rol_per.rol_per_id) AS total_saved FROM '.$this->CI->db->dbprefix('permissions').' AS per LEFT JOIN '.$this->CI->db->dbprefix('roles_permissions').' AS rol_per ON rol_per.per_id = per.per_id LEFT JOIN '.$this->CI->db->dbprefix('members_roles').' AS mbr_rol ON mbr_rol.rol_id = rol_per.rol_id AND mbr_rol.mbr_id = ? GROUP BY per.per_id', array($this->CI->session->userdata('phpcollab_member')));
				foreach($query->result() as $row) {
					if($row->total_saved > 0) {
						$member->permissions[$row->per_code] = true;
					} else {
						$member->permissions[$row->per_code] = false;
					}
				}
			}
		}
		return $member;
	}
}
