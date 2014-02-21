<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>profile"><i class="fa fa-user"></i><?php echo $this->phpcollab_member->mbr_name; ?></a></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<p>
		<?php echo form_label($this->lang->line('mbr_name').' *', 'mbr_name'); ?>
		<?php echo form_input('mbr_name', set_value('mbr_name', $this->phpcollab_member->mbr_name), 'id="mbr_name" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_description'), 'mbr_description'); ?>
		<?php echo form_textarea('mbr_description', set_value('mbr_description', $this->phpcollab_member->mbr_description), 'id="mbr_description" class="textarea"'); ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<?php echo form_label($this->lang->line('mbr_email').' *', 'mbr_email'); ?>
		<?php echo form_input('mbr_email', set_value('mbr_email', $this->phpcollab_member->mbr_email), 'maxlength="255" id="mbr_email" class="inputtext valid_email required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_email_confirm').' *', 'mbr_email_confirm'); ?>
		<?php echo form_input('mbr_email_confirm', set_value('mbr_email_confirm', $this->phpcollab_member->mbr_email), 'maxlength="255" id="mbr_email_confirm" class="inputtext valid_email required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_password'), 'mbr_password'); ?>
		<?php echo form_password('mbr_password', set_value('mbr_password'), 'id="mbr_password" class="inputpassword"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_password_confirm'), 'mbr_password_confirm'); ?>
		<?php echo form_password('mbr_password_confirm', set_value('mbr_password_confirm'), 'id="mbr_password_confirm" class="inputpassword"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
