<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/logs'); ?>"></i><?php echo $this->lang->line('logs'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-logs') || $this->input->cookie($this->router->class.'-logs') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-logs-collapse"><a href="#<?php echo $this->router->class; ?>-logs"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
	<li class="expand<?php if($this->input->cookie($this->router->class.'-logs') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-logs-expand"><a href="#<?php echo $this->router->class; ?>-logs"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	</ul>
</article>
<div id="<?php echo $this->router->class; ?>-logs"<?php if($this->input->cookie($this->router->class.'-logs') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<?php if($rows) { ?>
		<?php foreach($rows as $row) { ?>
		<?php $fields = $this->my_model->get_log_details($row->log_id); ?>
		<article>
			<div class="column half">
				<p><?php echo $row->mbr_name; ?></p>
				<p><?php echo $this->my_library->timezone_datetime($row->log_datecreated); ?> (<span class="timeago" title="<?php echo $this->my_library->timezone_datetime($row->log_datecreated); ?>"></span>)</p>
				<p><?php echo nl2br($row->log_comments); ?></p>
			</div>
			<div class="column half">
				<table>
				<?php foreach($fields as $k => $details) { ?>
					<tr><td width="33%"><?php echo $this->lang->line($details['field']); ?></td><td width="33%" style="text-decoration:line-through;"><?php echo $details['old']; ?></td><td width="33%"><?php echo $details['new']; ?></td></tr>
				<?php } ?>
				</table>
			</div>
		</article>
		<?php } ?>
	<div class="paging">
		<?php echo $pagination; ?>
	</div>
	<?php } ?>
</div>
