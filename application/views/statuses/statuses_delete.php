<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>statuses"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/statuses') ?>"></i><?php echo $this->lang->line('statuses'); ?></a> / <i class="fa fa-trash-o"></i><?php echo $row->stu_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>statuses/read/<?php echo $row->stu_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>statuses/update/<?php echo $row->stu_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<p>
		<?php echo form_label($this->lang->line('confirm').' *', 'confirm'); ?>
		<?php echo form_checkbox('confirm', '1', FALSE, 'id="confirm" class="inputcheckbox"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>