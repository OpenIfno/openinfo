<?php
	$id_modulo_sist = $_POST["m"];
	require_once("../scripts/include.php");
	$rpt = "no";
	if(isset($_POST['id']) && trim($_POST['id'])<>""){
		$reg_id = fncSeguridad($_POST["id"]);
		if(fncVerificarID($reg_id)==1){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT * FROM features WHERE id_feature ='".$reg_id."'";
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total<>0){
			//_Eliminamos la cabecera del slider
				$eliminar = $_oControl->mantto("DELETE FROM features WHERE id_feature='".$reg_id."'");
				if($eliminar==true){
					$rpt="si";
				}
			}
		}
	}
	echo $rpt;
?>
