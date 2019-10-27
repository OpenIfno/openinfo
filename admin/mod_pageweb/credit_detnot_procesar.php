<?php
	$id_modulo_sist = $_POST["id_modulo_sist"];
	require_once("../scripts/include.php");
	$url = "../page/index.php";
	if(isset($_POST["MM_mantto"])&& trim($_POST["MM_mantto"])=="frm_mantto"){
		//configuracion del servidor
		ini_set('post_max_size', '500M');
		ini_set('upload_max_filesize', '500M');
		ini_set('max_execution_time', '2000');
		ini_set('max_input_time', '2000');
		//Archivo para tratamiento de imagenes
		require_once("../clases/cls.images.php");
		$_oControl = cls_control::get_instancia();
		//Recepcion de variables
		$task = $_POST["task"];
		$id_noticia = $_POST["id_noticia"];
		$descripcion = fncCodificar($_POST["descripcion"]);
		$tipo = $_POST["tipo"];
		$nombre = fncCodificar($_POST["nombre"]);
		$recurso = fncCodificar($_POST["recurso"]);
		$orden = $_POST["orden"];
		$estado = $_POST["estado"];
		$archivo = $_FILES["imagen"]["name"];
		$temporal = $_FILES["imagen"]["tmp_name"];
		$ancho_imagen = 800; //ancho maximo de las imagenes
		$ancho_thumb = 360;
		$destinoaudio = "../../web/audio/noticia/";//ruta de destino del audio
		$destinoimage = "../../web/img/noticia/";

		switch ($tipo) {
			case 1: //cargar imagen
				if(fncValidarMalicioso($archivo)==0){
					if($task=="edit"){$img_ANTES = $_POST["img_antes"];$img_thumb_antes = $_POST["img_thumb_antes"];}
					if($archivo<>""){
						$permitida = fncValidarImagen($archivo);
						if($permitida == 1){
							$prefijo = "img_det_";
							$prefijo_thumb = "thumb_det_";
							list($ancho,$alto) = getimagesize($temporal);
							$imgXG = new Images($archivo,$destinoimage,$temporal,$prefijo,true,$ancho_thumb);
							if($ancho>=$ancho_imagen){$ancho=$ancho_imagen;}
							$img = $imgXG->subirImage($ancho,$alto,1);
							//thumb

						}else{ $img[0] = "";$img[1] = "";}
						if($task=="edit"){
							if($img_ANTES<>"" && file_exists($destinoimage.$img_ANTES)){unlink($destinoimage.$img_ANTES);}
							if($img_thumb_antes<>"" && file_exists($destinoimage.$img_thumb_antes)){unlink($destinoimage.$img_thumb_antes);}
						}
					}else{
						if($task=="new"){ $img[0] = "";$img[1] = "";}else{$img[0]=$img_ANTES;$img[1]=$img_thumb_antes;}
					}
					//preparación de la consulta para inserción
					if($task=="new"){
							$consulta = "INSERT INTO news_detalle(id_noticia,id_tipo,nombre,recurso,descripcion,orden,estado)
										VALUES ('".$id_noticia."','".$tipo."','".$nombre."','".$img[0]."','".$descripcion."','".$orden."','".$estado."')";
					}elseif($task="edit"){
						$id_detalle = $_POST["id_detalle"];
						if(fncVerificarID($id_detalle)==1){
							$consulta = "SELECT id_detalle from news_detalle WHERE id_detalle = '".$id_detalle."'";
							$rs = $_oControl->consulta($consulta);
							$total = $_oControl->nroregistros;
							if($total>0){
								$consulta = "UPDATE news_detalle
											SET id_tipo = '".$tipo."'
											,nombre = '".$nombre."'
											,recurso = '".$img[0]."'
											,descripcion = '".$descripcion."'
											,orden = '".$orden."'
											,estado = '".$estado."'
											WHERE id_detalle = '".$id_detalle."'";
							}
						}
					}
				};
				break;
			case 2:// En el caso que sea un audio el que haya que subir
				if(fncValidarMalicioso($archivo)==0){
					if($task=="edit"){$img_ANTES = $_POST["img_antes"];$img_thumb_antes = $_POST["img_thumb_antes"];}
					if($archivo<>""){
						$permitida = fncValidarAudio($archivo);
						if($permitida == 1){
							$prefijo = "audio_";
							$ext = strtolower(end(explode(".", $archivo)));
							do{
								$nombre_audio = $prefijo.rand(1,9999).".".$ext;
							}while(file_exists($destinoaudio.$nombre_audio));
							$moved = move_uploaded_file($temporal,$destinoaudio.$nombre_audio);
							$img = $nombre_audio;
						}else{$nombre_audio = $img = "";}
						if($task=="edit"){
							if($img_ANTES<>"" && file_exists($destinoaudio.$img_ANTES)){unlink($destinoaudio.$img_ANTES);}
							if($img_thumb_antes<>"" && file_exists($destinoaudio.$img_thumb_antes)){unlink($destinoaudio.$img_thumb_antes);}
						}
					}else{
						if($task=="new"){ $nombre_audio = "";}else{$nombre_audio=$img_ANTES;}
					}
					//Preparación de la consulta de inserción
					if($task=="new"){
						if(trim($nombre_audio)<>""){
							$consulta = "INSERT INTO news_detalle(id_noticia,id_tipo,nombre,recurso,descripcion,orden,estado)
										VALUES ('".$id_noticia."','".$tipo."','".$nombre."','".$nombre_audio."','".$descripcion."','".$orden."','".$estado."')";
						}
					}elseif($task=="edit"){
						$id_detalle = $_POST["id_detalle"];
						if(fncVerificarID($id_detalle)==1){
							$consulta = "SELECT id_detalle from news_detalle WHERE id_detalle = '".$id_detalle."'";
							$rs = $_oControl->consulta($consulta);
							$total = $_oControl->nroregistros;
							if($total>0){
								$consulta = "UPDATE news_detalle
											SET id_tipo = '".$tipo."'
											,nombre = '".$nombre."'
											,recurso = '".$nombre_audio."'
											,descripcion = '".$descripcion."'
											,orden = '".$orden."'
											,estado = '".$estado."'
											WHERE id_detalle = '".$id_detalle."'";
							}
						}
					}
				};
				break;
				case 3:
				case 4:
				case 5:
				case 6:
					if($task=="new"){
							$consulta = "INSERT INTO news_detalle(id_noticia,id_tipo,nombre,recurso,descripcion,orden,estado)
										VALUES ('".$id_noticia."','".$tipo."','".$nombre."','".$recurso."','".$descripcion."','".$orden."','".$estado."')";
					}elseif($task=="edit"){
						$id_detalle = $_POST["id_detalle"];
						if(fncVerificarID($id_detalle)==1){
							$consulta = "SELECT id_detalle from news_detalle WHERE id_detalle = '".$id_detalle."'";
							$rs = $_oControl->consulta($consulta);
							$total = $_oControl->nroregistros;
							if($total>0){
								$consulta = "UPDATE news_detalle
											SET id_tipo = '".$tipo."'
											,nombre = '".$nombre."'
											,recurso = '".$recurso."'
											,descripcion = '".$descripcion."'
											,orden = '".$orden."'
											,estado = '".$estado."'
											WHERE id_detalle = '".$id_detalle."'";
							}
						}
					};
				break;
		}
		$mantto = $_oControl->mantto($consulta);
		if($mantto==true){$url = "../page/index.php?m=".cls_sistema::get_id_alias("DET_NEWS")."&id=".$id_noticia;}
	}
	header("Location:".$url);
?>
