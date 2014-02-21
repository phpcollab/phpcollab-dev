<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>milestones/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/milestones'); ?>"></i><?php echo $this->lang->line('milestones'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->mln_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>milestones/statistics/<?php echo $row->mln_id; ?>"><i class="fa fa-bar-chart-o"></i><?php echo $this->lang->line('statistics'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>milestones/update/<?php echo $row->mln_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>milestones/delete/<?php echo $row->mln_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<div class="column1">
		<p>
		<span class="label"><?php echo $this->lang->line('mln_id'); ?></span>
		<?php if($row->mln_id) { ?><?php echo $row->mln_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_id'); ?></span>
		<?php if($row->mln_name) { ?><?php echo $row->mln_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_owner'); ?></span>
		<?php if($row->mbr_name) { ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_name'); ?></span>
		<?php if($row->mln_name) { ?><?php echo $row->mln_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_description'); ?></span>
		<?php if($row->mln_description) { ?><?php echo $row->mln_description; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<span class="label"><?php echo $this->lang->line('mln_date_start'); ?></span>
		<?php if($row->mln_date_start) { ?><?php echo $row->mln_date_start; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_date_due'); ?></span>
		<?php if($row->mln_date_due) { ?><?php echo $row->mln_date_due; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_date_complete'); ?></span>
		<?php if($row->mln_date_complete) { ?><?php echo $row->mln_date_complete; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_status'); ?></span>
		<?php if($row->mln_status) { ?><?php echo $row->mln_status; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_priority'); ?></span>
		<?php if($row->mln_priority) { ?><span class="color_percent priority_<?php echo $row->mln_priority; ?>" style="width:100%;"><?php echo $this->lang->line('priority_'.$row->mln_priority); ?></span><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_completion'); ?></span>
		<?php if($row->tsk_completion) { ?><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_comments'); ?></span>
		<?php if($row->mln_comments) { ?><?php echo $row->mln_comments; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_published'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->mln_published); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_datecreated'); ?></span>
		<?php if($row->mln_datecreated) { ?><?php echo $row->mln_datecreated; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mln_datemodified'); ?></span>
		<?php if($row->mln_datemodified) { ?><?php echo $row->mln_datemodified; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
