<?php
	$id_modulo_sist = $_POST["m"];
	require_once("../scripts/include.php");
	$rpt = "no";
	if(isset($_POST['id']) && trim($_POST['id'])<>""){
		$reg_id = fncSeguridad($_POST["id"]);
		if(fncVerificarID($reg_id)==1){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT * FROM news WHERE id_noticia ='".$reg_id."'";
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total<>0){
				$consulta = "SELECT * FROM news_detalle WHERE id_noticia ='".$reg_id."' ORDER BY id_detalle DESC";
				$rs1 = $_oControl->consulta($consulta);
				$total = $_oControl->nroregistros;
				if($total<>0){
					while($datos = $_oControl->obtener_cursor($rs1)){
						$tipo=$datos["id_tipo"];
						$id=$datos["id_detalle"];
						switch ($tipo){
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
						$consulta = "SELECT max(id_detalle) as ultimo FROM news_detalle";
						$rs2 = $_oControl->consulta($consulta);
						$total = $_oControl->nroregistros;
						if($total<>0){
							$datos = $_oControl->obtener_cursor($rs2);
							$ultimo=$datos["ultimo"];
						}
						$eliminar = $_oControl->mantto("DELETE FROM news_detalle WHERE id_detalle='".$id."'");
						if ($ultimo==$id) {$_oControl->mantto("ALTER TABLE news_detalle  AUTO_INCREMENT=".$ultimo."");}
					}
				}
				//eliminar tags
				$eliminar = $_oControl->mantto("DELETE FROM news_tag WHERE id_noticia='".$reg_id."'");
				$carpeta = "../../web/img/noticia/";
				$datos = $_oControl->obtener_cursor($rs);
				$img = $datos["img"];
				$thumb = "thumb_".$img;
				if(trim($img)<>"" && file_exists($carpeta.$img)){unlink($carpeta.$img);}
				if(trim($thumb)<>"" && file_exists($carpeta.$thumb)){unlink($carpeta.$thumb);}
				$consulta = "SELECT max(id_noticia) as ultimo FROM news";
				$rs3 = $_oControl->consulta($consulta);
				$total = $_oControl->nroregistros;
				if($total<>0){
					$datos = $_oControl->obtener_cursor($rs3);
					$ultimo=$datos["ultimo"];
				}
				$eliminar = $_oControl->mantto("DELETE FROM news WHERE id_noticia='".$reg_id."'");
				if ($ultimo==$reg_id) {$_oControl->mantto("ALTER TABLE news AUTO_INCREMENT=".$ultimo."");}
				if($eliminar==true){
					$rpt="si";
				}
			}
		}
	}
	echo $rpt;
?>
