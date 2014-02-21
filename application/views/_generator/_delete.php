<article class="title">
	<h2><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>"><?php if($icon) { ?><i class="fa fa-<?php echo $icon; ?>"></i><?php } ?>&lt;?php echo $this->lang->line('<?php echo $table; ?>'); ?&gt;</a> / <i class="fa fa-trash-o"></i>&lt;?php echo $row-><?php echo $main_field; ?>; ?&gt;</h2>
	<ul>
<?php if($action_read) { ?>	<li><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/read/&lt;?php echo $row-><?php echo $primary; ?>; ?&gt;"><i class="fa fa-eye"></i>&lt;?php echo $this->lang->line('read'); ?&gt;</a></li>
<?php } ?>
<?php if($action_update) { ?>	<li><a href="&lt;?php echo $this->my_url; ?&gt;<?php echo $table; ?>/update/&lt;?php echo $row-><?php echo $primary; ?>; ?&gt;"><i class="fa fa-wrench"></i>&lt;?php echo $this->lang->line('update'); ?&gt;</a></li>
<?php } ?>
	</ul>
</article>
<article>
	&lt;?php echo form_open(current_url()); ?&gt;
	&lt;?php echo validation_errors(); ?&gt;
	<div class="column1">
		<p>
		&lt;?php echo form_label($this->lang->line('confirm').' *', 'confirm'); ?&gt;
		&lt;?php echo form_checkbox('confirm', '1', FALSE, 'id="confirm" class="inputcheckbox"'); ?&gt;
		</p>
		<p>
		<span class="label">&amp;nbsp;</span>
		&lt;?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?&gt;
		</p>
	</div>
	&lt;?php echo form_close(); ?&gt;
</article>
