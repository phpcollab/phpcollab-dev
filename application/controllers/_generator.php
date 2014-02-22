<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _generator extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->tables = array();
		$this->tables[''] = '-';

		//$update_fields = array('status', 'priority', 'date_start', 'date_due', 'date_complete', 'comments', 'published');

		$query = $this->db->query('SHOW TABLE STATUS');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				if(substr($row->Name, 0, 1) != '_') {
					$this->tables[$row->Name] = $row->Name;

					/*echo 'INSERT INTO permissions (per_code) VALUES(\''.$row->Name.'/index\');<br>';
					echo 'INSERT INTO permissions (per_code) VALUES(\''.$row->Name.'/create\');<br>';
					echo 'INSERT INTO permissions (per_code) VALUES(\''.$row->Name.'/read/comments\');<br>';
					echo 'INSERT INTO permissions (per_code) VALUES(\''.$row->Name.'/update\');<br>';
					$query = $this->db->query('SHOW FULL COLUMNS FROM '.$row->Name);
					foreach($query->result() as $row_fields) {
						if(in_array(substr($row_fields->Field, 4), $update_fields)) {
							echo 'INSERT INTO permissions (per_code) VALUES(\''.$row->Name.'/update/'.substr($row_fields->Field, 4).'\');<br>';
						}
					}
					echo 'INSERT INTO permissions (per_code) VALUES(\''.$row->Name.'/delete\');<br>';*/
				}
			}
		}
	}
	public function index() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('generator'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('table', 'table', 'required');

		$content = '';
		if($this->form_validation->run() == FALSE) {
			$content .= '<article class="title">';
			$content .= '<h2><i class="fa fa-flask"></i>'.$this->lang->line('generator').'</h2>';
			$content .= '</article>';

			$content .= '<article>';
			$content .= validation_errors();
			$content .= form_open(current_url());
			$content .= '<p>'.form_label('table *', 'table').form_dropdown('table', $this->tables, set_value('table'), 'id="table" class="select required"').'</p>';
			$content .= '<p>'.form_label('translation table', 'table').form_dropdown('table_translation', $this->tables, set_value('table_translation'), 'id="table_translation" class="select"').'</p>';
			$content .= '<p><span class="label">&nbsp;</span>'.form_submit('action1', 'OK', 'id="action1" class="inputsubmit"').'</p>';
			$content .= form_close();
			$content .= '</article>';
			$this->my_library->set_zone('content', $content);
		} else {
			redirect($this->my_url.'_generator/table/'.$this->input->post('table').'/'.$this->input->post('table_translation'));
		}
	}
	public function table($table, $table_translation = false) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('generator'));

		$data = array();
		$data['primary'] = false;

		$fields = array();
		$columns = array();
		$links = array();
		$filters = array();
		$upload = array();
		$boolean = array();
		$callback = array();

		$read = array();
		$read['main'] = array();
		$read['translation'] = array();

		$save = array();
		$save['main'] = array();
		$save['translation'] = array();
		$select = array();

		$content = '';

		//$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.print_r($_POST, 1).'</textarea>';

		$data['aliases'] = array();

		if(in_array($table, $this->tables) && $table != '-') {
			$rows = array();
			$query = $this->db->query('SHOW FULL COLUMNS FROM '.$table);
			foreach($query->result() as $row) {
				$row->type_field_generator = 'main';
				$data['aliases'][$row->Field] = 'table_alias';
				$rows[] = $row;
			}

			$select_language = array('' => '-');
			if(in_array($table_translation, $this->tables) && $table_translation != '-') {
				$query = $this->db->query('SHOW FULL COLUMNS FROM '.$table_translation);
				if($query) {
					foreach($query->result() as $row) {
						$select_language[$row->Field] = $row->Field;
						$row->type_field_generator = 'translation';
						$data['aliases'][$row->Field] = 'table_translation_alias';
						$rows[] = $row;
					}
				}
			}

			$query_status = $this->db->query('SHOW TABLE STATUS WHERE name = ?', array($table));
			$content .= '<article class="title">';
			$content .= '<h2><a href="'.$this->my_url.'_generator"><i class="fa fa-flask"></i>'.$this->lang->line('generator').'</a> / <i class="fa fa-wrench"></i>'.$table.'</h2>';
			$content .= '<ul>';
			$content .= '</ul>';
			$content .= '</article>';

			$content .= '<article>';
			$content .= '<h2>'.$table;if($query_status->row()->Comment) {$content .= $query_status->row()->Comment; }$content .= '</h2>';
			$content .= form_open(current_url());
			$content .= '<table>
			<thead>
			<tr>
			<th>Field</th>
			<th>Column</th>
			<th>Link</th>
			<th>Filter</th>
			<th>Create / Update</th>
			<th>Upload</th>
			<th>Title</th>
			<th>Date created</th>
			<th>Date modified</th>
			</tr>
			</thead>';
			$content .= '<tbody>';
			$u = 1;

			$exclude = array();
			$exclude[] = 'lng_code';
			$primary = false;

			foreach($rows as $row) {
				if($row->Key == 'PRI' && $primary) {
					$exclude[] = $row->Field;
				}
				if(!in_array($row->Field, $exclude)) {
					if($row->Key == 'PRI') {
						$primary = true;
						$data['primary'] = $row->Field;
						$exclude[] = $row->Field;
					}

					$fields[$row->Field] = array();
					$fields[$row->Field]['rules_create'] = array();
					$fields[$row->Field]['rules_update'] = array();
					$fields[$row->Field]['classes'] = array();

					if($row->Key == 'UNI') {
						$k_rule = 'callback_'.$row->Field;
						$fields[$row->Field]['rules_create'][$k_rule] = $k_rule;

						$k_rule = 'callback_'.$row->Field.'[\'.$data[\'row\']->'.$row->Field.'.\']';
						$fields[$row->Field]['rules_update'][$k_rule] = $k_rule;

						$callback[] = $row->Field;
					}

					$fields[$row->Field]['default'] = strval($row->Default);

					$fields[$row->Field]['real_type'] = $row->Type;

					if($row->Null == 'NO' && !stristr($row->Type, 'tinyint')) {
						$fields[$row->Field]['rules_create']['required'] = 'required';
						$fields[$row->Field]['rules_update']['required'] = 'required';
						$fields[$row->Field]['classes']['required'] = 'required';
					}
					if(stristr($row->Type, 'int')) {
						$fields[$row->Field]['rules_create']['numeric'] = 'numeric';
						$fields[$row->Field]['rules_update']['numeric'] = 'numeric';
						$fields[$row->Field]['classes']['numeric'] = 'numeric';
					}
					if($row->Type == 'date') {
						$fields[$row->Field]['classes']['date'] = 'date';
					}
					if(stristr($row->Type, 'varchar') && stristr($row->Field, 'email')) {
						$fields[$row->Field]['rules_create']['valid_email'] = 'valid_email';
						$fields[$row->Field]['rules_update']['valid_email'] = 'valid_email';
						$fields[$row->Field]['classes']['valid_email'] = 'valid_email';
					}
					if(stristr($row->Type, 'varchar')) {
						$fields[$row->Field]['rules_create']['max_length'] = 'max_length['.substr($row->Type, 8, -1).']';
						$fields[$row->Field]['rules_update']['max_length'] = 'max_length['.substr($row->Type, 8, -1).']';
					}
					if(stristr($row->Type, 'text')) {
						$fields[$row->Field]['type'] = 'textarea';

					} else if(stristr($row->Type, 'tinyint')) {
						$fields[$row->Field]['type'] = 'checkbox';
						$boolean[] = $row->Field;

					} else if($row->Key != 'PRI' && substr($row->Type, 0, 3) == 'int' && $this->input->post('select_key_'.$row->Field) && $this->input->post('select_label_'.$row->Field) && $this->input->post('select_table_'.$row->Field)) {
						$fields[$row->Field]['type'] = 'dropdown';
						$fields[$row->Field]['select_key'] = $_POST['select_key_'.$row->Field];
						$fields[$row->Field]['select_label'] = $_POST['select_label_'.$row->Field];
						$fields[$row->Field]['select_table'] = $_POST['select_table_'.$row->Field];
						if($_POST['select_alias_'.$row->Field] != '') {
							$fields[$row->Field]['select_alias'] = $_POST['select_alias_'.$row->Field];
						} else {
							$fields[$row->Field]['select_alias'] = $_POST['select_table_'.$row->Field];
						}
						$fields[$row->Field]['select_condition'] = $_POST['select_condition_'.$row->Field];
						$select[] = $row->Field;

					} else {
						$fields[$row->Field]['type'] = 'input';
					}
					if(isset($_POST['column_'.$row->Field]) == 1) {
						$columns[] = $row->Field;
					}
					if(isset($_POST['link_'.$row->Field]) == 1) {
						$links[$row->Field] = $row->Field;
					}
					if(isset($_POST['filter_'.$row->Field]) == 1) {
						$filters[] = $row->Field;
					}
					if(isset($_POST['upload_'.$row->Field]) == 1) {
						$upload[] = $row->Field;
					}

					$read[$row->type_field_generator][] = $row->Field;

					if(isset($_POST['save_'.$row->Field]) == 1) {
						$save[$row->type_field_generator][] = $row->Field;
					}
					if(isset($_POST['main_field']) == 1 && $_POST['main_field'] == $u) {
						$data['main_field'] = $row->Field;
					}
					if(isset($_POST['datecreation']) == 1 && $_POST['datecreation'] == $u) {
						$data['datecreation'] = $row->Field;
					}
					if(isset($_POST['datemodification']) == 1 && $_POST['datemodification'] == $u) {
						$data['datemodification'] = $row->Field;
					}
					$content .= '<tr>';
					$content .= '<td>'.$row->Field.'</td>';
					$content .= '<td>'.form_checkbox('column_'.$row->Field.'', '1', set_value('column_'.$row->Field), 'id="column_'.$row->Field.'" class="inputcheckbox"').'</td>';
					$content .= '<td>'.form_checkbox('link_'.$row->Field.'', '1', set_value('link_'.$row->Field), 'id="link_'.$row->Field.'" class="inputcheckbox"').'</td>';
					$content .= '<td>'.form_checkbox('filter_'.$row->Field.'', '1', set_value('filter_'.$row->Field), 'id="filter_'.$row->Field.'" class="inputcheckbox"').'</td>';
					if($row->Key == 'PRI') {
						$content .= '<td>&nbsp;</td>';
					} else {
						$content .= '<td>'.form_checkbox('save_'.$row->Field.'', '1', set_value('save_'.$row->Field), 'id="save_'.$row->Field.'" class="inputcheckbox"').'</td>';
					}
					if(stristr($row->Type, 'varchar') && !stristr($row->Field, 'email')) {
						$content .= '<td>'.form_checkbox('upload_'.$row->Field.'', '1', set_value('upload_'.$row->Field), 'id="upload_'.$row->Field.'" class="inputcheckbox"').'</td>';
					} else {
						$content .= '<td>&nbsp;</td>';
					}
					$content .= '<td>'.form_radio('main_field', $u, set_radio('main_field', $u, TRUE), 'id="main_field_'.$row->Field.'" class="inputradio"').'</td>';
					if($row->Key == 'PRI' || !stristr($row->Type, 'datetime')) {
						$content .= '<td>&nbsp;</td>';
						$content .= '<td>&nbsp;</td>';
					} else {
						$content .= '<td>'.form_radio('datecreation', $u, set_radio('datecreation', $u, TRUE), 'id="datecreation_'.$row->Field.'_'.$u.'" class="inputradio"').'</td>';
						$content .= '<td>'.form_radio('datemodification', $u, set_radio('datemodification', $u, TRUE), 'id="datemodification_'.$row->Field.'_'.$u.'" class="inputradio"').'</td>';
					}
					$content .= '</tr>';
					if($row->Key != 'PRI' && substr($row->Type, 0, 3) == 'int') {
						$content .= '<tr>';
						$content .= '<td>&nbsp;</td>';
						$content .= '<td colspan="8"><div class="filters">
						<div>'.form_label('Champ clé', 'select_key_'.$row->Field).form_input('select_key_'.$row->Field.'', set_value('select_key_'.$row->Field), 'id="select_key_'.$row->Field.'" class="inputtext"').'</div>
						<div>'.form_label('Champ titre', 'select_label_'.$row->Field).form_input('select_label_'.$row->Field.'', set_value('select_label_'.$row->Field), 'id="select_label_'.$row->Field.'" class="inputtext"').'</div>
						<div>'.form_label('Table', 'select_table_'.$row->Field).form_input('select_table_'.$row->Field.'', set_value('select_table_'.$row->Field), 'id="select_table_'.$row->Field.'" class="inputtext"').'</div>
						<div>'.form_label('Alias', 'select_alias_'.$row->Field).form_input('select_alias_'.$row->Field.'', set_value('select_alias_'.$row->Field), 'id="select_alias_'.$row->Field.'" class="inputtext"').'</div>
						<div>'.form_label('Condition', 'select_condition_'.$row->Field).form_input('select_condition_'.$row->Field.'', set_value('select_condition_'.$row->Field), 'id="select_condition_'.$row->Field.'" class="inputtext"').'</div>
						</div></td>';
						$content .= '</tr>';
					}
					$u++;
				}
			}

			$content .= '<tr>';
			$content .= '<td>&nbsp;</td>';
			$content .= '<td>&nbsp;</td>';
			$content .= '<td>&nbsp;</td>';
			$content .= '<td>&nbsp;</td>';
			$content .= '<td>&nbsp;</td>';
			$content .= '<td>&nbsp;</td>';
			$content .= '<td>&nbsp;</td>';
			$content .= '<td>'.form_radio('datecreation', $u, set_radio('datecreation', $u, TRUE), 'id="datecreation_'.$row->Field.'_'.$u.'" class="inputradio"').'</td>';
			$content .= '<td>'.form_radio('datemodification', $u, set_radio('datemodification', $u, TRUE), 'id="datemodification_'.$row->Field.'_'.$u.'" class="inputradio"').'</td>';
			$content .= '</tr>';
			$content .= '</tbody>';
			$content .= '</table>';

			$content .= '<p>'.form_label('table alias *', 'table_alias').form_input('table_alias', set_value('table_alias', $table), 'id="table_alias" class="inputtext required"').'</p>';

			if($table_translation) {
				$content .= '<p>'.form_label('translation table alias *', 'table_translation_alias').form_input('table_translation_alias', set_value('table_translation_alias', $table_translation), 'id="table_translation_alias" class="inputtext required"').'</p>';
				$content .= '<p>'.form_label('language field', 'language_field').form_dropdown('language_field', $select_language, set_value('language_field'), 'id="language_field" class="select required"').'</p>';
			}

			$content .= '<p>'.form_label('write files', 'write').form_checkbox('write', '1', set_checkbox('write', '1'), 'id="write" class="inputcheckbox numeric"').'</p>';
			$content .= '<p>'.form_label('Create', 'action_create').form_checkbox('action_create', '1', set_checkbox('action_create', '1', TRUE), 'id="action_create" class="inputcheckbox numeric"').'</p>';
			$content .= '<p>'.form_label('Read', 'action_read').form_checkbox('action_read', '1', set_checkbox('action_read', '1', TRUE), 'id="action_read" class="inputcheckbox numeric"').'</p>';
			$content .= '<p>'.form_label('Update', 'action_update').form_checkbox('action_update', '1', set_checkbox('action_update', '1', TRUE), 'id="action_update" class="inputcheckbox numeric"').'</p>';
			$content .= '<p>'.form_label('Delete', 'action_delete').form_checkbox('action_delete', '1', set_checkbox('action_delete', '1', TRUE), 'id="action_delete" class="inputcheckbox numeric"').'</p>';

			$content .= '<p>'.form_label('Statistics', 'action_statistics').form_checkbox('action_statistics', '1', set_checkbox('action_statistics', '1', FALSE), 'id="action_statistics" class="inputcheckbox numeric"').'</p>';
			$content .= '<p>'.form_label('Export', 'action_export').form_checkbox('action_export', '1', set_checkbox('action_export', '1', FALSE), 'id="action_export" class="inputcheckbox numeric"').'</p>';

			$content .= '<p><span class="label">&nbsp;</span>'.form_submit('action1', 'OK', 'id="action1" class="inputsubmit"').'</p>';
			$content .= form_close();

			$data['table'] = $table;
			$data['table_translation'] = $table_translation;
			$data['fields'] = $fields;
			$data['fields'] = $fields;
			$data['columns'] = $columns;
			$data['links'] = $links;
			$data['filters'] = $filters;
			$data['upload'] = $upload;
			$data['boolean'] = $boolean;
			$data['callback'] = $callback;

			$data['read'] = $read['main'];
			$data['read_translation'] = $read['translation'];

			$data['save'] = $save['main'];
			$data['save_translation'] = $save['translation'];
			$data['select'] = $select;
			$data['action_create'] = $this->input->post('action_create');
			$data['action_read'] = $this->input->post('action_read');
			$data['action_update'] = $this->input->post('action_update');
			$data['action_delete'] = $this->input->post('action_delete');

			$data['action_statistics'] = $this->input->post('action_statistics');
			$data['action_export'] = $this->input->post('action_export');

			if(count($_POST) > 0) {
				if(count($upload) > 0) {
					if(!is_dir(FCPATH.'storage/'.$table)) {
						mkdir(FCPATH.'storage/'.$table);
						copy(FCPATH.'storage/index.html', FCPATH.'storage/'.$table.'/index.html');
					}
					foreach($upload as $field) {
						if(!is_dir(FCPATH.'storage/'.$table.'/'.$field)) {
							mkdir(FCPATH.'storage/'.$table.'/'.$field);
							copy(FCPATH.'storage/index.html', FCPATH.'storage/'.$table.'/'.$field.'/index.html');
						}
					}
				}

				$data['table_alias'] = $this->input->post('table_alias');
				if($table_translation) {
					$data['table_translation_alias'] = $this->input->post('table_translation_alias');
					$data['language_field'] = $this->input->post('language_field');
				}

				$folder = '';

				if(!is_dir(APPPATH.'views/'.$folder.$table)) {
					mkdir(APPPATH.'views/'.$folder.$table);
				}
				$str_replace = array('&lt;'=>'<', '&gt;'=>'>', '&amp;'=>'&');

				$content .= '<h3>'.APPPATH.'controllers/'.$folder.$table.'.php</h3>';
				$view = $this->load->view('_generator/_controller', $data, TRUE);
				if($this->input->post('write')) {
					$fp = fopen(APPPATH.'controllers/'.$folder.$table.'.php', 'w');
					fwrite($fp, str_replace(array_keys($str_replace), array_values($str_replace), $view));
					fclose($fp);
				}
				$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.$view.'</textarea>';

				$content .= '<h3>'.APPPATH.'views/'.$folder.$table.'/'.$table.'_index.php</h3>';
				$view = $this->load->view('_generator/_index', $data, TRUE);
				if($this->input->post('write')) {
					$fp = fopen(APPPATH.'views/'.$folder.$table.'/'.$table.'_index.php', 'w');
					fwrite($fp, str_replace(array_keys($str_replace), array_values($str_replace), $view));
					fclose($fp);
				}
				$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.$view.'</textarea>';

				if($this->input->post('action_statistics')) {
					$content .= '<h3>'.APPPATH.'views/'.$folder.$table.'/'.$table.'_statistics.php</h3>';
					$view = $this->load->view('_generator/_statistics', $data, TRUE);
					if($this->input->post('write')) {
						$fp = fopen(APPPATH.'views/'.$folder.$table.'/'.$table.'_statistics.php', 'w');
						fwrite($fp, str_replace(array_keys($str_replace), array_values($str_replace), $view));
						fclose($fp);
					}
					$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.$view.'</textarea>';
				} else {
					//@unlink(APPPATH.'views/'.$folder.$table.'/'.$table.'_statistics.php');
				}

				if($this->input->post('action_create')) {
					$content .= '<h3>'.APPPATH.'views/'.$folder.$table.'/'.$table.'_create.php</h3>';
					$view = $this->load->view('_generator/_create', $data, TRUE);
					if($this->input->post('write')) {
					$fp = fopen(APPPATH.'views/'.$folder.$table.'/'.$table.'_create.php', 'w');
					fwrite($fp, str_replace(array_keys($str_replace), array_values($str_replace), $view));
					fclose($fp);
					}
					$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.$view.'</textarea>';
				} else {
					//@unlink(APPPATH.'views/'.$folder.$table.'/'.$table.'_create.php');
				}

				if($this->input->post('action_read')) {
					$content .= '<h3>'.APPPATH.'views/'.$folder.$table.'/'.$table.'_read.php</h3>';
					$view = $this->load->view('_generator/_read', $data, TRUE);
					if($this->input->post('write')) {
						$fp = fopen(APPPATH.'views/'.$folder.$table.'/'.$table.'_read.php', 'w');
						fwrite($fp, str_replace(array_keys($str_replace), array_values($str_replace), $view));
						fclose($fp);
					}
					$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.$view.'</textarea>';
				} else {
					//@unlink(APPPATH.'views/'.$folder.$table.'/'.$table.'_read.php');
				}

				if($this->input->post('action_update')) {
					$content .= '<h3>'.APPPATH.'views/'.$folder.$table.'/'.$table.'_update.php</h3>';
					$view = $this->load->view('_generator/_update', $data, TRUE);
					if($this->input->post('write')) {
						$fp = fopen(APPPATH.'views/'.$folder.$table.'/'.$table.'_update.php', 'w');
						fwrite($fp, str_replace(array_keys($str_replace), array_values($str_replace), $view));
						fclose($fp);
					}
					$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.$view.'</textarea>';
				} else {
					//@unlink(APPPATH.'views/'.$folder.$table.'/'.$table.'_update.php');
				}

				if($this->input->post('action_delete')) {
					$content .= '<h3>'.APPPATH.'views/'.$folder.$table.'/'.$table.'_delete.php</h3>';
					$view = $this->load->view('_generator/_delete', $data, TRUE);
					if($this->input->post('write')) {
						$fp = fopen(APPPATH.'views/'.$folder.$table.'/'.$table.'_delete.php', 'w');
						fwrite($fp, str_replace(array_keys($str_replace), array_values($str_replace), $view));
						fclose($fp);
					}
					$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.$view.'</textarea>';
				} else {
					//@unlink(APPPATH.'views/'.$folder.$table.'/'.$table.'_delete.php');
				}

				$content .= '<h3>'.APPPATH.'models/'.$folder.$table.'_model.php</h3>';
				$view = $this->load->view('_generator/_model', $data, TRUE);
				if($this->input->post('write')) {
					$fp = fopen(APPPATH.'models/'.$folder.$table.'_model.php', 'w');
					fwrite($fp, str_replace(array_keys($str_replace), array_values($str_replace), $view));
					fclose($fp);
				}
				$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.$view.'</textarea>';

				$content .= '<h3>'.APPPATH.'language/fr/backend_'.$table.'_lang.php</h3>';
				$view = $this->load->view('_generator/_lang', $data, TRUE);
				if($this->input->post('write')) {
					$fp = fopen(APPPATH.'language/fr/backend_'.$table.'_lang.php', 'w');
					fwrite($fp, str_replace(array_keys($str_replace), array_values($str_replace), $view));
					fclose($fp);
				}
				$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.$view.'</textarea>';

				$content .= '<h3>'.APPPATH.'language/en/backend_'.$table.'_lang.php</h3>';
				$view = $this->load->view('_generator/_lang', $data, TRUE);
				if($this->input->post('write')) {
					$fp = fopen(APPPATH.'language/en/backend_'.$table.'_lang.php', 'w');
					fwrite($fp, str_replace(array_keys($str_replace), array_values($str_replace), $view));
					fclose($fp);
				}
				$content .= '<textarea class="textarea" style="width: 97%;height:250px;">'.$view.'</textarea>';
			}
			$content .= '</article>';
		} else {
			redirect($this->my_url.'_generator');
		}
		$this->my_library->set_zone('content', $content);
	}
}
