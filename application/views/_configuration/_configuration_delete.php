<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>_configuration"><i class="fa fa-gears"></i><?php echo $this->lang->line('configuration'); ?></a> | <i class="fa fa-trash-o"></i><?php echo $row->cfg_path; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>_configuration/read/<?php echo $row->cfg_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>_configuration/update/<?php echo $row->cfg_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('confirm').' *', 'confirm'); ?>
		<?php echo form_checkbox('confirm', '1', FALSE, 'id="confirm" class="inputcheckbox"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<div class="column half">
	</div>
	<?php echo form_close(); ?>
</article>
