<article class="title">
	<h2><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>"><i class="fa fa-&lt;?php echo $this->config->item('phpcollab/icons/<?php echo $table; ?>') ?&gt;"></i>&lt;?php echo $this->lang->line('<?php echo $table; ?>'); ?&gt;</a> | <i class="fa fa-wrench"></i>&lt;?php echo $row-><?php echo $main_field; ?>; ?&gt;</h2>
	<ul>
<?php if($action_read) { ?>	<li><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/read/&lt;?php echo $row-><?php echo $primary; ?>; ?&gt;"><i class="fa fa-eye"></i>&lt;?php echo $this->lang->line('read'); ?&gt;</a></li>
<?php } ?>
<?php if($action_delete) { ?>	<li><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/delete/&lt;?php echo $row-><?php echo $primary; ?>; ?&gt;"><i class="fa fa-trash-o"></i>&lt;?php echo $this->lang->line('delete'); ?&gt;</a></li>
<?php } ?>
	</ul>
</article>
<article>
	&lt;?php echo <?php if(count($upload) > 0) { ?>form_open_multipart<?php } else { ?>form_open<?php } ?>(current_url()); ?&gt;
	&lt;?php echo validation_errors(); ?&gt;
	<div class="column half">
<?php foreach($save as $v) { ?>		<p>
		&lt;?php echo form_label($this->lang->line('<?php echo $v; ?>')<?php if(isset($fields[$v]['classes']['required']) == 1) { ?>.' *'<?php } ?>, '<?php echo $v; ?>'); ?&gt;
<?php if($fields[$v]['type'] == 'textarea') { ?>
		&lt;?php echo form_<?php echo $fields[$v]['type']; ?>('<?php echo $v; ?>', set_value('<?php echo $v; ?>', $row-><?php echo $v; ?>), 'id="<?php echo $v; ?>" class="textarea<?php if(count($fields[$v]['classes']) > 0) { ?> <?php echo implode(' ', $fields[$v]['classes']); ?><?php } ?>"'); ?&gt;
<?php } else if($fields[$v]['type'] == 'checkbox') { ?>
		&lt;?php echo form_<?php echo $fields[$v]['type']; ?>('<?php echo $v; ?>', '1', set_checkbox('<?php echo $v; ?>', '1', value2boolean($row-><?php echo $v; ?>, '1')), 'id="<?php echo $v; ?>" class="inputcheckbox<?php if(count($fields[$v]['classes']) > 0) { ?> <?php echo implode(' ', $fields[$v]['classes']); ?><?php } ?>"'); ?&gt;
<?php } else if($fields[$v]['type'] == 'dropdown') { ?>
		&lt;?php echo form_<?php echo $fields[$v]['type']; ?>('<?php echo $v; ?>', $dropdown_<?php echo $v; ?>, set_value('<?php echo $v; ?>', $row-><?php echo $v; ?>), 'id="<?php echo $v; ?>" class="select<?php if(count($fields[$v]['classes']) > 0) { ?> <?php echo implode(' ', $fields[$v]['classes']); ?><?php } ?>"'); ?&gt;
<?php } else if($fields[$v]['type'] == 'input' && in_array($v, $upload)) { ?>
		&lt;?php echo form_upload('<?php echo $v; ?>', FALSE, 'id="<?php echo $v; ?>" class="inputfile<?php if(count($fields[$v]['classes']) > 0) { ?> <?php echo implode(' ', $fields[$v]['classes']); ?><?php } ?>"'); ?&gt;
<?php } else { ?>
		&lt;?php echo form_<?php echo $fields[$v]['type']; ?>('<?php echo $v; ?>', set_value('<?php echo $v; ?>', $row-><?php echo $v; ?>), 'id="<?php echo $v; ?>" class="inputtext<?php if(count($fields[$v]['classes']) > 0) { ?> <?php echo implode(' ', $fields[$v]['classes']); ?><?php } ?>"'); ?&gt;
<?php } ?>
		</p>
<?php } ?>
<?php if($table_translation) { ?>
	</div>
	<div class="column half">
<?php foreach($save_translation as $v) { ?>		<p>
		&lt;?php echo form_label($this->lang->line('<?php echo $v; ?>')<?php if(isset($fields[$v]['classes']['required']) == 1) { ?>.' *'<?php } ?>, '<?php echo $v; ?>'); ?&gt;
<?php if($fields[$v]['type'] == 'textarea') { ?>
		&lt;?php echo form_<?php echo $fields[$v]['type']; ?>('<?php echo $v; ?>', set_value('<?php echo $v; ?>', $row-><?php echo $v; ?>), 'id="<?php echo $v; ?>" class="textarea<?php if(count($fields[$v]['classes']) > 0) { ?> <?php echo implode(' ', $fields[$v]['classes']); ?><?php } ?>"'); ?&gt;
<?php } else if($fields[$v]['type'] == 'checkbox') { ?>
		&lt;?php echo form_<?php echo $fields[$v]['type']; ?>('<?php echo $v; ?>', '1', set_checkbox('<?php echo $v; ?>', '1', value2boolean($row-><?php echo $v; ?>, '1')), 'id="<?php echo $v; ?>" class="inputcheckbox<?php if(count($fields[$v]['classes']) > 0) { ?> <?php echo implode(' ', $fields[$v]['classes']); ?><?php } ?>"'); ?&gt;
<?php } else if($fields[$v]['type'] == 'dropdown') { ?>
		&lt;?php echo form_<?php echo $fields[$v]['type']; ?>('<?php echo $v; ?>', $dropdown_<?php echo $v; ?>, set_value('<?php echo $v; ?>', $row-><?php echo $v; ?>), 'id="<?php echo $v; ?>" class="select<?php if(count($fields[$v]['classes']) > 0) { ?> <?php echo implode(' ', $fields[$v]['classes']); ?><?php } ?>"'); ?&gt;
<?php } else if($fields[$v]['type'] == 'input' && in_array($v, $upload)) { ?>
		&lt;?php echo form_upload('<?php echo $v; ?>', FALSE, 'id="<?php echo $v; ?>" class="inputfile<?php if(count($fields[$v]['classes']) > 0) { ?> <?php echo implode(' ', $fields[$v]['classes']); ?><?php } ?>"'); ?&gt;
<?php } else { ?>
		&lt;?php echo form_<?php echo $fields[$v]['type']; ?>('<?php echo $v; ?>', set_value('<?php echo $v; ?>', $row-><?php echo $v; ?>), 'id="<?php echo $v; ?>" class="inputtext<?php if(count($fields[$v]['classes']) > 0) { ?> <?php echo implode(' ', $fields[$v]['classes']); ?><?php } ?>"'); ?&gt;
<?php } ?>
		</p>
<?php } ?>
<?php }?>
		<p>
		<span class="label">&amp;nbsp;</span>
		&lt;?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?&gt;
		</p>
	</div>
	&lt;?php echo form_close(); ?&gt;
</article>
