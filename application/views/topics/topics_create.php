<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> | <a href="<?php echo $this->my_url; ?>topics/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/topics'); ?>"></i><?php echo $this->lang->line('topics'); ?></a> | <i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('tcs_owner').' *', 'tcs_owner'); ?>
		<?php echo form_dropdown('tcs_owner', $dropdown_tcs_owner, set_value('tcs_owner', $this->phpcollab_member->mbr_id), 'id="tcs_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tcs_name').' *', 'tcs_name'); ?>
		<?php echo form_input('tcs_name', set_value('tcs_name', ''), 'id="tcs_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('pst_description').' *', 'pst_description'); ?>
		<?php echo form_textarea('pst_description', set_value('pst_description', ''), 'id="pst_description" class="textarea required"'); ?>
		</p>
	</div>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('tcs_status').' *', 'tcs_status'); ?>
		<?php echo form_dropdown('tcs_status', $this->my_model->dropdown_status(), set_value('tcs_status', $this->config->item('phpcollab/default/status')), 'id="tcs_status" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tcs_priority').' *', 'tcs_priority'); ?>
		<?php echo form_dropdown('tcs_priority', $this->my_model->dropdown_priority(), set_value('tcs_priority', $this->config->item('phpcollab/default/priority')), 'id="tcs_priority" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tcs_published'), 'tcs_published'); ?>
		<?php echo form_checkbox('tcs_published', '1', set_checkbox('tcs_published', '1'), 'id="tcs_published" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
