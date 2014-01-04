<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>preferences"><?php echo $this->lang->line('preferences'); ?></a></li>
<li><?php echo $this->lang->line('change_password'); ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('change_password'); ?></h1>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<h2><?php echo $this->lang->line('change_password_intro'); ?></h2>
<div class="box2">
<p><?php echo form_label($this->lang->line('old_password').' *', 'old_password'); ?><?php echo form_password('old_password', set_value('old_password'), 'id="old_password" class="inputpassword"'); ?></p>
<p><?php echo form_label($this->lang->line('new_password').' *', 'new_password'); ?><?php echo form_password('new_password', set_value('new_password'), 'id="new_password" class="inputpassword"'); ?></p>
<p><?php echo form_label($this->lang->line('confirm_password').' *', 'confirm_password'); ?><?php echo form_password('confirm_password', set_value('confirm_password'), 'id="confirm_password" class="inputpassword"'); ?></p>
<p><span class="label">&nbsp;</span><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('save'); ?>"></p>
</div>

</form>

</div>
</div>
