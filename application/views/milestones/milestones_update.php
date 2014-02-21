<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>milestones/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/milestones'); ?>"></i><?php echo $this->lang->line('milestones'); ?></a> / <i class="fa fa-wrench"></i><?php echo $row->mln_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>milestones/read/<?php echo $row->mln_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>milestones/delete/<?php echo $row->mln_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<p>
		<?php echo form_label($this->lang->line('mln_owner').' *', 'mln_owner'); ?>
		<?php echo form_dropdown('mln_owner', $dropdown_mln_owner, set_value('mln_owner', $row->mln_owner), 'id="mln_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mln_name').' *', 'mln_name'); ?>
		<?php echo form_input('mln_name', set_value('mln_name', $row->mln_name), 'id="mln_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mln_description'), 'mln_description'); ?>
		<?php echo form_textarea('mln_description', set_value('mln_description', $row->mln_description), 'id="mln_description" class="textarea"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mln_date_start').' *', 'mln_date_start'); ?>
		<?php echo form_input('mln_date_start', set_value('mln_date_start', $row->mln_date_start), 'id="mln_date_start" class="inputtext required date"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mln_date_due'), 'mln_date_due'); ?>
		<?php echo form_input('mln_date_due', set_value('mln_date_due', $row->mln_date_due), 'id="mln_date_due" class="inputtext date"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mln_date_complete'), 'mln_date_complete'); ?>
		<?php echo form_input('mln_date_complete', set_value('mln_date_complete', $row->mln_date_complete), 'id="mln_date_complete" class="inputtext date"'); ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<?php echo form_label($this->lang->line('mln_status').' *', 'mln_status'); ?>
		<?php echo form_input('mln_status', set_value('mln_status', $row->mln_status), 'id="mln_status" class="inputtext required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mln_priority').' *', 'mln_priority'); ?>
		<?php echo form_input('mln_priority', set_value('mln_priority', $row->mln_priority), 'id="mln_priority" class="inputtext required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mln_comments'), 'mln_comments'); ?>
		<?php echo form_textarea('mln_comments', set_value('mln_comments', $row->mln_comments), 'id="mln_comments" class="textarea"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mln_published'), 'mln_published'); ?>
		<?php echo form_checkbox('mln_published', '1', set_checkbox('mln_published', '1', value2boolean($row->mln_published, '1')), 'id="mln_published" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
