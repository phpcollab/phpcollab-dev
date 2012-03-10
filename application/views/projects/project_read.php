<?php
if($pro) {
?>

<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><?php echo $pro->name; ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('project'); ?> : <?php echo $pro->name; ?></h1>
<ul>
<li><a class="update" href="<?php echo base_url(); ?>project/update/<?php echo $pro->id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('details'); ?></h2>
<div class="box2">
<p><span class="label"><?php echo $this->lang->line('name'); ?></span><?php echo $pro->name; ?></p>
<p><span class="label"><?php echo $this->lang->line('priority'); ?></span><img src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('phpcollab_theme'); ?>/<?php echo $pro->priority; ?>.gif" alt=""> <?php echo $this->lang->line('priority_'.$pro->priority); ?></p>
<p><span class="label"><?php echo $this->lang->line('url_dev'); ?></span><?php echo $pro->url_dev; ?></p>
<p><span class="label"><?php echo $this->lang->line('url_prod'); ?></span><?php echo $pro->url_prod; ?></p>
<p><span class="label"><?php echo $this->lang->line('organization'); ?></span><a href="<?php echo base_url(); ?>organization/read/<?php echo $org->id; ?>"><?php echo $org->name; ?></a></p>
<p><span class="label"><?php echo $this->lang->line('status'); ?></span><?php echo $this->lang->line('status_'.$pro->status); ?></p>
</div>

<h2><?php echo $this->lang->line('support'); ?></h2>
<div class="box2">
</div>

</form>

</div>
</div>

<?php
}
?>
