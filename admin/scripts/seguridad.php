<?php
	$system_nivel_prof="../../admin/";
	require_once("../clases/cls.login.php");
	$estado = cls_login::seguridad();
	if($estado=="0"){
		cls_login::cerrar_sesion();
		echo "<script type='text/javascript'>document.location.href='../page/login.php';</script>";
	}
?>