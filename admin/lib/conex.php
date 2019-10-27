<?php
	require_once($system_nivel_prof."clases/cls.config.php");
	$_oConfig = cls_config::get_config();
	$_oConfig->set('dbServer', '127.0.0.1');
	$_oConfig->set('dbPort', '3306');
	$_oConfig->set('dbBase', 'openinfo');
	$_oConfig->set('dbUser', 'root');
	$_oConfig->set('dbPwd', '');
?>
