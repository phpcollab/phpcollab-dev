<?php
if($org) {
?>

<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>organizations"><?php echo $this->lang->line('organizations'); ?></a></li>
<li><?php echo $org->name; ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('organization'); ?> : <?php echo $org->name; ?></h1>
<ul>
<li><a class="update" href="<?php echo base_url(); ?>organization/update/<?php echo $org->id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('details'); ?></h2>
<div class="box2">
<p><span class="label"><?php echo $this->lang->line('name'); ?></span><?php echo $org->name; ?></p>
</div>

</div>
</div>

<?php
}
?>
