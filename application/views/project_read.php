<?php
if($pro) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><?php echo $pro->pro_name; ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $pro->pro_name; ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?>project/update/<?php echo $pro->pro_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('pro_name'); ?></span><?php echo $pro->pro_name; ?></p>
</div>

<div class="column1 columnlast">
</div>

</form>

</div>
</div>

<?php
}
?>
