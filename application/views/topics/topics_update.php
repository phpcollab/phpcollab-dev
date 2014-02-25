<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> | <a href="<?php echo $this->my_url; ?>topics/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/topics'); ?>"></i><?php echo $this->lang->line('topics'); ?></a> | <i class="fa fa-wrench"></i><?php echo $row->tcs_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>topics/read/<?php echo $row->tcs_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<?php if($this->auth_library->permission('topics/delete/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>topics/delete/<?php echo $row->tcs_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>

	<?php } else if($this->auth_library->permission('topics/delete/ifowner') && $row->tcs_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>topics/delete/<?php echo $row->tcs_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('tcs_owner').' *', 'tcs_owner'); ?>
		<?php echo form_dropdown('tcs_owner', $dropdown_tcs_owner, set_value('tcs_owner', $row->tcs_owner), 'id="tcs_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tcs_name').' *', 'tcs_name'); ?>
		<?php echo form_input('tcs_name', set_value('tcs_name', $row->tcs_name), 'id="tcs_name" class="inputtext required"'); ?>
		</p>
	</div>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('tcs_status').' *', 'tcs_status'); ?>
		<?php echo form_dropdown('tcs_status', $this->my_model->dropdown_status(), set_value('tcs_status', $row->tcs_status), 'id="tcs_status" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tcs_priority').' *', 'tcs_priority'); ?>
		<?php echo form_dropdown('tcs_priority', $this->my_model->dropdown_priority(), set_value('tcs_priority', $row->tcs_priority), 'id="tcs_priority" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tcs_published'), 'tcs_published'); ?>
		<?php echo form_checkbox('tcs_published', '1', set_checkbox('tcs_published', '1', value2boolean($row->tcs_published, '1')), 'id="tcs_published" class="inputcheckbox numeric"'); ?>
		</p>
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
