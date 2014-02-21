<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>members"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/members') ?>"></i><?php echo $this->lang->line('members'); ?></a> / <i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<p>
		<?php echo form_label($this->lang->line('org_id').' *', 'org_id'); ?>
		<?php echo form_dropdown('org_id', $dropdown_org_id, set_value('org_id', ''), 'id="org_id" class="select required numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_name').' *', 'mbr_name'); ?>
		<?php echo form_input('mbr_name', set_value('mbr_name', ''), 'id="mbr_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_description'), 'mbr_description'); ?>
		<?php echo form_textarea('mbr_description', set_value('mbr_description', ''), 'id="mbr_description" class="textarea"'); ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<?php echo form_label($this->lang->line('mbr_email').' *', 'mbr_email'); ?>
		<?php echo form_input('mbr_email', set_value('mbr_email', ''), 'id="mbr_email" class="inputtext required valid_email"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_password').' *', 'mbr_password'); ?>
		<?php echo form_password('mbr_password', set_value('mbr_password', ''), 'id="mbr_password" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_password_confirm'), 'mbr_password_confirm'); ?>
		<?php echo form_password('mbr_password_confirm', set_value('mbr_password_confirm'), 'id="mbr_password_confirm" class="inputpassword"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_authorized'), 'mbr_authorized'); ?>
		<?php echo form_checkbox('mbr_authorized', '1', set_checkbox('mbr_authorized', '1'), 'id="mbr_authorized" class="inputcheckbox numeric"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_comments'), 'mbr_comments'); ?>
		<?php echo form_textarea('mbr_comments', set_value('mbr_comments', ''), 'id="mbr_comments" class="textarea"'); ?>
		</p>
		<?php foreach($roles as $rol) { ?>
		<p>
		<?php echo form_label($rol->rol_code, 'rol_'.$rol->rol_id); ?>
		<?php echo form_checkbox('rol_'.$rol->rol_id, '1', set_checkbox('rol_'.$rol->rol_id, '1'), 'id="rol_'.$rol->rol_id.'" class="inputcheckbox"'); ?>
		</p>
		<?php } ?>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
