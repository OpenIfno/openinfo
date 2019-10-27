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
		$task = "edit";
		$titulo = fncCodificar($_POST["titulo"]);
		$subtitulo = fncCodificar($_POST["subtitulo"]);
		$titulo2 = fncCodificar($_POST["titulo2"]);
		$detalle1 = fncCodificar($_POST["detalle1"]);
		$detalle2 = fncCodificar($_POST["detalle2"]);
		$mensaje = fncCodificar($_POST["mensaje"]);
		$archivo = $_FILES["imagen"]["name"];
		$temporal = $_FILES["imagen"]["tmp_name"];
		$ancho_imagen = 800; //ancho maximo de las imagenes
		$destino = "../../web/img/nosotros/";//ruta de destino de las imagenes
	//_Desinfeccion de Archivos
		if(fncValidarMalicioso($archivo)==0 && trim($titulo)<>""){
			if($task=="edit"){ $img_ANTES=$_POST["img_antes"];}
			$img_delete = GetSQLValueString(isset($_POST["eliminar"]) ? "true" : "", "defined","si","no");
			if($img_delete=="no"){
				if($archivo<>""){
					$permitida = fncValidarImagen($archivo);
					if($permitida==1){
						$prefijo = "img_";
						list($ancho,$alto) = getimagesize($temporal);
						$imgXG = new Images($archivo,$destino,$temporal,$prefijo,true,$ancho_imagen);
						if($ancho>=$ancho_imagen){$ancho=$ancho_imagen;}
						$img = $imgXG->subir($ancho,$alto,1);
					}else{ $img[0] = "";}
					if($task=="edit"){
						if($img_ANTES<>"" && file_exists($destino.$img_ANTES)){unlink($destino.$img_ANTES);}
					}
				}else{
					if($task=="new"){ $img[0]=""; }else{ $img[0]=$img_ANTES;}
				}
			}else{
				$img[0]="";
				if($img_ANTES<>"" && file_exists($destino.$img_ANTES)){unlink($destino.$img_ANTES);}
			}
		//_Formateo final
			$img[0] = fncValidarCadenaBD($img[0]);
		//_Insercion en la bbdd
			$_oControl = cls_control::get_instancia();
				$id_seccion = $_POST["id_seccion"];
				if(fncVerificarID($id_seccion)==1){
					$consulta = "SELECT id_seccion FROM nosotros WHERE id_seccion='".$id_seccion."'";
					$rs = $_oControl->consulta($consulta);
					$total = $_oControl->nroregistros;
					if($total>0){
						$consulta = "UPDATE nosotros
												 SET id_usuario = '".$_SESSION["adm_id"]."',
														 titulo = '".$titulo."',
														 subtitulo = '".$subtitulo."',
														 titulo2 = '".$titulo2."',
														 descripcion1 = '".$detalle1."',
														 descripcion2 = '".$detalle2."',
														 mensaje = '".$mensaje."',
														 img = ".$img[0]."
												 WHERE id_seccion='".$id_seccion."'";
						$mantto = $_oControl->mantto($consulta);
						if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("SEC_NOSOTROS"); }
					}
				}
		}else{
			$url="../page/index.php";
		}
	}
	header("Location:".$url);
?>