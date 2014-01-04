<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>preferences"><?php echo $this->lang->line('preferences'); ?></a></li>
<li><?php echo $this->lang->line('user_profile'); ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('user_profile'); ?></h1>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<h2><?php echo $this->lang->line('edit_user_account'); ?></h2>
<div class="box2">
<p><?php echo form_label($this->lang->line('full_name').' *', 'name'); ?><?php echo form_input('name', set_value('name', $mbr->name), 'id="name" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('title'), 'title'); ?><?php echo form_input('title', set_value('title', $mbr->title), 'id="title" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('email'), 'email_work'); ?><?php echo form_input('email_work', set_value('email_work', $mbr->email_work), 'id="email_work" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('work_phone'), 'phone_work'); ?><?php echo form_input('phone_work', set_value('phone_work', $mbr->phone_work), 'id="phone_work" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('home_phone'), 'phone_home'); ?><?php echo form_input('phone_home', set_value('phone_home', $mbr->phone_home), 'id="phone_home" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('mobile_phone'), 'mobile'); ?><?php echo form_input('mobile', set_value('mobile', $mbr->mobile), 'id="mobile" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('fax'), 'fax'); ?><?php echo form_input('fax', set_value('fax', $mbr->fax), 'id="fax" class="inputtext"'); ?></p>
<p><span class="label"><?php echo $this->lang->line('permissions'); ?></span><?php echo $this->lang->line('profile_'.$mbr->profil); ?></p>
<p><span class="label"><?php echo $this->lang->line('account_created'); ?></span><?php echo $mbr->created; ?></p>
<p><span class="label">&nbsp;</span><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('save'); ?>"></p>
</div>

</form>

</div>
</div>
