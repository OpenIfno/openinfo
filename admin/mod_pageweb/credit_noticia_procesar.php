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
		//Recepcion de variables
		$task = $_POST["task"];
		$titulo = fncCodificar($_POST["titulo"]);
		$subtitulo = fncCodificar($_POST["subtitulo"]);
		$resumen = fncCodificar($_POST["resumen"]);
		$fecha = date("Y-m-d", strtotime($_POST["fecha"]));
		$prioridad = $_POST["prioridad"];
		$categoria = $_POST["categoria"];
		$tags = $_POST["tags"];
		$tag = explode(",",$tags);
		$estado = $_POST["estado"];
		$archivo = $_FILES["imagen"]["name"];
		$temporal = $_FILES["imagen"]["tmp_name"];
		$ancho_imagen = 800; //ancho maximo de las imagenes
		$ancho_thumb = 360;
		$destino = "../../web/img/noticia/";//ruta de destino de las imagenes
	//_Desinfeccion de Archivos
		if(fncValidarMalicioso($archivo)==0 && trim($titulo)<>""){
			if($task=="edit"){ $img_ANTES=$_POST["img_antes"]; $img_thumb_antes=$_POST["img_thumb_antes"]; }
			$img_delete = GetSQLValueString(isset($_POST["eliminar"]) ? "true" : "", "defined","si","no");
			if($img_delete=="no"){
				if($archivo<>""){
					$permitida = fncValidarImagen($archivo);
					if($permitida==1){
						$prefijo = "img_";
						$prefijo_thumb = "thumb_";
						list($ancho,$alto) = getimagesize($temporal);
						$imgXG = new Images($archivo,$destino,$temporal,$prefijo,true,$ancho_thumb);
						if($ancho>=$ancho_imagen){$ancho=$ancho_imagen;}
						$img = $imgXG->subirImage($ancho,$alto,1);
					}else{ $img[0] = "";$img[1] = "";}
					if($task=="edit"){
						if($img_ANTES<>"" && file_exists($destino.$img_ANTES)){unlink($destino.$img_ANTES);}
						if($img_thumb_antes<>"" && file_exists($destino.$img_thumb_antes)){unlink($destino.$img_thumb_antes);}
					}
				}else{
					if($task=="new"){ $img[0]=""; $img[1]=""; }else{ $img[0]=$img_ANTES; $img[1]=$img_thumb_antes; }
				}
			}else{
				$img[0]=""; $img[1]="";
				if($img_ANTES<>"" && file_exists($destino.$img_ANTES)){unlink($destino.$img_ANTES);}
				if($img_thumb_antes<>"" && file_exists($destino.$img_thumb_antes)){unlink($destino.$img_thumb_antes);}
			}
		//_Formateo final
		$img[0] = fncValidarCadenaBD($img[0]);
		$img[1] = fncValidarCadenaBD($img[1]);
		//_Insercion en la bbdd
			$_oControl = cls_control::get_instancia();
			if($task=="new"){
				if(trim($titulo)<>""){
					$consulta = "INSERT INTO news(id_usuario,id_categoria,titulo,subtitulo,resumen,fecha,img,thumb,prioridad,estado)
											 VALUES('".$_SESSION["adm_id"]."','".$categoria."','".$titulo."','".$subtitulo."','".$resumen."','".$fecha."',
											 ".$img[0].",".$img[1].",'".$prioridad."','".$estado."')";
					$mantto = $_oControl->mantto($consulta);

					$consulta = "SELECT max(id_noticia) as ultimo FROM news";
					$rs = $_oControl->consulta($consulta);
					$total = $_oControl->nroregistros;
					if($total>0){
						$datos = $_oControl->obtener_cursor($rs);
						$id_noticia = $datos["ultimo"];
					}
					$n=count($tag);
					for ($i=0; $i<$n ; $i++) {
						$etiqueta = fncCodificar($tag[$i]);
						$consulta = "INSERT INTO news_tag(id_noticia,tag) VALUES('".$id_noticia."','".$etiqueta."')";
						$mantto = $_oControl->mantto($consulta);
					}
					if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("NEWS"); }
				}
			}elseif($task="edit"){
				$id_noticia = $_POST["id_noticia"];
				if(fncVerificarID($id_noticia)==1){
					$consulta = "SELECT id_noticia FROM news WHERE id_noticia='".$id_noticia."'";
					$rs = $_oControl->consulta($consulta);
					$total = $_oControl->nroregistros;
					if($total>0){
						$consulta = "UPDATE news
												 SET id_usuario = '".$_SESSION["adm_id"]."',
														 id_categoria = '".$categoria."',
														 titulo = '".$titulo."',
														 subtitulo = '".$subtitulo."',
														 resumen = '".$resumen."',
														 fecha = '".$fecha."',
														 img = ".$img[0].",
														 thumb = ".$img[1].",
														 prioridad = '".$prioridad."',
														 estado = '".$estado."'
												 WHERE id_noticia='".$id_noticia."'";
						$mantto = $_oControl->mantto($consulta);
						$eliminar = $_oControl->mantto("DELETE FROM news_tag WHERE id_noticia='".$id_noticia."'");
						$n=count($tag);
						for ($i=0; $i<$n ; $i++) {
							$etiqueta = fncCodificar($tag[$i]);
							$consulta = "INSERT INTO news_tag(id_noticia,tag) VALUES('".$id_noticia."','".$etiqueta."')";
							$mantto = $_oControl->mantto($consulta);
						}
						if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("NEWS"); }
					}
				}
			}
		}else{
			$url="../page/index.php?m=".cls_sistema::get_id_alias("NEWS");
		}
	}
	header("Location:".$url);
?>
