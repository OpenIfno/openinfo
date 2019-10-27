<?php
	$system_nivel_prof = "../admin/";
	require_once($system_nivel_prof."clases/cls.sistema.php");
	require_once($system_nivel_prof."clases/cls.traducirentidad.php");
	require_once($system_nivel_prof."funciones/funciones.php");
	$_oControl = cls_control::get_instancia();
//_Para la configuracion
  $query_page = "SELECT * FROM config_web LIMIT 1";
  $rs_page = $_oControl->consulta($query_page);
  $tot_page = $_oControl->nroregistros;
  if($tot_page>0){
		$datos_page = $_oControl->obtener_cursor($rs_page);
		$page_titulo = fncTraducirEntidadHTML($datos_page["titulo"]);
		$page_palabras = fncTraducirEntidadHTML($datos_page["palabra"]);
		$page_descripcion = fncTraducirEntidadHTML($datos_page["descrip"]);
		$page_fono = fncTraducirEntidadHTML($datos_page["fono"]);
		$page_direccion_1 = fncTraducirEntidadHTML($datos_page["direccion_1"]);
		$page_direccion_2 = fncTraducirEntidadHTML($datos_page["direccion_2"]);
		$page_email = fncTraducirEntidadHTML($datos_page["email_cont"]);
  }
?>