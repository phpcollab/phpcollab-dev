<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>projects_members/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects_members'); ?>"></i><?php echo $this->lang->line('projects_members'); ?></a> / <i class="fa fa-wrench"></i><?php echo $row->mbr_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>projects_members/read/<?php echo $row->prj_mbr_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>projects_members/delete/<?php echo $row->prj_mbr_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
mbr_name		<p>
		<?php echo form_label($this->lang->line('prj_mbr_authorized'), 'prj_mbr_authorized'); ?>
		<?php echo form_checkbox('prj_mbr_authorized', '1', set_checkbox('prj_mbr_authorized', '1', value2boolean($row->prj_mbr_authorized, '1')), 'id="prj_mbr_authorized" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('prj_mbr_published'), 'prj_mbr_published'); ?>
		<?php echo form_checkbox('prj_mbr_published', '1', set_checkbox('prj_mbr_published', '1', value2boolean($row->prj_mbr_published, '1')), 'id="prj_mbr_published" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
