<?php
	$id_modulo_sist = $_POST["m"];
	require_once("../scripts/include.php");
	$rpt = "no";
	if(isset($_POST['id']) && trim($_POST['id'])<>""){
		$reg_id = fncSeguridad($_POST["id"]);
		if(fncVerificarID($reg_id)==1){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT * FROM gallery WHERE id_image ='".$reg_id."'";
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total<>0){
				$carpeta = "../../web/img/galeria/";
				$datos = $_oControl->obtener_cursor($rs);
				$img = $datos["img"];
				$thumb = "thumb_".$img;
				if(trim($img)<>"" && file_exists($carpeta.$img)){unlink($carpeta.$img);}
				if(trim($thumb)<>"" && file_exists($carpeta.$thumb)){unlink($carpeta.$thumb);}
				$consulta = "SELECT max(id_image) as ultimo FROM gallery";
				$rs3 = $_oControl->consulta($consulta);
				$total = $_oControl->nroregistros;
				if($total<>0){
					$datos = $_oControl->obtener_cursor($rs3);
					$ultimo=$datos["ultimo"];
				}
				$eliminar = $_oControl->mantto("DELETE FROM gallery WHERE id_image='".$reg_id."'");
				if ($ultimo==$reg_id) {$_oControl->mantto("ALTER TABLE gallery AUTO_INCREMENT=".$ultimo."");}
				if($eliminar==true){
					$rpt="si";
				}
			}
		}
	}
	echo $rpt;
?>
