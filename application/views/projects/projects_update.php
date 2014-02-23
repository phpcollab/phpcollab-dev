<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <i class="fa fa-wrench"></i><?php echo $row->prj_name; ?></h2>
	<ul>
	<?php if($this->auth_library->permission('projects/read/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>

	<?php } else if($this->auth_library->permission('projects/read/ifowner') && $row->prj_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>

	<?php } else if($this->auth_library->permission('projects/read/ifmember') && $row->ismember == 1) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<?php } ?>

	<?php if($this->auth_library->permission('projects/delete/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/delete/<?php echo $row->prj_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>

	<?php } else if($this->auth_library->permission('projects/delete/ifowner') && $row->prj_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/delete/<?php echo $row->prj_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>

	<?php } else if($this->auth_library->permission('projects/delete/ifmember') && $row->ismember == 1) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/delete/<?php echo $row->prj_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('organization').' *', 'org_id'); ?>
		<?php echo form_dropdown('org_id', $dropdown_org_id, set_value('org_id', $row->org_id), 'id="org_id" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_owner').' *', 'prj_owner'); ?>
		<?php echo form_dropdown('prj_owner', $dropdown_prj_owner, set_value('prj_owner', $row->prj_owner), 'id="prj_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_name').' *', 'prj_name'); ?>
		<?php echo form_input('prj_name', set_value('prj_name', $row->prj_name), 'id="prj_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_description'), 'prj_description'); ?>
		<?php echo form_textarea('prj_description', set_value('prj_description', $row->prj_description), 'id="prj_description" class="textarea"'); ?>
		</p>
		<?php if($this->auth_library->permission('projects/update/date_start')) { ?>
			<p>
			<?php echo form_label($this->lang->line('prj_date_start').' *', 'prj_date_start'); ?>
			<?php echo form_input('prj_date_start', set_value('prj_date_start', $row->prj_date_start), 'id="prj_date_start" class="inputtext required date"'); ?>
			</p>
		<?php } ?>
		<?php if($this->auth_library->permission('projects/update/date_due')) { ?>
			<p>
			<?php echo form_label($this->lang->line('prj_date_due'), 'prj_date_due'); ?>
			<?php echo form_input('prj_date_due', set_value('prj_date_due', $row->prj_date_due), 'id="prj_date_due" class="inputtext date"'); ?>
			</p>
		<?php } ?>
		<?php if($this->auth_library->permission('projects/update/date_complete')) { ?>
			<p>
			<?php echo form_label($this->lang->line('prj_date_complete'), 'prj_date_complete'); ?>
			<?php echo form_input('prj_date_complete', set_value('prj_date_complete', $row->prj_date_complete), 'id="prj_date_complete" class="inputtext date"'); ?>
			</p>
		<?php } ?>
	</div>
	<div class="column half">
		<?php if($this->auth_library->permission('projects/update/status')) { ?>
			<p>
			<?php echo form_label($this->lang->line('prj_status').' *', 'prj_status'); ?>
			<?php echo form_dropdown('prj_status', $this->my_model->dropdown_status(), set_value('prj_status', $row->prj_status), 'id="prj_status" class="select required numeric"'); ?>
			</p>
		<?php } ?>
		<?php if($this->auth_library->permission('projects/update/priority')) { ?>
			<p>
			<?php echo form_label($this->lang->line('prj_priority').' *', 'prj_priority'); ?>
			<?php echo form_dropdown('prj_priority', $this->my_model->dropdown_priority(), set_value('prj_priority', $row->prj_priority), 'id="prj_priority" class="select required numeric"'); ?>
			</p>
		<?php } ?>
		<?php if($this->auth_library->permission('projects/update/published')) { ?>
			<p>
			<?php echo form_label($this->lang->line('prj_published'), 'prj_published'); ?>
			<?php echo form_checkbox('prj_published', '1', set_checkbox('prj_published', '1', value2boolean($row->prj_published, '1')), 'id="prj_published" class="inputcheckbox numeric"'); ?>
			</p>
		<?php } ?>
		<p>
		<?php echo form_label($this->lang->line('log_comments'), 'log_comments'); ?>
		<?php echo form_textarea('log_comments', set_value('log_comments', ''), 'id="log_comments" class="textarea"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
