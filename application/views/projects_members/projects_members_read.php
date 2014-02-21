<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-leaf"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-leaf"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>projects_members/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-rocket"></i><?php echo $this->lang->line('projects_members'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->prj_mbr_id; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>projects_members/update/<?php echo $row->prj_mbr_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>projects_members/delete/<?php echo $row->prj_mbr_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<div class="column1">
		<p>
		<span class="label"><?php echo $this->lang->line('prj_id'); ?></span>
		<?php if($row->prj_id) { ?><?php echo $row->prj_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_name'); ?></span>
		<?php if($row->prj_name) { ?><?php echo $row->prj_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_id'); ?></span>
		<?php if($row->mbr_id) { ?><?php echo $row->mbr_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_name'); ?></span>
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
