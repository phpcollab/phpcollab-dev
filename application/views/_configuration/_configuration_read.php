<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>_configuration"><i class="fa fa-gears"></i><?php echo $this->lang->line('configuration'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->cfg_path; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>_configuration/update/<?php echo $row->cfg_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>_configuration/delete/<?php echo $row->cfg_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<div class="column half">
		<p>
		<span class="label"><?php echo $this->lang->line('cfg_id'); ?></span>
		<?php if($row->cfg_id) { ?><?php echo $row->cfg_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('cfg_path'); ?></span>
		<?php if($row->cfg_path) { ?><?php echo $row->cfg_path; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('cfg_value'); ?></span>
		<?php if($row->cfg_value != '') { ?><?php echo $row->cfg_value; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('cfg_datecreated'); ?></span>
		<?php if($row->cfg_datecreated) { ?><?php echo $this->my_library->timezone_datetime($row->cfg_datecreated); ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
