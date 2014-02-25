<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <i class="fa fa-trash-o"></i><?php echo $row->prj_name; ?></h2>
	<ul>
	<?php if($this->auth_library->permission('projects/read/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>

	<?php } else if($this->auth_library->permission('projects/read/ifowner') && $row->prj_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>

	<?php } else if($this->auth_library->permission('projects/read/ifmember') && $row->ismember == 1) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<?php } ?>

	<?php if($this->auth_library->permission('projects/update/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/update/<?php echo $row->prj_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>

	<?php } else if($this->auth_library->permission('projects/update/ifowner') && $row->prj_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/update/<?php echo $row->prj_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>

	<?php } else if($this->auth_library->permission('projects/update/ifmember') && $row->ismember == 1) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects/update/<?php echo $row->prj_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('confirm').' *', 'confirm'); ?>
		<?php echo form_checkbox('confirm', '1', FALSE, 'id="confirm" class="inputcheckbox"'); ?>
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
