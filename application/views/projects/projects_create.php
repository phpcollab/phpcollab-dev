<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<p>
		<?php echo form_label($this->lang->line('org_id').' *', 'org_id'); ?>
		<?php echo form_dropdown('org_id', $dropdown_org_id, set_value('org_id', $this->input->get('org_id')), 'id="org_id" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_owner').' *', 'prj_owner'); ?>
		<?php echo form_dropdown('prj_owner', $dropdown_prj_owner, set_value('prj_owner', $this->phpcollab_member->mbr_id), 'id="prj_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_name').' *', 'prj_name'); ?>
		<?php echo form_input('prj_name', set_value('prj_name', ''), 'id="prj_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_description'), 'prj_description'); ?>
		<?php echo form_textarea('prj_description', set_value('prj_description', ''), 'id="prj_description" class="textarea"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_date_start').' *', 'prj_date_start'); ?>
		<?php echo form_input('prj_date_start', set_value('prj_date_start', date('Y-m-d')), 'id="prj_date_start" class="inputtext required date"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_date_due'), 'prj_date_due'); ?>
		<?php echo form_input('prj_date_due', set_value('prj_date_due', ''), 'id="prj_date_due" class="inputtext date"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_date_complete'), 'prj_date_complete'); ?>
		<?php echo form_input('prj_date_complete', set_value('prj_date_complete', ''), 'id="prj_date_complete" class="inputtext date"'); ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<?php echo form_label($this->lang->line('prj_status').' *', 'prj_status'); ?>
		<?php echo form_dropdown('prj_status', $this->my_model->dropdown_status(), set_value('prj_status', 1), 'id="prj_status" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_priority').' *', 'prj_priority'); ?>
		<?php echo form_dropdown('prj_priority', $this->my_model->dropdown_priority(), set_value('prj_priority', 2), 'id="prj_priority" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_comments'), 'prj_comments'); ?>
		<?php echo form_textarea('prj_comments', set_value('prj_comments', ''), 'id="prj_comments" class="textarea"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_published'), 'prj_published'); ?>
		<?php echo form_checkbox('prj_published', '1', set_checkbox('prj_published', '1'), 'id="prj_published" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
