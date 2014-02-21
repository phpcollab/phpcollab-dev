<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_hook {
	public function pre_controller() {
		$CFG =& load_class('Config', 'core');
		$URI =& load_class('URI', 'core');
		$CFG->set_item('language', $URI->segment(1));
	}
	public function post_controller_constructor() {
		$this->CI =& get_instance();

		$this->CI->my_library->set_content_type('text/html');
		$this->CI->my_library->set_charset('UTF-8');

		$result = $this->CI->db->query('SELECT cfg.* FROM '.$this->CI->db->dbprefix('_configuration').' AS cfg GROUP BY cfg.cfg_id')->result();
		if($result) {
			foreach($result as $row) {
				if($row->cfg_value != '') {
					$this->CI->config->set_item($row->cfg_path, $row->cfg_value);
				}
			}
		}
		$get_languages = $this->CI->my_model->get_languages();
		$this->CI->config->set_item('languages', $get_languages['languages']);
		$this->CI->config->set_item('language_default', $get_languages['language_default']);

		$language = false;
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) == 1) {
			$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}
		if(!array_key_exists($language, $this->CI->config->item('languages'))) {
			$language = $this->CI->config->item('language_default');
		}

		if(!array_key_exists($this->CI->uri->segment(1), $this->CI->config->item('languages'))) {
			redirect(base_url().$language);
		}
		$this->CI->config->set_item('language', $this->CI->uri->segment(1));
		$this->CI->my_url = base_url().$this->CI->config->item('language').'/';

		$this->CI->load->language('my');

		$this->CI->load->driver('auth_library', array('adapter'=>$this->CI->config->item('phpcollab/driver/auth')));

		if($this->CI->session->userdata('phpcollab_member') && $this->CI->input->cookie('phpcollab_member')) {
			$this->CI->phpcollab_member = $this->CI->auth_library->get();
			if(!$this->CI->phpcollab_member) {
				$this->CI->auth_library->logout();
				redirect($this->CI->my_url.'login?uri_string='.urlencode($this->CI->uri->uri_string()));
			}
		} else {
			if($this->CI->uri->segment(2) != 'login' && $this->CI->uri->segment(2) != 'forgotpassword' && $this->CI->uri->segment(2) != 'setup') {
				redirect($this->CI->my_url.'login?uri_string='.urlencode($this->CI->uri->uri_string()));
			}
		}

		if($this->CI->config->item('tinymce/enabled')) {
			$this->CI->my_library->foot[] = '<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>';
			$this->CI->my_library->foot[] = '<script>tinymce.init({
				selector: \'.wysiwyg\',
				entity_encoding : \'raw\',
				remove_script_host: true,
				relative_urls: true,
				plugins: \'advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker searchreplace wordcount visualblocks visualchars code fullscreen media nonbreaking table contextmenu directionality template paste\',
				toolbar1: \'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect\',
				toolbar2: \'cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code\',
				toolbar3: \'table | hr removeformat | subscript superscript | charmap | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft\',
				menubar: false,
				toolbar_items_size: \'small\',
			})</script>';
		}

		$this->CI->my_library->set_title($this->CI->config->item('phpcollab/title'));
		$this->CI->my_library->set_template('template_html');
	}
	public function post_controller() {
		$this->CI =& get_instance();
		header('content-type: '.$this->CI->my_library->content_type.'; charset='.$this->CI->my_library->charset);

		$data = array();
		$data['zones'] = $this->CI->my_library->zones;
		$this->CI->load->view($this->CI->my_library->template, $data, FALSE);
	}
}
