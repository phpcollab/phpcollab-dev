<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> | <a href="<?php echo $this->my_url; ?>milestones/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/milestones'); ?>"></i><?php echo $this->lang->line('milestones'); ?></a> | <a href="<?php echo $this->my_url; ?>milestones/read/<?php echo $row->mln_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/milestones'); ?>"></i><?php echo $row->mln_name; ?></a> | <i class="fa fa-<?php echo $this->config->item('phpcollab/icons/calendar'); ?>"></i><?php echo $this->lang->line('calendar'); ?></h2>
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
