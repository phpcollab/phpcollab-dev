<article class="title">
	<h2><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>"><i class="fa fa-&lt;?php echo $this->config->item('phpcollab/icons/<?php echo $table; ?>') ?&gt;"></i>&lt;?php echo $this->lang->line('<?php echo $table; ?>'); ?&gt;</a> / <i class="fa fa-eye"></i>&lt;?php echo $row-><?php echo $main_field; ?>; ?&gt;</h2>
	<ul>
<?php if($action_update) { ?>	<li><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/update/&lt;?php echo $row-><?php echo $primary; ?>; ?&gt;"><i class="fa fa-wrench"></i>&lt;?php echo $this->lang->line('update'); ?&gt;</a></li>
<?php } ?>
<?php if($action_delete) { ?>	<li><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/delete/&lt;?php echo $row-><?php echo $primary; ?>; ?&gt;"><i class="fa fa-trash-o"></i>&lt;?php echo $this->lang->line('delete'); ?&gt;</a></li>
<?php } ?>
	</ul>
</article>
<article>
	<div class="column1">
<?php foreach($read as $v) { ?>		<p>
		<span class="label">&lt;?php echo $this->lang->line('<?php echo $v; ?>'); ?&gt;</span>
<?php if($fields[$v]['type'] == 'checkbox' && in_array($v, $boolean)) { ?>
		&lt;?php echo $this->lang->line('reply_'.$row-><?php echo $v; ?>); ?&gt;
<?php } else if($fields[$v]['type'] == 'input' && in_array($v, $upload)) { ?>
		&lt;?php if($row-><?php echo $v; ?>) { ?&gt;<img src="<?php echo base_url(); ?>storage/<?php echo $table; ?>/<?php echo $v; ?>/&lt;?php echo $row-><?php echo $v; ?>; ?&gt;" alt="">&lt;?php } else { ?&gt;-&lt;?php } ?&gt;
<?php } else { ?>
		&lt;?php if($row-><?php echo $v; ?>) { ?&gt;&lt;?php echo $row-><?php echo $v; ?>; ?&gt;&lt;?php } else { ?&gt;-&lt;?php } ?&gt;
<?php } ?>
		</p>
<?php if(isset($fields[$v]['select_label']) == 1) { ?>		<p>
		<span class="label">&lt;?php echo $this->lang->line('<?php echo $fields[$v]['select_label']; ?>'); ?&gt;</span>
		&lt;?php if($row-><?php echo $fields[$v]['select_label']; ?>) { ?&gt;&lt;?php echo $row-><?php echo $fields[$v]['select_label']; ?>; ?&gt;&lt;?php } else { ?&gt;-&lt;?php } ?&gt;
		</p>
<?php } ?><?php } ?>
<?php if($table_translation) { ?>
	</div>
	<div class="column1 columnlast">
<?php foreach($read_translation as $v) { ?>		<p>
		<span class="label">&lt;?php echo $this->lang->line('<?php echo $v; ?>'); ?&gt;</span>
<?php if($fields[$v]['type'] == 'checkbox' && in_array($v, $boolean)) { ?>
		&lt;?php echo $this->lang->line('reply_'.$row-><?php echo $v; ?>); ?&gt;
<?php } else if($fields[$v]['type'] == 'input' && in_array($v, $upload)) { ?>
		&lt;?php if($row-><?php echo $v; ?>) { ?&gt;<img src="<?php echo base_url(); ?>storage/<?php echo $table; ?>/<?php echo $v; ?>/&lt;?php echo $row-><?php echo $v; ?>; ?&gt;" alt="">&lt;?php } else { ?&gt;-&lt;?php } ?&gt;
<?php } else { ?>
		&lt;?php if($row-><?php echo $v; ?>) { ?&gt;&lt;?php echo $row-><?php echo $v; ?>; ?&gt;&lt;?php } else { ?&gt;-&lt;?php } ?&gt;
<?php } ?>
		</p>
<?php if(isset($fields[$v]['select_label']) == 1) { ?>			<p>
		<span class="label">&lt;?php echo $this->lang->line('<?php echo $fields[$v]['select_label']; ?>'); ?&gt;</span>
		&lt;?php if($row-><?php echo $fields[$v]['select_label']; ?>) { ?&gt;&lt;?php echo $row-><?php echo $fields[$v]['select_label']; ?>; ?&gt;&lt;?php } else { ?&gt;-&lt;?php } ?&gt;
		</p>
<?php } ?><?php } ?>
<?php } ?>
	</div>
</article>
