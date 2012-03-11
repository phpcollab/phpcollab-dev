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
<?php if($this->permissions['project_update_all'] == 1 || ($this->permissions['project_update_owned'] == 1 && $pro->owner == $this->member->id)) { ?><li><a class="update" href="<?php echo base_url(); ?>project/update/<?php echo $pro->id; ?>"><?php echo $this->lang->line('update'); ?></a></li><?php } ?>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('details'); ?></h2>
<div class="box2">
<p><span class="label"><?php echo $this->lang->line('name'); ?></span><?php echo $pro->name; ?></p>
<p><span class="label"><?php echo $this->lang->line('project_id'); ?></span><?php echo $pro->id; ?></p>
<p><span class="label"><?php echo $this->lang->line('priority'); ?></span><img src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('phpcollab_theme'); ?>/<?php echo $pro->priority; ?>.gif" alt=""> <?php echo $this->lang->line('priority_'.$pro->priority); ?></p>
<p><span class="label"><?php echo $this->lang->line('description'); ?></span><?php echo $pro->description; ?>&nbsp;</p>
<p><span class="label"><?php echo $this->lang->line('url_dev'); ?></span><?php echo $pro->url_dev; ?>&nbsp;</p>
<p><span class="label"><?php echo $this->lang->line('url_prod'); ?></span><?php echo $pro->url_prod; ?>&nbsp;</p>
<p><span class="label"><?php echo $this->lang->line('created'); ?></span><?php echo $pro->created; ?></p>
<p><span class="label"><?php echo $this->lang->line('modified'); ?></span><?php echo $pro->modified; ?>&nbsp;</p>
<?php if($org) { ?><p><span class="label"><?php echo $this->lang->line('organization'); ?></span><a href="<?php echo base_url(); ?>organization/read/<?php echo $org->id; ?>"><?php echo $org->name; ?></a></p><?php } ?>
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
