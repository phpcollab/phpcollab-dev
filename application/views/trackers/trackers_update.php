<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>trackers"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/trackers') ?>"></i><?php echo $this->lang->line('trackers'); ?></a> / <i class="fa fa-wrench"></i><?php echo $row->trk_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>trackers/read/<?php echo $row->trk_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>trackers/delete/<?php echo $row->trk_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<p>
		<?php echo form_label($this->lang->line('trk_owner').' *', 'trk_owner'); ?>
		<?php echo form_dropdown('trk_owner', $dropdown_trk_owner, set_value('trk_owner', $row->trk_owner), 'id="trk_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('trk_name').' *', 'trk_name'); ?>
		<?php echo form_input('trk_name', set_value('trk_name', $row->trk_name), 'id="trk_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('tsk_description'), 'tsk_description'); ?>
		<?php echo form_textarea('tsk_description', set_value('tsk_description', $row->tsk_description), 'id="tsk_description" class="textarea"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>