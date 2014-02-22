<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>notes/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/notes'); ?>"></i><?php echo $this->lang->line('notes'); ?></a> / <i class="fa fa-wrench"></i><?php echo $row->nte_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>notes/read/<?php echo $row->nte_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>notes/delete/<?php echo $row->nte_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<p>
		<?php echo form_label($this->lang->line('nte_owner').' *', 'nte_owner'); ?>
		<?php echo form_dropdown('nte_owner', $dropdown_nte_owner, set_value('nte_owner', $row->nte_owner), 'id="nte_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('nte_name').' *', 'nte_name'); ?>
		<?php echo form_input('nte_name', set_value('nte_name', $row->nte_name), 'id="nte_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('nte_date').' *', 'nte_date'); ?>
		<?php echo form_input('nte_date', set_value('nte_date', $row->nte_date), 'id="nte_date" class="inputtext required date"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('nte_published'), 'nte_published'); ?>
		<?php echo form_checkbox('nte_published', '1', set_checkbox('nte_published', '1', value2boolean($row->nte_published, '1')), 'id="nte_published" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<?php echo form_label($this->lang->line('nte_description'), 'nte_description'); ?>
		<?php echo form_textarea('nte_description', set_value('nte_description', $row->nte_description), 'id="nte_description" class="textarea wysiwyg"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
