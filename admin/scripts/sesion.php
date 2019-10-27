<?php
	$system_nivel_prof="../../admin/";
	echo "af";
	if(isset($_POST['MM_validar'])&&($_POST['MM_validar']=='frm_login')){
		require_once("../clases/cls.login.php");
		require_once('../clases/cls.sistema.php');
	//_Recepcion de Variables
		$usuario = fncSeguridad($_POST['username']);
		echo $usuario;
		$clave = fncSeguridad($_POST['pass']);
	//_Verificacion de los datos
		$logueado = cls_login::loguear($usuario, $clave);
		if($logueado=="1"){
			$url = "../page/index.php";
		}else{
			$url = "../page/login.php?er=si";
		}
	}else{
		$url = "../page/login.php";
	}
		header("Location: ".$url);
?>
