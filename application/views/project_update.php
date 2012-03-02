<?php
if($pro) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><a href="<?php echo base_url(); ?>project/read/<?php echo $pro->pro_id; ?>"><?php echo $pro->pro_name; ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $pro->pro_name; ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?>project/read/<?php echo $pro->pro_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('pro_name').' *', 'pro_name'); ?><?php echo form_input('pro_name', set_value('pro_name', $pro->pro_name), 'id="pro_name" class="inputtext"'); ?></p>
</div>

<div class="column1 columnlast">
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>

<?php
}
?>
