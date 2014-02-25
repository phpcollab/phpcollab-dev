<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $row->prj_name; ?></a> | <i class="fa fa-bar-chart-o"></i><?php echo $this->lang->line('statistics'); ?></h2>
	<ul>
	</ul>
</article>
<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/milestones'); ?>"></i><?php echo $this->lang->line('milestones'); ?></h2>
</article>
<article>
	<?php echo $milestones; ?>
</article>
<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/tasks'); ?>"></i><?php echo $this->lang->line('tasks'); ?></h2>
</article>
<article>
	<?php echo $tasks; ?>
</article>
