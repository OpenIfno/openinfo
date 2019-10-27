<?php
	$id_modulo_sist = $_POST["id_modulo_sist"];
	require_once("../scripts/include.php");
	$url = "../page/index.php";
	if(isset($_POST["MM_mantto"])&& trim($_POST["MM_mantto"])=="frm_mantto"){
		//Recepcion de variables
		$task = $_POST["task"];
		$nombre = fncCodificar($_POST["nombre"]);
		$estado = $_POST["estado"];

		//_Insercion en la bbdd
			$_oControl = cls_control::get_instancia();
			if($task=="new"){
				if(trim($nombre)<>""){
					$consulta = "INSERT INTO categoria(nombre,estado)
											 VALUES('".$nombre."','".$estado."')";
					$mantto = $_oControl->mantto($consulta);
					if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("CAT_NEWS"); }
				}
			}elseif($task="edit"){
				$id_categoria = $_POST["id_categoria"];
				if(fncVerificarID($id_categoria)==1){
					$consulta = "SELECT id_categoria FROM categoria WHERE id_categoria='".$id_categoria."'";
					$rs = $_oControl->consulta($consulta);
					$total = $_oControl->nroregistros;
					if($total>0){
						$consulta = "UPDATE categoria
												 SET nombre = '".$nombre."',
														 estado = '".$estado."'
												 WHERE id_categoria='".$id_categoria."'";
						$mantto = $_oControl->mantto($consulta);
						if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("CAT_NEWS"); }
					}
				}
			}
	}
	header("Location:".$url);
?>
