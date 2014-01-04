<div id="box-breadcrumbs">
<ul>
<li class="first">&nbsp;</li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('login'); ?></h1>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<h2><?php echo $this->lang->line('please_login'); ?></h2>
<div class="box2">
<p><?php echo form_label($this->lang->line('user_name').' *', 'user_name'); ?><?php echo form_input('user_name', set_value('user_name'), 'id="user_name" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('password').' *', 'password'); ?><?php echo form_password('password', set_value('password'), 'id="password" class="inputpassword"'); ?></p>
<p><span class="label">&nbsp;</span><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('login'); ?>"></p>
</div>

</form>

</div>
</div>
