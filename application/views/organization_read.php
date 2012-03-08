<?php
if($org) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>organizations"><?php echo $this->lang->line('organizations'); ?></a></li>
<li><?php echo $org->name; ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('organization'); ?> : <?php echo $org->name; ?></h1>
<ul>
<li><a class="update" href="<?php echo base_url(); ?>organization/update/<?php echo $org->id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
</ul>
<div class="display">

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('name'); ?></span><?php echo $org->name; ?></p>
</div>

<div class="column1 columnlast">
</div>

</form>

</div>
</div>

<?php
}
?>
