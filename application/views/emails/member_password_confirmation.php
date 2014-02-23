<!DOCTYPE html>
<html lang="<?php echo $this->config->item('language'); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $this->lang->line('member_password_confirmation'); ?></title>
</head>
<body style="background-color:#FFFFFF;margin:10px;">

<div style="background-color:#444755;border-radius:3px;color:#AEB2B7;font-family:Helvetica,Arial,sans-serif;line-height:1.4;margin:0px 0px 10px 0px;padding:5px 10px;">
	<h2 style="font-size:14px;font-weight:bold;margin:5px 0;"><?php echo $this->lang->line('forgotpassword'); ?></h2>
</div>

<div style="background-color:#F6F8FA;border-radius:3px;color:#30353B;font-family:Helvetica,Arial,sans-serif;font-size:13px;line-height:1.4;margin:0px 0px 10px 0px;padding:5px 10px;">
	<p><?php echo $this->lang->line('direct_link'); ?><br><a style="color:#252732"; href="<?php echo $this->my_url; ?>forgotpassword/confirmation/<?php echo $mbr_forgotpassword; ?>"><?php echo $this->my_url; ?>forgotpassword/confirmation/<?php echo $mbr_forgotpassword; ?></a></p>
</div>

</body>
</html>
