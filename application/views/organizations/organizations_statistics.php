<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>organizations"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/organizations'); ?>"></i><?php echo $this->lang->line('organizations'); ?></a> | <a href="<?php echo $this->my_url; ?>organizations/read/<?php echo $row->org_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/organizations'); ?>"></i><?php echo $row->org_name; ?></a> | <i class="fa fa-bar-chart-o"></i><?php echo $this->lang->line('statistics'); ?></h2>
	<ul>
	</ul>
</article>
<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/tasks'); ?>"></i><?php echo $this->lang->line('tasks'); ?></h2>
</article>
<article>
	<?php echo $tasks; ?>
</article>
