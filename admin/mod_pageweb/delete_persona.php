<?php
	$id_modulo_sist = $_POST["m"];
	require_once("../scripts/include.php");
	$rpt = "no";
	if(isset($_POST['id']) && trim($_POST['id'])<>""){
		$reg_id = fncSeguridad($_POST["id"]);
		if(fncVerificarID($reg_id)==1){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT * FROM team WHERE id_persona ='".$reg_id."'";
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total<>0){
			//_Eliminamos las imágenes
				$carpeta = "../../web/img/team/";
				$datos = $_oControl->obtener_cursor($rs);
				$img = $datos["img"];
				$thumb = "thumb_".$img;
				if(trim($img)<>"" && file_exists($carpeta.$img)){unlink($carpeta.$img);}
				if(trim($thumb)<>"" && file_exists($carpeta.$thumb)){unlink($carpeta.$thumb);}
			//_Eliminamos la cabecera del slider
				$eliminar = $_oControl->mantto("DELETE FROM team WHERE id_persona='".$reg_id."'");
				if($eliminar==true){
					$rpt="si";
				}
			}
		}
	}
	echo $rpt;
?>
