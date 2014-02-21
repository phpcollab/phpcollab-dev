<?php
$left_join = array();
$field_join = array();
foreach($select as $v) {
	$left_join[] = 'LEFT JOIN \'.$this->db->dbprefix(\''.$fields[$v]['select_table'].'\').\' AS '.$fields[$v]['select_alias'].' ON '.$fields[$v]['select_alias'].'.'.$fields[$v]['select_key'].' = '.$table_alias.'.'.$v;
	$field_join[] = $fields[$v]['select_alias'].'.'.$fields[$v]['select_label'];
}
if($table_translation) {
	$left_join[] = 'LEFT JOIN \'.$this->db->dbprefix(\''.$table_translation.'\').\' AS '.$table_translation_alias.' ON '.$table_translation_alias.'.'.$language_field.' = \\\'\'.$this->config->item(\'language\').\'\\\' AND '.$table_translation_alias.'.'.$primary.' = '.$table_alias.'.'.$primary;
}
?>
&lt;?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class <?php echo $table; ?>_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_index_list() {
		$filters = array();
<?php foreach($filters as $v) { ?>		$filters[$this->router->class.'_<?php echo $table; ?>_<?php echo $v; ?>'] = array('<?php echo $$aliases[$v]; ?>.<?php echo $v; ?>', 'like');
<?php } ?>
		$flt = $this->my_library->build_filters($filters);
		$columns = array();
<?php foreach($columns as $v) { ?>		$columns[] = '<?php echo $$aliases[$v]; ?>.<?php echo $v; ?>';
<?php if(isset($fields[$v]['select_label']) == 1) { ?>		$columns[] = '<?php echo $fields[$v]['select_alias']; ?>.<?php echo $fields[$v]['select_label']; ?>';
<?php } ?>
<?php } ?>
		$col = $this->my_library->build_columns($this->router->class.'_<?php echo $table; ?>', $columns, '<?php echo $$aliases[$main_field]; ?>.<?php echo $main_field; ?>', 'ASC');
		$results = $this->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'_<?php echo $table; ?>');
		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'_<?php echo $table; ?>');
<?php foreach($select as $v) { ?>		$data['dropdown_<?php echo $v; ?>'] = $this->dropdown_<?php echo $v; ?>();
<?php } ?>
<?php if(count($boolean) > 0) { ?>		$data['dropdown_reply'] = $this->my_model->dropdown_reply();
<?php } ?>
		return $content = $this->load->view('<?php echo $table; ?>/<?php echo $table; ?>_index', $data, TRUE);
	}
	function get_total($flt) {
		$query = $this->db->query('SELECT COUNT(<?php echo $table_alias; ?>.<?php echo $primary; ?>) AS count FROM '.$this->db->dbprefix('<?php echo $table; ?>').' AS <?php echo $table_alias; ?> WHERE '.implode(' AND ', $flt));
		return $query->row();
	}
	function get_rows($flt, $num, $offset, $column) {
		$query = $this->db->query('SELECT <?php if(count($field_join) > 0) { ?><?php echo implode(', ', $field_join); ?>, <?php } ?><?php echo $table_alias; ?>.*<?php if($table_translation) { ?>, <?php echo $table_translation_alias; ?>.*<?php } ?> FROM '.$this->db->dbprefix('<?php echo $table; ?>').' AS <?php echo $table_alias; ?><?php if(count($left_join) > 0) { ?> <?php echo implode(' ', $left_join); ?><?php } ?> WHERE '.implode(' AND ', $flt).' GROUP BY <?php echo $table_alias; ?>.<?php echo $primary; ?> ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
		return $query->result();
	}
	function get_row($<?php echo $primary; ?>) {
		$query = $this->db->query('SELECT <?php if(count($field_join) > 0) { ?><?php echo implode(', ', $field_join); ?>, <?php } ?><?php echo $table_alias; ?>.*<?php if($table_translation) { ?>, <?php echo $table_translation_alias; ?>.*<?php } ?> FROM '.$this->db->dbprefix('<?php echo $table; ?>').' AS <?php echo $table_alias; ?><?php if(count($left_join) > 0) { ?> <?php echo implode(' ', $left_join); ?><?php } ?> WHERE <?php echo $table_alias; ?>.<?php echo $primary; ?> = ? GROUP BY <?php echo $table_alias; ?>.<?php echo $primary; ?>', array($<?php echo $primary; ?>));
		return $query->row();
	}
<?php foreach($select as $v) { ?>	function dropdown_<?php echo $v; ?>() {
		$select = array();
		$select[''] = '-';
		$query = $this->db->query('SELECT <?php echo $fields[$v]['select_alias']; ?>.<?php echo $fields[$v]['select_key']; ?> AS field_key, <?php echo $fields[$v]['select_alias']; ?>.<?php echo $fields[$v]['select_label']; ?> AS field_label FROM '.$this->db->dbprefix('<?php echo $fields[$v]['select_table']; ?>').' AS <?php echo $fields[$v]['select_alias']; ?><?php if($fields[$v]['select_condition'] != '') { ?> <?php echo $fields[$v]['select_condition']; ?><?php } ?> GROUP BY <?php echo $fields[$v]['select_alias']; ?>.<?php echo $fields[$v]['select_key']; ?> ORDER BY <?php echo $fields[$v]['select_alias']; ?>.<?php echo $fields[$v]['select_label']; ?> ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select[$row->field_key] = $row->field_label;
			}
		}
		return $select;
	}
<?php } ?>
}
