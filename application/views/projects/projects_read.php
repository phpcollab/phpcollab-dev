<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->prj_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>projects/statistics/<?php echo $row->prj_id; ?>"><i class="fa fa-bar-chart-o"></i><?php echo $this->lang->line('statistics'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>projects/update/<?php echo $row->prj_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>projects/delete/<?php echo $row->prj_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<div class="column1">
		<p>
		<span class="label"><?php echo $this->lang->line('prj_id'); ?></span>
		<?php if($row->prj_id) { ?><?php echo $row->prj_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('org_id'); ?></span>
		<?php if($row->org_name) { ?><a href="<?php echo $this->my_url; ?>organizations/read/<?php echo $row->org_id; ?>"><?php echo $row->org_name; ?></a><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_owner'); ?></span>
		<?php if($row->mbr_name) { ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_name'); ?></span>
		<?php if($row->prj_name) { ?><?php echo $row->prj_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_description'); ?></span>
		<?php if($row->prj_description) { ?><?php echo $row->prj_description; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_date_start'); ?></span>
		<?php if($row->prj_date_start) { ?><?php echo $row->prj_date_start; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_date_due'); ?></span>
		<?php if($row->prj_date_due) { ?><?php echo $row->prj_date_due; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_date_complete'); ?></span>
		<?php if($row->prj_date_complete) { ?><?php echo $row->prj_date_complete; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<span class="label"><?php echo $this->lang->line('prj_status'); ?></span>
		<?php if($row->prj_status) { ?><?php echo $row->prj_status; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_priority'); ?></span>
		<?php if($row->prj_priority) { ?><span class="color_percent priority_<?php echo $row->prj_priority; ?>" style="width:100%;"><?php echo $this->lang->line('priority_'.$row->prj_priority); ?></span><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_completion'); ?></span>
		<?php if($row->tsk_completion) { ?><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_comments'); ?></span>
		<?php if($row->prj_comments) { ?><?php echo $row->prj_comments; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_published'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->prj_published); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_datecreated'); ?></span>
		<?php if($row->prj_datecreated) { ?><?php echo $row->prj_datecreated; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_datemodified'); ?></span>
		<?php if($row->prj_datemodified) { ?><?php echo $row->prj_datemodified; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
