<?php
	$id_modulo_sist = $_POST["m"];
	require_once("../scripts/include.php");
	$rpt = "no";
	if(isset($_POST['id']) && trim($_POST['id'])<>""){
		$reg_id = fncSeguridad($_POST["id"]);
		if(fncVerificarID($reg_id)==1){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT * FROM slider WHERE id_slider ='".$reg_id."'";
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total<>0){
			//_Eliminamos las imágenes
				$carpeta = "../../web/img/slider/";
				$datos = $_oControl->obtener_cursor($rs);
				$img = $datos["img"];
				//$thumb = "thumb_".$img;
				if(trim($img)<>"" && file_exists($carpeta.$img)){unlink($carpeta.$img);}
			//_Eliminamos la cabecera del slider
				$eliminar = $_oControl->mantto("DELETE FROM slider WHERE id_slider='".$reg_id."'");
				if($eliminar==true){
					$rpt="si";
				}
			}
		}
	}
	echo $rpt;
?>
