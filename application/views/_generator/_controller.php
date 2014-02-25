&lt;?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class <?php echo $table; ?> extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('<?php echo $table; ?>_model');

<?php if(count($upload) > 0) { ?>
		$this->load->library('upload');
<?php } ?>
		$this->storage_table = '<?php echo $table; ?>';
		$this->storage_fields = array(<?php if(count($upload) > 0) { ?>'<?php echo implode('\', \'', $upload); ?>'<?php } ?>);
	}
	public function index() {
		$this->my_library->set_title($this->lang->line('<?php echo $table; ?>'));
		$content = $this-><?php echo $table; ?>_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
<?php if($action_create) { ?>	public function create() {
		$this->my_library->set_title($this->lang->line('<?php echo $table; ?>'));
		$this->load->library('form_validation');
		$data = array();
<?php foreach($select as $v) { ?>		$data['dropdown_<?php echo $v; ?>'] = $this-><?php echo $table; ?>_model->dropdown_<?php echo $v; ?>();
<?php } ?>
		<?php foreach($save as $v) { ?>$this->form_validation->set_rules('<?php echo $v; ?>', 'lang:<?php echo $v; ?>', '<?php echo implode('|', $fields[$v]['rules_create']); ?>');
		<?php } ?><?php foreach($save_translation as $v) { ?>$this->form_validation->set_rules('<?php echo $v; ?>', 'lang:<?php echo $v; ?>', '<?php echo implode('|', $fields[$v]['rules_create']); ?>');
		<?php } ?>if($this->form_validation->run() == FALSE) {
			$content = $this->load->view('<?php echo $table; ?>/<?php echo $table; ?>_create', $data, TRUE);
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
<?php foreach($save as $v) { ?>
<?php if($fields[$v]['type'] == 'input' && in_array($v, $upload)) { ?>
<?php } else { ?>
			$this->db->set('<?php echo $v; ?>', <?php if($fields[$v]['type'] == 'checkbox') { ?>checkbox2database($this->input->post('<?php echo $v; ?>'))<?php } else { ?>$this->input->post('<?php echo $v; ?>')<?php } ?>);
<?php } ?>
<?php } ?>
<?php if(isset($datecreation) == 1) { ?>			$this->db->set('<?php echo $datecreation; ?>', date('Y-m-d H:i:s'));
<?php } ?>
			$this->db->insert('<?php echo $table; ?>');
			$<?php echo $primary; ?> = $this->db->insert_id();
<?php if($table_translation) { ?>			foreach($this->config->item('languages') as $k => $v) {
<?php foreach($save_translation as $v) { ?>
				$this->db->set('<?php echo $v; ?>', <?php if($fields[$v]['type'] == 'checkbox') { ?>checkbox2database($this->input->post('<?php echo $v; ?>'))<?php } else { ?>$this->input->post('<?php echo $v; ?>')<?php } ?>);
<?php } ?>
				$this->db->set('<?php echo $primary; ?>', $<?php echo $primary; ?>);
				$this->db->set('<?php echo $language_field; ?>', $k);
				$this->db->insert('<?php echo $table_translation; ?>');
			}
<?php } ?>			$this->read($<?php echo $primary; ?>);
		}
	}
<?php } ?>	<?php if($action_read) { ?>public function read($<?php echo $primary; ?>) {
		$data = array();
		$data['row'] = $this-><?php echo $table; ?>_model->get_row($<?php echo $primary; ?>);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('<?php echo $table; ?>').' | '.$data['row']-><?php echo $main_field; ?>);
			$content = $this->load->view('<?php echo $table; ?>/<?php echo $table; ?>_read', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
<?php } ?><?php if($action_update) { ?>	public function update($<?php echo $primary; ?>) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this-><?php echo $table; ?>_model->get_row($<?php echo $primary; ?>);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('<?php echo $table; ?>').' | '.$data['row']-><?php echo $main_field; ?>);
<?php foreach($select as $v) { ?>			$data['dropdown_<?php echo $v; ?>'] = $this-><?php echo $table; ?>_model->dropdown_<?php echo $v; ?>();
<?php } ?>
			<?php foreach($save as $v) { ?>$this->form_validation->set_rules('<?php echo $v; ?>', 'lang:<?php echo $v; ?>', '<?php echo implode('|', $fields[$v]['rules_update']); ?>');
			<?php } ?><?php foreach($save_translation as $v) { ?>$this->form_validation->set_rules('<?php echo $v; ?>', 'lang:<?php echo $v; ?>', '<?php echo implode('|', $fields[$v]['rules_update']); ?>');
			<?php } ?>if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('<?php echo $table; ?>/<?php echo $table; ?>_update', $data, TRUE);
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
<?php foreach($save as $v) { ?>
<?php if($fields[$v]['type'] == 'input' && in_array($v, $upload)) { ?>
<?php } else { ?>
				$this->db->set('<?php echo $v; ?>', <?php if($fields[$v]['type'] == 'checkbox') { ?>checkbox2database($this->input->post('<?php echo $v; ?>'))<?php } else { ?>$this->input->post('<?php echo $v; ?>')<?php } ?>);
<?php } ?>
<?php } ?>
<?php if(isset($datemodification) == 1) { ?>				$this->db->set('<?php echo $datemodification; ?>', date('Y-m-d H:i:s'));
<?php } ?>
				$this->db->where('<?php echo $primary; ?>', $<?php echo $primary; ?>);
				$this->db->update('<?php echo $table; ?>');
<?php if($table_translation) { ?><?php foreach($save_translation as $v) { ?>
				$this->db->set('<?php echo $v; ?>', <?php if($fields[$v]['type'] == 'checkbox') { ?>checkbox2database($this->input->post('<?php echo $v; ?>'))<?php } else { ?>$this->input->post('<?php echo $v; ?>')<?php } ?>);
<?php } ?>
				$this->db->where('<?php echo $primary; ?>', $<?php echo $primary; ?>);
				$this->db->where('<?php echo $language_field; ?>', $this->config->item('language'));
				$this->db->update('<?php echo $table_translation; ?>');
<?php } ?>				$this->read($<?php echo $primary; ?>);
			}
		} else {
			$this->index();
		}
	}
