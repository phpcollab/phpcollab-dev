<article class="title">
	<h2><i class="fa fa-sign-in"></i><?php echo $this->lang->line('login'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url().'?uri_string='.urlencode($this->input->get('uri_string'))); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('mbr_email').' *', 'mbr_email'); ?>
		<?php echo form_input('mbr_email', set_value('mbr_email'), 'id="mbr_email" class="inputtext required valid_email"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('mbr_password').' *', 'mbr_password'); ?>
		<?php echo form_password('mbr_password', set_value('mbr_password'), 'id="mbr_password" class="inputpassword required"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<?php echo form_close(); ?>
</article>
