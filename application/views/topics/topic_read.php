<?php
if($tpc) {
?>

<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><a href="<?php echo base_url(); ?>project/read/<?php echo $pro->id; ?>"><?php echo $pro->name; ?></a></li>
<li><a href="<?php echo base_url(); ?>topics/index/<?php echo $pro->id; ?>"><?php echo $this->lang->line('discussions'); ?></a></li>
<li><?php echo $tpc->subject; ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('topic'); ?> : <?php echo $tpc->subject; ?></h1>
<ul>
<li><a class="update" href="<?php echo base_url(); ?>topic/update/<?php echo $tpc->id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('info'); ?></h2>
<div class="box2">
<p><span class="label"><?php echo $this->lang->line('project'); ?></span><a href="<?php echo base_url(); ?>project/read/<?php echo $pro->id; ?>"><?php echo $pro->name; ?></a></p>
<p><span class="label"><?php echo $this->lang->line('organization'); ?></span><a href="<?php echo base_url(); ?>organization/read/<?php echo $org->id; ?>"><?php echo $org->name; ?></a></p>
</div>

<h2><?php echo $this->lang->line('details'); ?></h2>
<div class="box2">
<p><span class="label"><?php echo $this->lang->line('name'); ?></span><?php echo $tpc->subject; ?></p>
<p><span class="label"><?php echo $this->lang->line('status'); ?></span><?php echo $this->lang->line('status_'.$tpc->status); ?></p>
</div>

</form>

</div>
</div>

<?php
}
?>
