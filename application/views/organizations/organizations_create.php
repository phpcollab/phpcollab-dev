<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>organizations"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/organizations'); ?>"></i><?php echo $this->lang->line('organizations'); ?></a> / <i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('org_owner').' *', 'org_owner'); ?>
		<?php echo form_dropdown('org_owner', $dropdown_org_owner, set_value('org_owner', $this->phpcollab_member->mbr_id), 'id="org_owner" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('org_name').' *', 'org_name'); ?>
		<?php echo form_input('org_name', set_value('org_name', ''), 'id="org_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('org_description'), 'org_description'); ?>
		<?php echo form_textarea('org_description', set_value('org_description', ''), 'id="org_description" class="textarea"'); ?>
		</p>
	</div>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('org_authorized'), 'org_authorized'); ?>
		<?php echo form_checkbox('org_authorized', '1', set_checkbox('org_authorized', '1'), 'id="org_authorized" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
