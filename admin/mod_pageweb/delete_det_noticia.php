<?php
	$id_modulo_sist = $_POST["m"];
	require_once("../scripts/include.php");
	$rpt = "no";
	if(isset($_POST['id']) && trim($_POST['id'])<>""){
		$reg_id = fncSeguridad($_POST["id"]);
		if(fncVerificarID($reg_id)==1){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT * FROM news_detalle WHERE id_detalle ='".$reg_id."'";
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total<>0){
				$datos = $_oControl->obtener_cursor($rs);
				$tipo = $datos["id_tipo"];
				switch ($tipo) {
					case 1:
						$carpeta = "../../web/img/noticia/";
						$img = $datos["recurso"];
						$thumb = "thumb_".$img;
						if(trim($img)<>"" && file_exists($carpeta.$img)){unlink($carpeta.$img);}
						if(trim($thumb)<>"" && file_exists($carpeta.$thumb)){unlink($carpeta.$thumb);}
						break;
					case 2:
						$carpeta = "../../web/audio/noticia/";
						$audio = $datos["recurso"];
						if(trim($audio)<>"" && file_exists($carpeta.$audio)){unlink($carpeta.$audio);}
						break;
				}
			//_Eliminamos la cabecera del slider
				$consulta = "SELECT max(id_detalle) as ultimo FROM news_detalle";
				$rs = $_oControl->consulta($consulta);
				$total = $_oControl->nroregistros;
				if($total<>0){
					$datos = $_oControl->obtener_cursor($rs);
					$ultimo=$datos["ultimo"];
				}
				$eliminar = $_oControl->mantto("DELETE FROM news_detalle WHERE id_detalle='".$reg_id."'");
				if ($ultimo==$reg_id) {$_oControl->mantto("ALTER TABLE news_detalle  AUTO_INCREMENT=".$ultimo."");}
				if($eliminar==true){
					$rpt="si";
				}
			}
		}
	}
	echo $rpt;
?>
