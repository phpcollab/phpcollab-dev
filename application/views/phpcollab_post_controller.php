<!DOCTYPE html>
<html lang="<?php echo $this->lng->lng_code; ?>">
<head>
<?php echo $this->phpcollab_library->get_head(); ?>
</head>
<body>

<div id="box-page">
<div id="display-page">

<div id="box-pageheader">
<div id="display-pageheader">
<?php if(isset($zones['pageheader']) == 1) { echo $zones['pageheader']; } ?>
</div>
</div>

<div id="box-pagecontent">
<div id="display-pagecontent">

	<div id="box-contentheader">
	<div id="display-contentheader">
	<?php if(isset($zones['contentheader']) == 1) { echo $zones['contentheader']; } ?>
	</div>
	</div>

	<div id="box-content">
	<div id="display-content">
	<?php echo $zones['content']; ?>
	</div>
	</div>

	<div id="box-contentfooter">
	<div id="display-contentfooter">
	<?php if(isset($zones['contentfooter']) == 1) { echo $zones['contentfooter']; } ?>
	</div>
	</div>

</div>
</div>

<div id="box-pagesidebar">
<div id="display-pagesidebar">
<?php if(isset($zones['pagesidebar']) == 1) { echo $zones['pagesidebar']; } ?>
</div>
</div>

<div id="box-pagefooter">
<div id="display-pagefooter">
<?php if(isset($zones['pagefooter']) == 1) { echo $zones['pagefooter']; } ?>
</div>
</div>

</div>
</div>

<?php echo $this->phpcollab_library->get_debug(); ?>
<?php echo $this->phpcollab_library->get_foot(); ?>
</body>
</html>
