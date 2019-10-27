<?php
require_once('../clases/cls.control.php');
require_once('../funciones/funciones.php');
class cls_login{
	public static function loguear($login = "-1", $pwd = "-1"){
		$rpt = 0;
		$_oControl = cls_control::get_instancia();
		$query_usu = "SELECT u.id_usuario, ud.nombre AS usuario
									FROM usuario u, usuario_det ud 
									WHERE u.id_usuario=ud.id_usuario AND u.estado='A' AND u.usuario='".$login."' AND u.clave='".base64_encode($pwd)."'";
		$rs_usu = $_oControl->consulta($query_usu);
		$total_usu = $_oControl->nroregistros;
		if($total_usu>0){ //--------> Login Exitoso
			$datos_usu = $_oControl->obtener_cursor($rs_usu);
			$usu_id = $datos_usu["id_usuario"];
			$usu_nombre = fncTraducirEntidadHTML($datos_usu["usuario"]);
			if(fncVerificarID($usu_id)==1){
			//_Para obtener el PRIMER rol activo de este usuario
				$query_rol = "SELECT ur.id_usurol, r.id_rol, r.nombre
											FROM usuario_rol ur, rol r
											WHERE ur.id_rol=r.id_rol AND r.estado='A' AND ur.estado='A' AND ur.id_usuario='".$usu_id."' 
											ORDER BY id_rol ASC OFFSET 0 LIMIT 1";
				$rs_rol = $_oControl->consulta($query_rol);
				$total_rol = $_oControl->nroregistros;
				if($total_rol>0){
					$rpt = 1;
					$datos_rol = $_oControl->obtener_cursor($rs_rol);
					if(!isset($_SESSION)){ @session_start(); }
					$_SESSION["adm_autenticado"] = "SI";
					$_SESSION["adm_id"] = $usu_id; //----------------------> USUARIO ID (id_usuario)
					$_SESSION["adm_login"] = $login; //--------------------> USUARIO LOGIN (usuario)
					$_SESSION["adm_nombre"] = $usu_nombre; //--------------> USUARIO NOMBRE (nombre)
					$_SESSION["adm_rol_activo"] = $datos_rol["id_rol"]; //-> ROL ID (id_rol)
				}
			}
		}
		return $rpt;
	}
	
	public static function cerrar_sesion(){
		if(!isset($_SESSION)){ @session_start(); }
		session_destroy();
		return(0);
	}
	
	public static function seguridad(){
		if(!isset($_SESSION)){ @session_start(); }
		if(isset($_SESSION["adm_autenticado"]) && $_SESSION["adm_autenticado"]=="SI"){
			$estado_usr = "1";
		}else{
			$estado_usr = "0";
		}
		return ($estado_usr);
	}

}
?>