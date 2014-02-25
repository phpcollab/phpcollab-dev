<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>statuses"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/statuses') ?>"></i><?php echo $this->lang->line('statuses'); ?></a> | <i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('stu_owner').' *', 'stu_owner'); ?>
		<?php echo form_dropdown('stu_owner', $dropdown_stu_owner, set_value('stu_owner', ''), 'id="stu_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('stu_name').' *', 'stu_name'); ?>
		<?php echo form_input('stu_name', set_value('stu_name', ''), 'id="stu_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('stu_isclosed'), 'stu_isclosed'); ?>
		<?php echo form_checkbox('stu_isclosed', '1', set_checkbox('stu_isclosed', '1'), 'id="stu_isclosed" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('stu_ordering').' *', 'stu_ordering'); ?>
		<?php echo form_input('stu_ordering', set_value('stu_ordering', '0'), 'id="stu_ordering" class="inputtext required numeric"'); ?>
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
