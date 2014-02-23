<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>topics/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/topics'); ?>"></i><?php echo $this->lang->line('topics'); ?></a> / <a href="<?php echo $this->my_url; ?>topics/read/<?php echo $row->tcs_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/topics'); ?>"></i><?php echo $row->tcs_name; ?></a> / <i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('pst_description').' *', 'pst_description'); ?>
		<?php echo form_textarea('pst_description', set_value('pst_description', ''), 'id="pst_description" class="textarea required"'); ?>
		</p>
	</div>
	<div class="column half">
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
