<!DOCTYPE html>
<html lang="<?php echo $this->config->item('language'); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $this->lang->line('project_task_assigned'); ?></title>
</head>
<body>

<p><a href="<?php echo $this->my_url; ?>tasks/read/<?php echo $row->tsk_id; ?>"><?php echo $this->my_url; ?>tasks/read/<?php echo $row->tsk_id; ?></a></p>

<?php if($row->prj_name) { ?>
	<p><?php echo $this->lang->line('project'); ?><br><?php echo $row->prj_name; ?></p>
<?php } ?>

<?php if($row->tsk_name) { ?>
	<p><?php echo $this->lang->line('tsk_name'); ?><br><?php echo $row->tsk_name; ?></p>
<?php } ?>

<?php if($row->tsk_description) { ?>
	<p><?php echo $this->lang->line('tsk_description'); ?><br><?php echo $row->tsk_description; ?></p>
<?php } ?>

<?php if($row->tsk_date_start) { ?>
	<p><?php echo $this->lang->line('tsk_date_start'); ?><br><?php echo $row->tsk_date_start; ?></p>
<?php } ?>

<?php if($row->tsk_date_due) { ?>
	<p><?php echo $this->lang->line('tsk_date_due'); ?><br><?php echo $row->tsk_date_due; ?></p>
<?php } ?>

<?php if($row->tsk_priority) { ?>
	<p><?php echo $this->lang->line('tsk_priority'); ?><br><?php echo $this->my_model->priority($row->tsk_priority); ?></p>
<?php } ?>

</body>
</html>
