<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>tasks/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/tasks'); ?>"></i><?php echo $this->lang->line('tasks'); ?></a> / <i class="fa fa-wrench"></i><?php echo $row->tsk_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>tasks/read/<?php echo $row->tsk_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<?php if($this->auth_library->permission('tasks/delete/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>tasks/delete/<?php echo $row->tsk_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>

	<?php } else if($this->auth_library->permission('tasks/delete/ifowner') && $row->tsk_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>tasks/delete/<?php echo $row->tsk_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article>
	<?php echo form_open_multipart(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('tracker').' *', 'trk_id'); ?>
		<?php echo form_dropdown('trk_id', $dropdown_trk_id, set_value('trk_id', $row->trk_id), 'id="trk_id" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('milestone'), 'mln_id'); ?>
		<?php echo form_dropdown('mln_id', $dropdown_mln_id, set_value('trk_id', $row->mln_id), 'id="mln_id" class="select numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_parent'), 'tsk_parent'); ?>
		<?php echo form_dropdown('tsk_parent', $dropdown_tsk_parent, set_value('tsk_parent', $row->tsk_parent), 'id="tsk_parent" class="select numeric"'); ?>
		</p>
		<?php if($this->auth_library->permission('tasks/update/owner')) { ?>
			<p>
			<?php echo form_label($this->lang->line('tsk_owner').' *', 'tsk_owner'); ?>
			<?php echo form_dropdown('tsk_owner', $dropdown_tsk_owner, set_value('tsk_owner', $row->tsk_owner), 'id="tsk_owner" class="select required numeric"'); ?>
			</p>
		<?php } ?>
		<?php if($this->auth_library->permission('tasks/update/assigned')) { ?>
			<p>
			<?php echo form_label($this->lang->line('tsk_assigned'), 'tsk_assigned'); ?>
			<?php echo form_dropdown('tsk_assigned', $dropdown_tsk_assigned, set_value('tsk_assigned', $row->tsk_assigned), 'id="tsk_assigned" class="select numeric"'); ?>
			</p>
		<?php } ?>
		<p>
		<?php echo form_label($this->lang->line('tsk_name').' *', 'tsk_name'); ?>
		<?php echo form_input('tsk_name', set_value('tsk_name', $row->tsk_name), 'id="tsk_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_description'), 'tsk_description'); ?>
		<?php echo form_textarea('tsk_description', set_value('tsk_description', $row->tsk_description), 'id="tsk_description" class="textarea"'); ?>
		</p>
		<?php if($this->auth_library->permission('tasks/update/date_start')) { ?>
			<p>
			<?php echo form_label($this->lang->line('tsk_date_start'), 'tsk_date_start'); ?>
			<?php echo form_input('tsk_date_start', set_value('tsk_date_start', $row->tsk_date_start), 'id="tsk_date_start" class="inputtext date"'); ?>
			</p>
		<?php } ?>
		<?php if($this->auth_library->permission('tasks/update/date_due')) { ?>
			<p>
			<?php echo form_label($this->lang->line('tsk_date_due'), 'tsk_date_due'); ?>
			<?php echo form_input('tsk_date_due', set_value('tsk_date_due', $row->tsk_date_due), 'id="tsk_date_due" class="inputtext date"'); ?>
			</p>
		<?php } ?>
		<?php if($this->auth_library->permission('tasks/update/date_complete')) { ?>
			<p>
			<?php echo form_label($this->lang->line('tsk_date_complete'), 'tsk_date_complete'); ?>
			<?php echo form_input('tsk_date_complete', set_value('tsk_date_complete', $row->tsk_date_complete), 'id="tsk_date_complete" class="inputtext date"'); ?>
			</p>
		<?php } ?>
	</div>
	<div class="column half">
		<?php if($this->auth_library->permission('tasks/update/status')) { ?>
			<p>
			<?php echo form_label($this->lang->line('tsk_status').' *', 'tsk_status'); ?>
			<?php echo form_dropdown('tsk_status', $this->my_model->dropdown_status(), set_value('tsk_status', $row->tsk_status), 'id="tsk_status" class="select required numeric"'); ?>
			</p>
		<?php } ?>
		<?php if($this->auth_library->permission('tasks/update/priority')) { ?>
			<p>
			<?php echo form_label($this->lang->line('tsk_priority').' *', 'tsk_priority'); ?>
			<?php echo form_dropdown('tsk_priority', $this->my_model->dropdown_priority(), set_value('tsk_priority', $row->tsk_priority), 'id="tsk_priority" class="select required numeric"'); ?>
			</p>
		<?php } ?>
		<p>
		<?php echo form_label($this->lang->line('tsk_completion').' *', 'tsk_completion'); ?>
		<?php echo form_dropdown('tsk_completion', $this->my_model->dropdown_completion(), set_value('tsk_completion', $row->tsk_completion), 'id="tsk_completion" class="select numeric"'); ?>
		</p>
		<?php if($this->auth_library->permission('tasks/update/published')) { ?>
			<p>
			<?php echo form_label($this->lang->line('tsk_published'), 'tsk_published'); ?>
			<?php echo form_checkbox('tsk_published', '1', set_checkbox('tsk_published', '1', value2boolean($row->tsk_published, '1')), 'id="tsk_published" class="inputcheckbox numeric"'); ?>
			</p>
		<?php } ?>
		<p>
		<?php echo form_label($this->lang->line('log_comments'), 'log_comments'); ?>
		<?php echo form_textarea('log_comments', set_value('log_comments', ''), 'id="log_comments" class="textarea"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('attachment').' (<em>'.ini_get('upload_max_filesize').' max.)</em>', 'att_name'); ?>
		<?php echo form_upload('att_name', FALSE, 'id="att_name" class="inputfile"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
