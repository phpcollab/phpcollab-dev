<?php
if($tsk) {
?>

<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><a href="<?php echo base_url(); ?>project/read/<?php echo $pro->id; ?>"><?php echo $pro->name; ?></a></li>
<li><a href="<?php echo base_url(); ?>tasks/index/<?php echo $pro->id; ?>"><?php echo $this->lang->line('tasks'); ?></a></li>
<li><?php echo $tsk->name; ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('task'); ?> : <?php echo $tsk->name; ?></h1>
<ul>
<li><a class="publish" href="<?php echo base_url(); ?>task/publish/<?php echo $tsk->id; ?>"><?php echo $this->lang->line('add_project_site'); ?></a></li>
<li><a class="unpublish" href="<?php echo base_url(); ?>task/unpublish/<?php echo $tsk->id; ?>"><?php echo $this->lang->line('remove_project_site'); ?></a></li>
<li><a class="update" href="<?php echo base_url(); ?>task/update/<?php echo $tsk->id; ?>"><?php echo $this->lang->line('edit'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('info'); ?></h2>
<div class="box2">
<p><span class="label"><?php echo $this->lang->line('project'); ?></span><a href="<?php echo base_url(); ?>project/read/<?php echo $pro->id; ?>"><?php echo $pro->name; ?></a></p>
<p><span class="label"><?php echo $this->lang->line('organization'); ?></span><a href="<?php echo base_url(); ?>organization/read/<?php echo $org->id; ?>"><?php echo $org->name; ?></a></p>
<p><span class="label"><?php echo $this->lang->line('created'); ?></span><?php echo $tsk->created; ?></p>
<p><span class="label"><?php echo $this->lang->line('assigned'); ?></span><?php echo $tsk->assigned; ?>&nbsp;</p>
<p><span class="label"><?php echo $this->lang->line('modified'); ?></span><?php echo $tsk->modified; ?>&nbsp;</p>
</div>

<h2><?php echo $this->lang->line('details'); ?></h2>
<div class="box2">
<p><span class="label"><?php echo $this->lang->line('name'); ?></span><?php echo $tsk->name; ?></p>
<p><span class="label"><?php echo $this->lang->line('description'); ?></span><?php echo $tsk->description; ?>&nbsp;</p>
<p><span class="label"><?php echo $this->lang->line('status'); ?></span><?php echo $this->lang->line('status_'.$tsk->status); ?></p>
<p><span class="label"><?php echo $this->lang->line('completion'); ?></span><?php echo $tsk->completion_percent; ?> %</p>
<p><span class="label"><?php echo $this->lang->line('priority'); ?></span><img src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('phpcollab_theme'); ?>/<?php echo $tsk->priority; ?>.gif" alt=""> <?php echo $this->lang->line('priority_'.$tsk->priority); ?></p>
<p><span class="label"><?php echo $this->lang->line('start_date'); ?></span><?php echo $tsk->start_date; ?></p>
<p><span class="label"><?php echo $this->lang->line('due_date'); ?></span><?php echo $tsk->due_date; ?>&nbsp;</p>
<p><span class="label"><?php echo $this->lang->line('published'); ?></span><?php echo $this->lang->line('status_published_'.$tsk->published); ?></p>
</div>

</form>

</div>
</div>

<?php
}
?>