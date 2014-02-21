&lt;?php
$lang['<?php echo $table; ?>'] = '<?php echo $table; ?>';
<?php foreach($fields as $k => $v) { ?>$lang['<?php echo $k; ?>'] = '<?php echo $k; ?>';
<?php if(isset($fields[$k]['select_label']) == 1) { ?>$lang['<?php echo $fields[$k]['select_label']; ?>'] = '<?php echo $fields[$k]['select_label']; ?>';
<?php } ?>
<?php } ?>
