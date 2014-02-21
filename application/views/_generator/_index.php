<article class="title">
	<h2><i class="fa fa-&lt;?php echo $this->config->item('phpcollab/icons/<?php echo $table; ?>') ?&gt;"></i>&lt;?php echo $this->lang->line('<?php echo $table; ?>'); ?&gt; (&lt;?php echo $position; ?&gt;)</h2>
	<ul>
<?php if($action_statistics) { ?>	<li><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/statistics"><i class="fa fa-bar-chart-o"></i>&lt;?php echo $this->lang->line('statistics'); ?&gt;</a></li>
<?php } ?>
<?php if($action_export) { ?>	<li><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/export"><i class="fa fa-upload"></i>&lt;?php echo $this->lang->line('export'); ?&gt;</a></li>
<?php } ?>
<?php if($action_create) { ?>	<li><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/create"><i class="fa fa-plus"></i>&lt;?php echo $this->lang->line('create'); ?&gt;</a></li>
<?php } ?>
	</ul>
</article>
<article>
<?php if(count($filters) > 0) { ?>	&lt;?php echo form_open(current_url()); ?&gt;
	<div class="filters">
		<?php foreach($filters as $v) { ?><div>
			&lt;?php echo form_label($this->lang->line('<?php echo $v; ?>'), '<?php echo $table; ?>_<?php echo $v; ?>'); ?&gt;
<?php if($fields[$v]['type'] == 'checkbox' && in_array($v, $boolean)) { ?>
			&lt;?php echo form_dropdown($this->router->class.'_<?php echo $table; ?>_<?php echo $v; ?>', $dropdown_reply, set_value($this->router->class.'_<?php echo $table; ?>_<?php echo $v; ?>', $this->session->userdata($this->router->class.'_<?php echo $table; ?>_<?php echo $v; ?>')), 'id="<?php echo $table; ?>_<?php echo $v; ?>" class="select"'); ?&gt;
<?php } else if($fields[$v]['type'] == 'dropdown') { ?>
			&lt;?php echo form_<?php echo $fields[$v]['type']; ?>($this->router->class.'_<?php echo $table; ?>_<?php echo $v; ?>', $dropdown_<?php echo $v; ?>, set_value($this->router->class.'_<?php echo $table; ?>_<?php echo $v; ?>', $this->session->userdata($this->router->class.'_<?php echo $table; ?>_<?php echo $v; ?>')), 'id="<?php echo $table; ?>_<?php echo $v; ?>" class="select"'); ?&gt;
<?php } else { ?>
			&lt;?php echo form_input($this->router->class.'_<?php echo $table; ?>_<?php echo $v; ?>', set_value($this->router->class.'_<?php echo $table; ?>_<?php echo $v; ?>', $this->session->userdata($this->router->class.'_<?php echo $table; ?>_<?php echo $v; ?>')), 'id="<?php echo $table; ?>_<?php echo $v; ?>" class="inputtext<?php if($fields[$v]['real_type'] == 'date') { ?> date<?php } ?>"'); ?&gt;
<?php } ?>
		</div>
		<?php } ?><div>
			&lt;?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?&gt;
		</div>
	</div>
	&lt;?php echo form_close(); ?&gt;
<?php } ?>
	&lt;?php if($rows) { ?&gt;
	<table>
		<thead>
		<tr>
		&lt;?php $i = 0; ?&gt;
<?php $u = 0; ?><?php foreach($columns as $v) { ?>			&lt;?php $this->my_library->display_column($this->router->class.'_<?php echo $table; ?>', $columns[$i++], $this->lang->line('<?php echo $v; ?>')); ?&gt;
<?php if(isset($fields[$v]['select_label']) == 1) { ?><?php $u++; ?>			&lt;?php $this->my_library->display_column($this->router->class.'_<?php echo $table; ?>', $columns[$i++], $this->lang->line('<?php echo $fields[$v]['select_label']; ?>')); ?&gt;
<?php } ?>
<?php $u++; ?><?php } ?>			<th>&amp;nbsp;</th>
		</tr>
		</thead>
		<tbody>
		&lt;?php foreach($rows as $row) { ?&gt;
		<tr>
<?php foreach($columns as $v) { ?>			<td><?php if(isset($links[$v]) == 1 && $action_read) { ?><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/read/&lt;?php echo $row-><?php echo $primary; ?>; ?&gt;">&lt;?php echo $row-><?php echo $v; ?>; ?&gt;</a><?php } else { ?><?php if($fields[$v]['type'] == 'checkbox' && in_array($v, $boolean)) { ?>&lt;?php echo $this->lang->line('reply_'.$row-><?php echo $v; ?>); ?&gt;<?php } else if($fields[$v]['type'] == 'input' && in_array($v, $upload)) { ?><img src="&lt;?php echo base_url(); ?&gt;storage/<?php echo $table; ?>/<?php echo $v; ?>/&lt;?php echo $row-><?php echo $v; ?>; ?&gt;" alt=""><?php } else { ?>&lt;?php echo $row-><?php echo $v; ?>; ?&gt;<?php } ?><?php } ?></td>
<?php if(isset($fields[$v]['select_label']) == 1) { ?>			<td>&lt;?php echo $row-><?php echo $fields[$v]['select_label']; ?>; ?&gt;</td>
<?php } ?>
<?php } ?>			<th>
<?php if($action_update) { ?>			<a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/update/&lt;?php echo $row-><?php echo $primary; ?>; ?&gt;"><i class="fa fa-wrench"></i>&lt;?php echo $this->lang->line('update'); ?&gt;</a>
<?php } ?>
<?php if($action_delete) { ?>			<a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/delete/&lt;?php echo $row-><?php echo $primary; ?>; ?&gt;"><i class="fa fa-trash-o"></i>&lt;?php echo $this->lang->line('delete'); ?&gt;</a>
<?php } ?>
			</th>
		</tr>
		&lt;?php } ?&gt;
		</tbody>
	</table>
	<div class="paging">
		&lt;?php echo $pagination; ?&gt;
	</div>
	&lt;?php } ?&gt;
</article>
