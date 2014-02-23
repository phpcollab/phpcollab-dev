<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>projects_members/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects_members'); ?>"></i><?php echo $this->lang->line('projects_members'); ?></a> / <i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('member').' *', 'mbr_id'); ?>
		<?php echo form_dropdown('mbr_id', $dropdown_mbr_id, set_value('mbr_id', ''), 'id="mbr_id" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_mbr_authorized'), 'prj_mbr_authorized'); ?>
		<?php echo form_checkbox('prj_mbr_authorized', '1', set_checkbox('prj_mbr_authorized', '1'), 'id="prj_mbr_authorized" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_mbr_published'), 'prj_mbr_published'); ?>
		<?php echo form_checkbox('prj_mbr_published', '1', set_checkbox('prj_mbr_published', '1'), 'id="prj_mbr_published" class="inputcheckbox numeric"'); ?>
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
