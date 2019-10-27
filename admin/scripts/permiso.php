<?php
	require_once("../clases/cls.sistema.php");
	if(trim($id_modulo_sist)==""){ $id_modulo_sist = $_REQUEST["m"]; }
	if(fncVerificarID($id_modulo_sist)==1){
		$sist_permiso = cls_sistema::get_permiso_aplicacion($id_modulo_sist,"modulo");
		if($sist_permiso<>0 && $sist_permiso<>1){
			exit($sist_permiso);
		}
	}else{
		exit("<script language='javascript'>document.location.href='../page/index.php';</script>");
	}
?>