<?php } ?><?php if($action_delete) { ?>	public function delete($<?php echo $primary; ?>) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this-><?php echo $table; ?>_model->get_row($<?php echo $primary; ?>);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('<?php echo $table; ?>').' | '.$data['row']-><?php echo $main_field; ?>);
			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('<?php echo $table; ?>/<?php echo $table; ?>_delete', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				if(count($this->storage_fields) > 0) {
					foreach($this->storage_fields as $field) {
						if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
							unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
						}
					}
				}
				$this->db->where('<?php echo $primary; ?>', $<?php echo $primary; ?>);
				$this->db->delete('<?php echo $table; ?>');
<?php if($table_translation) { ?>
				$this->db->where('<?php echo $primary; ?>', $<?php echo $primary; ?>);
				$this->db->delete('<?php echo $table_translation; ?>');
<?php } ?>
				$this->index();
			}
		} else {
			$this->index();
		}
	}
<?php } ?>
<?php if(count($callback) > 0) { ?>
<?php foreach($callback as $field) { ?>
	public function <?php echo $field; ?>($<?php echo $field; ?>, $current = false) {
		if($this->input->post('<?php echo $field; ?>')) {
			if($current) {
				$query = $this->db->query('SELECT <?php echo $table_alias; ?>.* FROM '.$this->db->dbprefix('<?php echo $table; ?>').' AS <?php echo $table_alias; ?> WHERE <?php echo $table_alias; ?>.<?php echo $field; ?> = ? AND <?php echo $table_alias; ?>.<?php echo $field; ?> != ? GROUP BY <?php echo $table_alias; ?>.<?php echo $primary; ?>', array($this->input->post('<?php echo $field; ?>'), $current));
			} else {
				$query = $this->db->query('SELECT <?php echo $table_alias; ?>.* FROM '.$this->db->dbprefix('<?php echo $table; ?>').' AS <?php echo $table_alias; ?> WHERE <?php echo $table_alias; ?>.<?php echo $field; ?> = ? GROUP BY <?php echo $table_alias; ?>.<?php echo $primary; ?>', array($this->input->post('<?php echo $field; ?>')));
			}
			if($this->input->is_ajax_request()) {
				$this->my_library->set_template('template_json');
				$this->my_library->set_content_type('application/json');
				$content = array();
				if($query->num_rows() > 0) {
					$content['status'] = 'ko';
				} else {
					$content['status'] = 'ok';
				}
				$this->my_library->set_zone('content', $content);
			} else {
				if($query->num_rows() > 0) {
					$this->form_validation->set_message('<?php echo $field; ?>', $this->lang->line('already_exists'));
					return FALSE;
				} else {
					return TRUE;
				}
			}
		}
	}
<?php } ?><?php } ?>
<?php if($action_export) { ?>	public function export() {
		$query = $this->db->query('SELECT <?php echo $table_alias; ?>.* FROM '.$this->db->dbprefix('<?php echo $table; ?>').' AS <?php echo $table_alias; ?> GROUP BY <?php echo $table_alias; ?>.<?php echo $primary; ?>');
		if($query->num_rows() > 0) {
			download_header('<?php echo $table; ?>-'.date('Y-m-d').'.csv');
			$lines = array();

			$headers = array();
<?php foreach($columns as $v) { ?>			$headers[] = $this->lang->line('<?php echo $v; ?>');
<?php } ?>
			foreach($headers as $header) {
				$lines[-1][$header] = $header;
			}
			echo csv_line($lines[-1]);

			$u = 0;
			while($row = $query->_fetch_object()) {
<?php foreach($columns as $v) { ?>				$lines[$u][] = $row-><?php echo $v; ?>;
<?php } ?>
				echo csv_line($lines[$u]);
				unset($lines[$u]);
				$u++;
			}
			exit(0);
		}
	}
<?php } ?><?php if($action_statistics) { ?>	public function statistics() {
		$this->my_library->set_title($this->lang->line('<?php echo $table; ?>'));
		$data = array();
		$data['tables'] = '';

<?php if(isset($datecreation) == 1) { ?>
		$legend = array();
		$values = array();
		$query = $this->db->query('SELECT SUBSTRING(<?php echo $table_alias; ?>.<?php echo $datecreation; ?>, 1, 7) AS ref, COUNT(DISTINCT(<?php echo $table_alias; ?>.<?php echo $primary; ?>)) AS nb FROM '.$this->db->dbprefix('<?php echo $table; ?>').' AS <?php echo $table_alias; ?> GROUP BY ref ORDER BY ref DESC LIMIT 0,12');
		if($query->num_rows() > 0) {
			$current_month = date('Y-m');
			foreach($query->result() as $row) {
				list($y, $m) = explode('-', $row->ref);
				if($row->ref == $current_month) {
					$legend[] = '<em>'.$this->lang->line('month_'.$m).' '.$y.'</em>';
				} else {
					$legend[] = $this->lang->line('month_'.$m).' '.$y;
				}
				$values[] = $row->nb;
			}
		}
		$data['tables'] .= build_table_progression($this->lang->line('<?php echo $datecreation; ?>'), $values, $legend);
<?php } ?>

<?php foreach($save as $v) { ?>
<?php if(stristr($fields[$v]['real_type'], 'varchar') && stristr($v, 'email')) { ?>
		$legend = array();
		$values = array();
		$query = $this->db->query('SELECT SUBSTRING(<?php echo $table_alias; ?>.<?php echo $v; ?>, LOCATE(\'@\', <?php echo $table_alias; ?>.<?php echo $v; ?>) + 1) AS ref, COUNT(DISTINCT(<?php echo $table_alias; ?>.<?php echo $primary; ?>)) AS nb FROM '.$this->db->dbprefix('<?php echo $table; ?>').' AS <?php echo $table_alias; ?> GROUP BY ref ORDER BY nb DESC LIMIT 0,12');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$legend[] = $row->ref;
				$values[] = $row->nb;
			}
		}
		$data['tables'] .= build_table_repartition($this->lang->line('<?php echo $v; ?>'), $values, $legend);
<?php } else if($fields[$v]['type'] == 'checkbox') { ?>
		$legend = array();
		$values = array();
		$query = $this->db->query('SELECT <?php echo $table_alias; ?>.<?php echo $v; ?> AS ref, COUNT(DISTINCT(<?php echo $table_alias; ?>.<?php echo $primary; ?>)) AS nb FROM '.$this->db->dbprefix('<?php echo $table; ?>').' AS <?php echo $table_alias; ?> GROUP BY ref ORDER BY nb DESC LIMIT 0,12');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$legend[] = $this->lang->line('reply_'.$row->ref);
				$values[] = $row->nb;
			}
		}
		$data['tables'] .= build_table_repartition($this->lang->line('<?php echo $v; ?>'), $values, $legend);
