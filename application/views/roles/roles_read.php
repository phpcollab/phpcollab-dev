<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>roles"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/roles') ?>"></i><?php echo $this->lang->line('roles'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->rol_code; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>roles/update/<?php echo $row->rol_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>roles/delete/<?php echo $row->rol_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<div class="column1">
		<p>
		<span class="label"><?php echo $this->lang->line('rol_id'); ?></span>
		<?php if($row->rol_id) { ?><?php echo $row->rol_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('rol_code'); ?></span>
		<?php if($row->rol_code) { ?><?php echo $row->rol_code; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('rol_system'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->rol_system); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('rol_datecreated'); ?></span>
		<?php if($row->rol_datecreated) { ?><?php echo $row->rol_datecreated; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>