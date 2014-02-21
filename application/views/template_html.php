<!DOCTYPE html>
<html lang="<?php echo $this->config->item('language'); ?>">
<head>
<meta content="noindex, nofollow, noarchive" name="robots">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<title><?php echo $this->my_library->get_title(); ?></title>
<link href="<?php echo $this->config->item('font-awesome/cdn'); ?>" rel="stylesheet" type="text/css">
<?php echo $this->my_library->get_head(); ?>
</head>
<body<?php if(count($this->my_library->errors) > 0) { ?> class="error"<?php } ?>>

<header>
	<nav>
		<?php if($this->config->item('phpcollab/installed')) { ?>
			<ul>
			<li class="show-phone show-tablet"><a id="toggle-sidebar" href="#"><i class="fa fa-exchange"></i><?php echo $this->lang->line('sidebar'); ?></a></li>
			<?php if($this->session->userdata('phpcollab_member')) { ?>
				<li><a href="<?php echo $this->my_url; ?>"><i class="fa fa-home"></i><?php echo $this->lang->line('home'); ?></a></li>
				<li><a href="<?php echo $this->my_url; ?>profile"><i class="fa fa-user"></i><?php echo $this->phpcollab_member->mbr_name; ?></a></li>
				<li><a href="<?php echo $this->my_url; ?>logout"><i class="fa fa-sign-out"></i><?php echo $this->lang->line('logout'); ?></a></li>
			<?php } else { ?>
				<li><a href="<?php echo $this->my_url; ?>login"><i class="fa fa-sign-in"></i><?php echo $this->lang->line('login'); ?></a></li>
				<li><a href="<?php echo $this->my_url; ?>forgotpassword"><i class="fa fa-key"></i><?php echo $this->lang->line('forgotpassword'); ?></a></li>
			<?php } ?>
			</ul>
		<?php } ?>
	</nav>
</header>

<aside>
	<?php if($this->session->userdata('phpcollab_member')) { ?>
		<ul>
			<li><a href="<?php echo $this->my_url; ?>organizations"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/organizations'); ?>"></i><?php echo $this->lang->line('organizations'); ?></a></li>
			<li><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a></li>
			<li><a href="<?php echo $this->my_url; ?>trackers"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/trackers'); ?>"></i><?php echo $this->lang->line('trackers'); ?></a></li>
			<li><a href="<?php echo $this->my_url; ?>members"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/members'); ?>"></i><?php echo $this->lang->line('members'); ?></a></li>
			<li><a href="<?php echo $this->my_url; ?>roles"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/roles'); ?>"></i><?php echo $this->lang->line('roles'); ?></a></li>
			<li><a href="<?php echo $this->my_url; ?>_configuration"><i class="fa fa-gear"></i><?php echo $this->lang->line('configuration'); ?></a></li>
		</ul>
	<?php } ?>
</aside>

<main>
	<section>
		<section>
			<?php if(isset($zones['content']) == 1) { ?><?php echo $zones['content']; ?><?php } ?>
		</section>
	</section>
</main>

<script>
var base_url = '<?php echo base_url(); ?>';
var csrf_token_name = '<?php echo $this->config->item('csrf_token_name'); ?>';
var csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
var current_url = '<?php echo current_url(); ?>';
var ci_controller = '<?php echo $this->router->class; ?>';
var ci_method = '<?php echo $this->router->method; ?>';
var debug_enabled = <?php if($this->config->item('debug/enabled')) { ?>true<?php } else { ?>false<?php } ?>;
var environment = '<?php echo $this->config->item('environment'); ?>';
var language = '<?php echo $this->config->item('language'); ?>';
var uri_string = '<?php echo $this->uri->uri_string(); ?>';
</script>

<script src="<?php echo base_url(); ?>thirdparty/jquery/jquery.min.js?modified=<?php echo filemtime('thirdparty/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url(); ?>thirdparty/jquery/jquery.cookie.min.js?modified=<?php echo filemtime('thirdparty/jquery/jquery.cookie.min.js'); ?>"></script>
<?php echo $this->my_library->get_foot(); ?>

<?php echo $this->my_library->get_debug(); ?>

</body>
</html>