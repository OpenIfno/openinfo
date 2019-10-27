<?php
	$id_modulo_sist = $_POST["id_modulo_sist"];
	require_once("../scripts/include.php");
	$url = "../page/index.php";
	if(isset($_POST["MM_mantto"])&& trim($_POST["MM_mantto"])=="frm_mantto"){
		//Recepcion de variables
		$task = $_POST["task"];
		$id_persona = $_POST["id_persona"];
		$nombre = fncCodificar($_POST["nombre"]);
		$icono = $_POST["icono"];
		$url_smm = $_POST["url"];
		$estado = $_POST["estado"];

		//_Insercion en la bbdd
			$_oControl = cls_control::get_instancia();
			if($task=="new"){
				if(trim($nombre)<>""){
					$consulta = "INSERT INTO team_smm(id_persona,nombre,icono,url,estado)
											 VALUES('".$id_persona."','".$nombre."','".$icono."','".$url_smm."',
											 '".$estado."')";
					$mantto = $_oControl->mantto($consulta);
					if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("SMM_PERSONA")."&id=".$id_persona; }
				}
			}elseif($task="edit"){
				$id_smm = $_POST["id_smm"];
				if(fncVerificarID($id_smm)==1){
					$consulta = "SELECT id_smm FROM team_smm WHERE id_smm='".$id_smm."'";
					$rs = $_oControl->consulta($consulta);
					$total = $_oControl->nroregistros;
					if($total>0){
						$consulta = "UPDATE team_smm
												 SET id_persona = '".$id_persona."',
														 nombre = '".$nombre."',
														 icono = '".$icono."',
														 url = '".$url_smm."',
														 estado = '".$estado."'
												 WHERE id_smm='".$id_smm."'";
						$mantto = $_oControl->mantto($consulta);
						if($mantto==true){ $url="../page/index.php?m=".cls_sistema::get_id_alias("SMM_PERSONA")."&id=".$id_persona; }
					}
				}
			}
	}
	header("Location:".$url);
?>
