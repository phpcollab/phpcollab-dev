<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>files/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/files'); ?>"></i><?php echo $this->lang->line('files'); ?></a> / <i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open_multipart(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<p>
		<?php echo form_label($this->lang->line('fle_owner').' *', 'fle_owner'); ?>
		<?php echo form_dropdown('fle_owner', $dropdown_fle_owner, set_value('fle_owner', $this->phpcollab_member->mbr_id), 'id="fle_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('fle_name').' *', 'fle_name'); ?>
		<?php echo form_upload('fle_name', FALSE, 'id="fle_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('fle_description'), 'fle_description'); ?>
		<?php echo form_textarea('fle_description', set_value('fle_description', ''), 'id="fle_description" class="textarea"'); ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<?php echo form_label($this->lang->line('fle_comments'), 'fle_comments'); ?>
		<?php echo form_textarea('fle_comments', set_value('fle_comments', ''), 'id="fle_comments" class="textarea"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('fle_published'), 'fle_published'); ?>
		<?php echo form_checkbox('fle_published', '1', set_checkbox('fle_published', '1'), 'id="fle_published" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>