<?php
	$system_nivel_prof="../../admin/";
	include_once("../clases/cls.login.php");
	$estado = cls_login::cerrar_sesion();
	if($estado==0){
		header("Location: ../page/login.php");
	}else{
		header("Location: ../page/index.php");
	}
?>