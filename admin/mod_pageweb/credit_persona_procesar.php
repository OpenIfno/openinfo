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
		$nombres = fncCodificar($_POST["nombres"]);
		$apellidos = fncCodificar($_POST["apellidos"]);
		$especialidad = fncCodificar($_POST["especialidad"]);
		$estado = $_POST["estado"];
		$archivo = $_FILES["imagen"]["name"];
		$temporal = $_FILES["imagen"]["tmp_name"];
		$ancho_imagen = 800; //ancho maximo de las imagenes
		$ancho_thumb = 360;
		$destino = "../../web/img/team/";//ruta de destino de las imagenes
	//_Desinfeccion de Archivos
		if(fncValidarMalicioso($archivo)==0 && trim($nombres)<>""){
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
				if(trim($nombres)<>""){
					$consulta = "INSERT INTO team(id_usuario,nombres,apellidos,especialidad,img,thumb,estado)
											 VALUES('".$_SESSION["adm_id"]."','".$nombres."','".$apellidos."','".$especialidad."',
											 ".$img[0].",".$img[1].",'".$estado."')";
					$mantto = $_oControl->mantto($consulta);
					if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("TEAM"); }
				}
			}elseif($task="edit"){
				$id_persona = $_POST["id_persona"];
				if(fncVerificarID($id_persona)==1){
					$consulta = "SELECT id_persona FROM team WHERE id_persona='".$id_persona."'";
					$rs = $_oControl->consulta($consulta);
					$total = $_oControl->nroregistros;
					if($total>0){
						$consulta = "UPDATE team
												 SET id_usuario = '".$_SESSION["adm_id"]."',
														 nombres = '".$nombres."',
														 apellidos = '".$apellidos."',
														 especialidad = '".$especialidad."',
														 img = ".$img[0].",
														 thumb = ".$img[1].",
														 estado = '".$estado."'
												 WHERE id_persona='".$id_persona."'";
						$mantto = $_oControl->mantto($consulta);
						if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("TEAM"); }
					}
				}
			}
		}else{
			$url="../page/index.php?m=".cls_sistema::get_id_alias("TEAM");
		}
	}
	header("Location:".$url);
?>
