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
		$nombre = fncCodificar($_POST["nombre"]);
		$detalle = fncCodificarEntidadHTML($_POST["detalle"]);
		$estado = $_POST["estado"];
		$orden = $_POST["orden"];
		$id_slider= $_POST["id_slider"];
		$archivo = $_FILES["imagen"]["name"];
		$temporal = $_FILES["imagen"]["tmp_name"];
		$ancho_imagen = 800; //ancho maximo de las imagenes
		$ancho_thumb = 233;
		$destino = "../../web/img/slider/";//ruta de destino de las imagenes
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
						$imgXG = new Images($archivo,$destino,$temporal,$prefijo,true,$ancho_thumb);
						if($ancho>=$ancho_imagen){$ancho=$ancho_imagen;}
						$img = $imgXG->subirImage($ancho,$alto,1);
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
			if($task=="new"){
				if(trim($titulo)<>""){
					$consulta = "INSERT INTO slider(id_usuario,nombre,titulo,descrip,img,estado,orden)
											 VALUES('".$_SESSION["adm_id"]."','".$nombre."','".$titulo."','".$detalle."',
											 	".$img[0].",'".$estado."','".$orden."')";
					$mantto = $_oControl->mantto($consulta);
					if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("SLIDER"); }
				}
			}elseif($task="edit"){
				$id_slider = $_POST["id_slider"];
				if(fncVerificarID($id_slider)==1){
					$consulta = "SELECT id_slider FROM slider WHERE id_slider='".$id_slider."'";
					$rs = $_oControl->consulta($consulta);
					$total = $_oControl->nroregistros;
					if($total>0){
						$consulta = "UPDATE slider
												 SET id_usuario = '".$_SESSION["adm_id"]."',
														 titulo = '".$titulo."',
														 nombre = '".$nombre."',
														 descrip = '".$detalle."',
														 img = ".$img[0].",
														 estado = '".$estado."',
														 orden = '".$orden."'
												 WHERE id_slider='".$id_slider."'";
						$mantto = $_oControl->mantto($consulta);
						if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("SLIDER"); }
					}
				}
			}
		}else{
			$url="../page/index.php?m=".cls_sistema::get_id_alias("SLIDER");
		}
	}
	header("Location:".$url);
?>
