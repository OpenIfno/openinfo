<?php
$id_modulo_sist = $_POST["m"];
require_once("../scripts/include.php");
$rpt = "no";
if(isset($_POST['id']) && trim($_POST['id'])<>""){
	$reg_id = fncSeguridad($_POST["id"]);
	if(fncVerificarID($reg_id)==1){
		$_oControl = cls_control::get_instancia();
		$consulta = "SELECT id_smm FROM team_smm WHERE id_smm='".$reg_id."'";
		$rs = $_oControl->consulta($consulta);
		$total = $_oControl->nroregistros;
		if($total<>0){
			$reg_es = fncSeguridad($_POST["es"]);
			if(trim($reg_es)<>"" && ($reg_es=="A" || $reg_es=="I")){
				$editar = $_oControl->mantto("UPDATE team_smm SET estado='".$reg_es."' WHERE id_smm='".$reg_id."'");
				if($editar==true){ $rpt="si"; }
			}
		}
	}
}
echo $rpt;
?>
