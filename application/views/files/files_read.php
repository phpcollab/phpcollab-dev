<?php $extension = strtolower(substr(strrchr($row->fle_name, '.'), 1)); ?>
<?php $size_extensions = array('gif', 'jpeg', 'jpg', 'png', 'swf', 'psd', 'tiff', 'bmp'); ?>
<?php $preview_extensions = array('jpeg', 'jpg', 'png', 'swf', 'gif'); ?>
<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>files/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/files'); ?>"></i><?php echo $this->lang->line('files'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->fle_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>files/download/<?php echo $row->fle_id; ?>"><i class="fa fa-cloud-download"></i><?php echo $this->lang->line('download'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>files/update/<?php echo $row->fle_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<?php if($this->auth_library->permission('files/delete/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>files/delete/<?php echo $row->fle_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>

	<?php } else if($this->auth_library->permission('files/delete/ifowner') && $row->fle_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>files/delete/<?php echo $row->fle_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	<?php } ?>
	<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-read') || $this->input->cookie($this->router->class.'-read') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-collapse"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
	<li class="expand<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-expand"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-read"<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<div class="column half">
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
	<div class="column half">
		<p>
		<span class="label"><?php echo $this->lang->line('fle_size'); ?></span>
		<?php if($row->fle_size) { ?><?php echo convert_size($row->fle_size); ?><?php } else { ?>-<?php } ?>
		</p>
		<?php if(in_array($extension, $size_extensions)) { ?>
			<?php $dim = getimagesize('storage/projects/'.$prj->prj_id.'/'.$row->fle_name); ?>
			<p>
			<span class="label"><?php echo $this->lang->line('dimensions'); ?></span>
			<?php echo $dim[0]; ?>x<?php echo $dim[1]; ?>
			</p>
		<?php } ?>
		<p>
		<span class="label"><?php echo $this->lang->line('fle_published'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->fle_published); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('fle_datecreated'); ?></span>
		<?php if($row->fle_datecreated) { ?><?php echo $this->my_library->timezone_datetime($row->fle_datecreated); ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
<?php if(in_array($extension, $preview_extensions)) { ?>
<article class="title">
	<h2><i class="fa fa-picture-o"></i><?php echo $this->lang->line('preview'); ?></h2>
</article>
<article>
	<img src="<?php echo base_url(); ?>storage/projects/<?php echo $prj->prj_id; ?>/<?php echo $row->fle_name; ?>" alt="<?php echo $row->fle_name; ?>">
</article>
<?php } ?>