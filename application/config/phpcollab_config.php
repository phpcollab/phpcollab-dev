<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

$config['date_timezone'] = 'UTC';

$config['jpgraph'] = true;//true or false

$config['ldap'] = false;//true or false
$config['ldap_server'] = 'ldap://localhost';
$config['ldap_port'] = 389;
$config['ldap_protocol'] = 3;
$config['ldap_rootdn'] = 'cn=Manager,dc=my-domain,dc=com';
$config['ldap_rootpw'] = 'secret';
$config['ldap_basedn'] = 'dc=my-domain,dc=com';
$config['ldap_filter'] = 'mail=[email]';
$config['ldap_lastname'] = 'sn';
$config['ldap_firstname'] = 'givenname';

$config['phpcollab_password'] = 'MD5';//'MD5', 'CRYPT' or 'PLAIN'
$config['phpcollab_theme'] = 'default';
$config['phpcollab_debug'] = true;//true or false
