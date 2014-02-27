<article class="title">
	<?php if(isset($row) == 1) { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $row->prj_name; ?></a> | <a href="<?php echo $this->my_url; ?>milestones/index/<?php echo $row->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/milestones'); ?>"></i><?php echo $this->lang->line('milestones'); ?></a> | <i class="fa fa-<?php echo $this->config->item('phpcollab/icons/calendar'); ?>"></i><?php echo $this->lang->line('calendar'); ?></h2>
	<?php } else { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <i class="fa fa-<?php echo $this->config->item('phpcollab/icons/calendar'); ?>"></i><?php echo $this->lang->line('calendar'); ?></h2>
	<?php } ?>
	<ul>
	</ul>
</article>
<article>
	<div id="calendar">
	</div>
	<div id="loading" style="display:none;">
		loading...
	</div>
</article>
