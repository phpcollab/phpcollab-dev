<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>tasks/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/tasks'); ?>"></i><?php echo $this->lang->line('tasks'); ?></a> / <i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<p>
		<?php echo form_label($this->lang->line('trk_id').' *', 'trk_id'); ?>
		<?php echo form_dropdown('trk_id', $dropdown_trk_id, set_value('trk_id', ''), 'id="trk_id" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mln_id'), 'mln_id'); ?>
		<?php echo form_dropdown('mln_id', $dropdown_mln_id, set_value('mln_id', ''), 'id="mln_id" class="select numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_owner').' *', 'tsk_owner'); ?>
		<?php echo form_dropdown('tsk_owner', $dropdown_tsk_owner, set_value('tsk_owner', ''), 'id="tsk_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_assigned'), 'tsk_assigned'); ?>
		<?php echo form_dropdown('tsk_assigned', $dropdown_tsk_assigned, set_value('tsk_assigned', ''), 'id="tsk_assigned" class="select numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_name').' *', 'tsk_name'); ?>
		<?php echo form_input('tsk_name', set_value('tsk_name', ''), 'id="tsk_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_description'), 'tsk_description'); ?>
		<?php echo form_textarea('tsk_description', set_value('tsk_description', ''), 'id="tsk_description" class="textarea"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_date_start'), 'tsk_date_start'); ?>
		<?php echo form_input('tsk_date_start', set_value('tsk_date_start', ''), 'id="tsk_date_start" class="inputtext date"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_date_due'), 'tsk_date_due'); ?>
		<?php echo form_input('tsk_date_due', set_value('tsk_date_due', ''), 'id="tsk_date_due" class="inputtext date"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_date_complete'), 'tsk_date_complete'); ?>
		<?php echo form_input('tsk_date_complete', set_value('tsk_date_complete', ''), 'id="tsk_date_complete" class="inputtext date"'); ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<?php echo form_label($this->lang->line('tsk_status').' *', 'tsk_status'); ?>
		<?php echo form_input('tsk_status', set_value('tsk_status', ''), 'id="tsk_status" class="inputtext required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_priority').' *', 'tsk_priority'); ?>
		<?php echo form_input('tsk_priority', set_value('tsk_priority', ''), 'id="tsk_priority" class="inputtext required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_parent'), 'tsk_parent'); ?>
		<?php echo form_dropdown('tsk_parent', $dropdown_tsk_parent, set_value('tsk_parent', ''), 'id="tsk_parent" class="select numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_completion').' *', 'tsk_completion'); ?>
		<?php echo form_input('tsk_completion', set_value('tsk_completion', ''), 'id="tsk_completion" class="inputtext required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_comments'), 'tsk_comments'); ?>
		<?php echo form_textarea('tsk_comments', set_value('tsk_comments', ''), 'id="tsk_comments" class="textarea"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_published'), 'tsk_published'); ?>
		<?php echo form_checkbox('tsk_published', '1', set_checkbox('tsk_published', '1'), 'id="tsk_published" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
