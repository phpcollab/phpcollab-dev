<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>roles"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/roles') ?>"></i><?php echo $this->lang->line('roles'); ?></a> / <i class="fa fa-wrench"></i><?php echo $row->rol_code; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>roles/read/<?php echo $row->rol_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>roles/delete/<?php echo $row->rol_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<p>
		<?php echo form_label($this->lang->line('rol_code').' *', 'rol_code'); ?>
		<?php echo form_input('rol_code', set_value('rol_code', $row->rol_code), 'id="rol_code" class="inputtext required"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>