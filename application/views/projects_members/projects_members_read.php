<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>projects_members/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects_members'); ?>"></i><?php echo $this->lang->line('projects_members'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->mbr_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>projects_members/update/<?php echo $row->prj_mbr_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>projects_members/delete/<?php echo $row->prj_mbr_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<div class="column1">
		<p>
		<span class="label"><?php echo $this->lang->line('organization'); ?></span>
		<?php if($row->org_name) { ?><?php echo $row->org_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('member'); ?></span>
		<?php if($row->mbr_name) { ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_mbr_authorized'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->prj_mbr_authorized); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_mbr_published'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->prj_mbr_published); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_mbr_datecreated'); ?></span>
		<?php if($row->prj_mbr_datecreated) { ?><?php echo $row->prj_mbr_datecreated; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
