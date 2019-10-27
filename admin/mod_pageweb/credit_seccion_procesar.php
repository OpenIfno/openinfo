<?php
	$id_modulo_sist = $_POST["id_modulo_sist"];
	require_once("../scripts/include.php");
	$url = "../page/index.php";
	if(isset($_POST["MM_mantto"])&& trim($_POST["MM_mantto"])=="frm_mantto"){
		//Recepcion de variables
		$task = $_POST["task"];
		$titulo = fncCodificar($_POST["titulo"]);
		$detalle = fncCodificarEntidadHTML($_POST["detalle"]);
		$icono = $_POST["icono"];
		$url = $_POST["url"];
		$estado = $_POST["estado"];
		//_Insercion en la bbdd
			$_oControl = cls_control::get_instancia();
			if($task=="new"){
				if(trim($titulo)<>""){
					$consulta = "INSERT INTO features(id_usuario,titulo,descripcion,icon,url,estado)
											 VALUES('".$_SESSION["adm_id"]."','".$titulo."','".$detalle."',
											 '".$icono."','".$url."','".$estado."')";
					$mantto = $_oControl->mantto($consulta);
					if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("FEATURES"); }
				}
			}elseif($task="edit"){
					$id_seccion = $_POST["id_seccion"];
				if(fncVerificarID($id_seccion)==1){
					$consulta = "SELECT id_feature FROM features WHERE id_feature='".$id_seccion."'";
					$rs = $_oControl->consulta($consulta);
					$total = $_oControl->nroregistros;
					if($total>0){
						$consulta = "UPDATE features
												 SET id_usuario = '".$_SESSION["adm_id"]."',
														 titulo = '".$titulo."',
														 descripcion = '".$detalle."',
														 icon = '".$icono."',
														 url = '".$url."',
														 estado = '".$estado."'
												 WHERE id_feature='".$id_seccion."'";
						$mantto = $_oControl->mantto($consulta);
						if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("FEATURES"); }
					}
				}
			}
	}
	header("Location:".$url);
?>