<?php } ?>
<?php } ?>
<?php foreach($select as $v) { ?>
		$legend = array();
		$values = array();
		$query = $this->db->query('SELECT <?php echo $fields[$v]['select_alias']; ?>.<?php echo $fields[$v]['select_label']; ?> AS ref, COUNT(DISTINCT(<?php echo $table_alias; ?>.<?php echo $primary; ?>)) AS nb FROM '.$this->db->dbprefix('<?php echo $table; ?>').' AS <?php echo $table_alias; ?> LEFT JOIN '.$this->db->dbprefix('<?php echo $fields[$v]['select_table']; ?>').' AS <?php echo $fields[$v]['select_alias']; ?> ON <?php echo $fields[$v]['select_alias']; ?>.<?php echo $fields[$v]['select_key']; ?> = <?php echo $table_alias; ?>.<?php echo $v; ?> GROUP BY ref ORDER BY nb DESC LIMIT 0,12');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$legend[] = $row->ref;
				$values[] = $row->nb;
			}
		}
		$data['tables'] .= build_table_repartition($this->lang->line('<?php echo $v; ?>'), $values, $legend);
<?php } ?>

		$content = $this->load->view('<?php echo $table; ?>/<?php echo $table; ?>_statistics', $data, TRUE);
		$this->my_library->set_zone('content', $content);
	}
<?php } ?>
}
