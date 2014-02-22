<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>files/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/files'); ?>"></i><?php echo $this->lang->line('files'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->fle_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>files/download/<?php echo $row->fle_id; ?>"><i class="fa fa-cloud-download"></i><?php echo $this->lang->line('download'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>files/delete/<?php echo $row->fle_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-read') || $this->input->cookie($this->router->class.'-read') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-collapse"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
	<li class="expand<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-expand"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-read"<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<div class="column1">
		<p>
		<span class="label"><?php echo $this->lang->line('fle_id'); ?></span>
		<?php if($row->fle_id) { ?><?php echo $row->fle_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('fle_owner'); ?></span>
		<?php if($row->mbr_name) { ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('fle_name'); ?></span>
		<?php if($row->fle_name) { ?><?php echo $row->fle_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('fle_description'); ?></span>
		<?php if($row->fle_description) { ?><?php echo $row->fle_description; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<span class="label"><?php echo $this->lang->line('fle_comments'); ?></span>
		<?php if($row->fle_comments) { ?><?php echo $row->fle_comments; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('fle_published'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->fle_published); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('fle_datecreated'); ?></span>
		<?php if($row->fle_datecreated) { ?><?php echo $row->fle_datecreated; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
