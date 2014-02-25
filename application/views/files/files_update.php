<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> | <a href="<?php echo $this->my_url; ?>files/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/files'); ?>"></i><?php echo $this->lang->line('files'); ?></a> | <i class="fa fa-wrench"></i><?php echo $row->fle_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>files/read/<?php echo $row->fle_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<?php if($this->auth_library->permission('files/delete/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>files/delete/<?php echo $row->fle_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>

	<?php } else if($this->auth_library->permission('files/delete/ifowner') && $row->fle_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>files/delete/<?php echo $row->fle_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('fle_owner').' *', 'fle_owner'); ?>
		<?php echo form_dropdown('fle_owner', $dropdown_fle_owner, set_value('fle_owner', $row->fle_owner), 'id="fle_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('fle_description'), 'fle_description'); ?>
		<?php echo form_textarea('fle_description', set_value('fle_description', $row->fle_description), 'id="fle_description" class="textarea"'); ?>
		</p>
	</div>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('fle_published'), 'fle_published'); ?>
		<?php echo form_checkbox('fle_published', '1', set_checkbox('fle_published', '1', value2boolean($row->fle_published, '1')), 'id="fle_published" class="inputcheckbox numeric"'); ?>
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
