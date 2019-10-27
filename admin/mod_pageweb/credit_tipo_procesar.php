<?php
	$id_modulo_sist = $_POST["id_modulo_sist"];
	require_once("../scripts/include.php");
	$url = "../page/index.php";
	if(isset($_POST["MM_mantto"])&& trim($_POST["MM_mantto"])=="frm_mantto"){
		//Recepcion de variables
		$task = $_POST["task"];
		$nombre = fncCodificar($_POST["nombre"]);
		$filtro = fncCodificar($_POST["filtro"]);
		$estado = $_POST["estado"];

		//_Insercion en la bbdd
			$_oControl = cls_control::get_instancia();
			if($task=="new"){
				if(trim($nombre)<>""){
					$consulta = "INSERT INTO gallery_tipo(nombre,filter,estado)
											 VALUES('".$nombre."','".$filtro."','".$estado."')";
					$mantto = $_oControl->mantto($consulta);
					if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("TIP_COLECCION"); }
				}
			}elseif($task="edit"){
				$id_tipo = $_POST["id_tipo"];
				if(fncVerificarID($id_tipo)==1){
					$consulta = "SELECT id_tipo FROM gallery_tipo WHERE id_tipo='".$id_tipo."'";
					$rs = $_oControl->consulta($consulta);
					$total = $_oControl->nroregistros;
					if($total>0){
						$consulta = "UPDATE gallery_tipo
												 SET nombre = '".$nombre."',
														 filter = '".$filtro."',
														 estado = '".$estado."'
												 WHERE id_tipo='".$id_tipo."'";
						$mantto = $_oControl->mantto($consulta);
						if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("TIP_COLECCION"); }
					}
				}
			}
	}
	header("Location:".$url);
?>
