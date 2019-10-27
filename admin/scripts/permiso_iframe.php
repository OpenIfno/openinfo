<?php
	require_once("../clases/cls.sistema.php");
	if(trim($id_modulo_sist)==""){ $id_modulo_sist = $_REQUEST["m"]; }
	if(fncVerificarID($id_modulo_sist)==1){
		$sist_permiso = cls_sistema::get_permiso_aplicacion($id_modulo_sist,"iframe");
		if($sist_permiso==0){
			exit("<div id='no_reg'>Usted no tiene permiso para administrar este m&oacute;dulo.</div>");
		}
	}else{
		exit("<div id='no_reg'>Usted no tiene permiso para administrar este m&oacute;dulo.</div>");
	}
?>