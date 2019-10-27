<?php
if (!isset($_SESSION)){ @session_start(); }
require_once("cls.control.php");
class cls_sistema{
	private static $opc_mnu;
//_Evitamos el clonaje del objeto
	private function __clone(){
		trigger_error('Esta clase no puede clonarse', E_USER_ERROR);
	}
//_Para obtener el ID de una aplicacion dependiendo de su ALIAS
	public static function get_id_alias($alias=""){
		if(trim($alias)<>""){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT id_aplicacion FROM aplicacion WHERE alias='".$alias."'";
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total==0){ return ""; }
			else{
				$datos = $_oControl->obtener_cursor($rs);
				return $datos["id_aplicacion"];
			}
		}else{ return ""; }
	}
//_Para obtener el URL de una aplicacion dependiendo de su ID
	public static function get_url_aplicacion($id_aplicacion="",$mantto="no"){
		if(trim($id_aplicacion)<>""){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT carpeta, archivo, archivo_mantto FROM aplicacion WHERE id_aplicacion='".$id_aplicacion."'";
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total==0){ return ""; }
			else{
				$datos = $_oControl->obtener_cursor($rs);
				if($mantto=="no"){ //--> Se obtiene el archivo de listado
					if(trim($datos["carpeta"])<>"" && trim($datos["archivo"])<>""){
						return("../".$datos["carpeta"]."/".$datos["archivo"]);
					}else{
						return "";
					}
				}else{ //--------------> Se obtiene el archivo de mantenimiento
					if(trim($datos["carpeta"])<>"" && trim($datos["archivo_mantto"])<>""){
						return("../".$datos["carpeta"]."/".$datos["archivo_mantto"]);
					}else{
						return "";
					}
				}
			}
		}else{ return ""; }
	}
//_Para obtener la CARPETA de una aplicacion dependiendo de su ID o ALIAS
	public static function get_carpeta_aplicacion($id_aplicacion="",$tipo=""){ //--> Tipo: define si es por ID o por ALIAS
		if(trim($id_aplicacion)<>""){
			$_oControl = cls_control::get_instancia();
			if(trim($tipo)==""){ //--> Si esta en blanco se sobreentiende que es por ID
				$consulta = "SELECT carpeta FROM adm.aplicacion WHERE id_aplicacion='".$id_aplicacion."'";
			}else{ //----------------> Si contiene valor se asume que la busqueda es por ALIAS
				$consulta = "SELECT carpeta FROM adm.aplicacion WHERE alias='".$id_aplicacion."'";
			}
			$rs = $_oControl->consulta($consulta);
			if($rs==0){ return ""; }
			else{
				$datos = $_oControl->obtener_cursor($rs);
				if(trim($datos["carpeta"])<>""){
					return(fncTraducirEntidadHTML($datos["carpeta"]));
				}else{
					return "";
				}
			}
		}else{ return ""; }
	}
//_Para obtener el NOMBRE de una aplicacion dependiendo de su ID o ALIAS
	public static function get_nombre_aplicacion($id_aplicacion="",$tipo=""){ //--> Tipo: define si es por ID o por ALIAS
		if(trim($id_aplicacion)<>""){
			$_oControl = cls_control::get_instancia();
			if(trim($tipo)==""){ //--> Si esta en blanco se sobreentiende que es por ID
				$consulta = "SELECT nombre FROM aplicacion WHERE id_aplicacion='".$id_aplicacion."'";
			}else{ //----------------> Si contiene valor se asume que la busqueda es por ALIAS
				$consulta = "SELECT nombre FROM aplicacion WHERE alias='".$id_aplicacion."'";
			}
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total==0){ return ""; }
			else{
				$datos = $_oControl->obtener_cursor($rs);
				if(trim($datos["nombre"])<>""){
					return(fncTraducirEntidadHTML($datos["nombre"]));
				}else{
					return "";
				}
			}
		}else{ return ""; }
	}
//_Para obtener la CLASE de una aplicacion dependiendo de su ID o ALIAS
public static function get_class_aplicacion($id_aplicacion="",$tipo=""){ //--> Tipo: define si es por ID o por ALIAS
	if(trim($id_aplicacion)<>""){
		$_oControl = cls_control::get_instancia();
		if(trim($tipo)==""){ //--> Si esta en blanco se sobreentiende que es por ID
			$consulta = "SELECT class FROM aplicacion WHERE id_aplicacion='".$id_aplicacion."'";
		}else{ //----------------> Si contiene valor se asume que la busqueda es por ALIAS
			$consulta = "SELECT class FROM aplicacion WHERE alias='".$id_aplicacion."'";
		}
		$rs = $_oControl->consulta($consulta);
		$total = $_oControl->nroregistros;
		if($total==0){ return ""; }
		else{
			$datos = $_oControl->obtener_cursor($rs);
			if(trim($datos["class"])<>""){
				return($datos["class"]);
			}else{
				return "";
			}
		}
	}else{ return ""; }
}
//_Para obtener el script procesar de una aplicacion dependiendo de su ID o ALIAS
public static function get_app_procesar($id_aplicacion="",$tipo=""){ //--> Tipo: define si es por ID o por ALIAS
	if(trim($id_aplicacion)<>""){
		$_oControl = cls_control::get_instancia();
		if(trim($tipo)==""){ //--> Si esta en blanco se sobreentiende que es por ID
			$consulta = "SELECT carpeta,archivo_mantto FROM aplicacion WHERE id_aplicacion='".$id_aplicacion."'";
		}else{ //----------------> Si contiene valor se asume que la busqueda es por ALIAS
			$consulta = "SELECT carpeta,archivo_mantto FROM aplicacion WHERE alias='".$id_aplicacion."'";
		}
		$rs = $_oControl->consulta($consulta);
		$total = $_oControl->nroregistros;
		if($total==0){ return ""; }
		else{
			$datos = $_oControl->obtener_cursor($rs);
			if(trim($datos["archivo_mantto"])<>""){
				return("../".$datos["carpeta"]."/".$datos["archivo_mantto"]);
			}else{
				return "";
			}
		}
	}else{ return ""; }
}
//_Para evaluar si se tiene PERMISO a una aplicacion
	public static function get_permiso_aplicacion($id_aplicacion="",$tipo=2){
		$ret="";
		if(fncVerificarID($id_aplicacion)==1){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT ra.id_rolapli 
									 FROM adm.aplicacion a, adm.rol_aplicacion ra, adm.rol r, adm.usuario_rol ur
									 WHERE a.id_aplicacion=ra.id_aplicacion AND ra.id_rol=r.id_rol AND r.id_rol=ur.id_rol AND a.estado='A' AND 
												 ra.estado='A' AND r.estado='A' AND ur.estado='A' AND
												 ra.id_aplicacion='".$id_aplicacion."' AND ur.id_rol='".$_SESSION["adm_rol_activo"]."' AND 
												 ur.id_usuario='".$_SESSION["adm_id"]."'";
			$total = $_oControl->totalRegistros($consulta);
			if($total==0){ 
				if($tipo=="" || $tipo==2){
					$ret = "<script language='javascript'>document.location.href='../page/index.php';</script>";
				}else{
					$ret = 0;
				}
			}else{
				if($tipo=="" || $tipo==2){ $ret=""; }else{ $ret=1; }
			}
		}else{ 
			if($tipo=="" || $tipo==2){
				$ret = "<script language='javascript'>document.location.href='../page/index.php';</script>";
			}else{
				$ret = 0;
			}
		}
		return $ret;
	}
//_Para actualizar el estado de todos los hijos cuando el padre esta desactivado
	public function set_estado_aplicacion($id_rol="",$id_padre=0){
		if(fncVerificarID($id_rol)==1 && fncVerificarIdMenu($id_padre)==1){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT a.id_aplicacion, ra.estado, a2.count 
									 FROM adm.rol_aplicacion ra JOIN adm.aplicacion a ON ra.id_aplicacion=a.id_aplicacion LEFT OUTER JOIN 
										   (SELECT id_padre, COUNT(*) AS count FROM adm.aplicacion GROUP BY id_padre) a2 ON a.id_aplicacion = a2.id_padre
									 WHERE ra.id_rol='".$id_rol."' AND a.id_padre='".$id_padre."' ORDER BY a.orden ASC";
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total>0){
				while($datos=$_oControl->obtener_cursor($rs)){
					$id_aplicacion = $datos["id_aplicacion"];
					$estado = $datos["estado"];
					$count = $datos["count"];
					if($count>0){ //---> Tiene Hijos
						if($estado=="I"){
							$consul_bd = "UPDATE adm.rol_aplicacion AS ra SET estado='".$estado."'
														FROM adm.aplicacion AS a
														WHERE ra.id_aplicacion=a.id_aplicacion AND ra.id_rol='".$id_rol."' AND a.id_padre='".$id_aplicacion."'";
							$_oControl->mantto($consul_bd);
							self::set_estado_aplicacion($id_rol,$id_aplicacion);
						}
					}
				}
			}
			return 0;
		}
	}
//_Para obtener el padre final de una opcion del menu del sistema
	public static function get_idpadremenu($id_aplicacion="",$app_tipo=""){
		if(fncVerificarID($id_aplicacion)==1 && trim($app_tipo)<>""){
			$_oControl = cls_control::get_instancia();
			$consulta = "SELECT id_aplicacion, id_padre, tipo FROM aplicacion WHERE id_aplicacion='".$id_aplicacion."'";
			$rs = $_oControl->consulta($consulta);
			$total = $_oControl->nroregistros;
			if($total<>0){
				$datos = $_oControl->obtener_cursor($rs);
				$id_mod = $datos["id_aplicacion"];
				echo $id_mod;
				$id_padre = $datos["id_padre"];
				$tipo = $datos["tipo"];
				if($tipo<>$app_tipo){
					$rpt = self::get_idpadremenu($id_padre,$app_tipo);
					echo "rpt:".$rpt;
				}else{
					$rpt = $id_mod;
					echo "rpt:".$rpt;
				}
			}
		}
		return $rpt;
	}

//_Para mostrar la barra de menu del sistema
public static function get_menu($id_modulo_sist=""){
	$menu = "";
    $active = "";
    $_oControl = cls_control::get_instancia();
    $query = "SELECT * FROM aplicacion a WHERE a.id_padre='0' AND a.visible='si' ORDER BY a.orden ASC";
    $rs = $_oControl->consulta($query);
    $total = $_oControl->nroregistros;
    if($total>0){
        while($datos = $_oControl->obtener_cursor($rs)){
            $cat_id = $datos["id_aplicacion"];
            $active = "";
            if($id_modulo_sist==$cat_id){ $active= "active";}
        	$cat_id_padre = $datos["id_padre"];
            $cat_nombre = fncTraducirEntidadHTML($datos["nombre"]);
            $cat_class = fncTraducirEntidadHTML($datos["class"]);
            $query_apli = "SELECT * FROM aplicacion a WHERE a.id_padre='".$cat_id."' ORDER BY a.orden ASC";
            $rs_apli = $_oControl->consulta($query_apli);
            $total_apli = $_oControl->nroregistros;
            if($total_apli>0){
                $menu.= "
                        <li class='has-sub ".$active."'>
                        	<a class='js-arrow open' href='#'>
                                <i class='".$cat_class."'></i>".$cat_nombre."</a>
                                <ul class='navbar-mobile-sub__list list-unstyled js-sub-list' style='display:block;'>";
                                while($datos_apli = $_oControl->obtener_cursor($rs_apli)){
                                    $apli_id = $datos_apli["id_aplicacion"];
                                    $active = "";
                                    if($id_modulo_sist==$apli_id){ $active= "active";}
                                    $apli_nombre = fncTraducirEntidadHTML($datos_apli["nombre"]);
                                    $apli_class = fncTraducirEntidadHTML($datos_apli["class"]);
                                    $menu.=	
                                            "<li class='".$active."'>
                                                <a href='index.php?m=".$apli_id."'><i class='".$apli_class."'></i>".$apli_nombre."</a>
                                            </li>";
                                }
            	$menu.= "</ul>";
                $menu.= "</li>";
            }else{
                $menu.=	
                        "<li>
                            <a href='index.php?m=".$cat_id."'>".$cat_nombre."</a>
                        </li>";
            }
        }
    }
    return $menu;
}

//Para header de administrador
public static function get_header(){
	$header = "";
    $active = "";
    $_oControl = cls_control::get_instancia();
    $query = "SELECT * FROM usuario_det WHERE id_usuario='".$_SESSION["adm_id"]."'";
    $rs = $_oControl->consulta($query);
    $total = $_oControl->nroregistros;
    if($total>0){
        while($datos = $_oControl->obtener_cursor($rs)){
			$cat_nombre = $datos["nombre"];
			$cat_email = $datos["email"];
            $active = "";
            $header.= "
					<div class='image'>
						<img src='../images/icon/logo.png' alt='OpenInfo' />
					</div>
					<div class='content'>
						<a class='js-acc-btn' href='#'>".$cat_nombre."</a>
					</div>
					<div class='account-dropdown js-dropdown'>
						<div class='info clearfix'>
							<div class='image'>
								<a href='#'>
									<img src='../images/icon/logo.png' alt='JOpenInfo' />
								</a>
							</div>
					<div class='content'>
						<h5 class='name'>
							<a href='#'>".$cat_nombre."</a>
						</h5>
						<span class='email'>".$cat_email."</span>
					</div>
			</div>
			<div class='account-dropdown__body'>
				<div class='account-dropdown__item'>
					<a href='#'>
						<i class='zmdi zmdi-account'></i>Perfil</a>
				</div>
				<div class='account-dropdown__item'>
					<a href='#'>
						<i class='zmdi zmdi-settings'></i>Configuraci&oacute;n</a>
				</div>
			</div>
			<div class='account-dropdown__footer'>
				<a href='../scripts/salir.php'>
					<i class='zmdi zmdi-power'></i>Cerrar sesi&oacute;n</a>
			</div>
		</div>";
        }
    }
    return $header;
}

//_Para obtener la barra de navegacion del sistema (REVISAR)
	public static function get_barra_nav(){
		$consulta_nav = "SELECT * FROM aplicacion WHERE id_padre='0' AND web_menu='si' ORDER BY orden ASC";
        $rs_nav = $_oControl->consulta($consulta_nav);
		$total = $_oControl->nroregistros;
		$barra="";
        if($total > 0){
            while($datos = $_oControl->obtener_cursor($rs_nav)){
				$barra .= "<li><a href='".$datos["url"]."'>".$datos["nombre"]."</a></li>";
			}}
		return($barra);
	}
//_Para obtener el listado de aplicaciones en forma de arbol
	public static function get_lista_aplicaciones($padre="",$id_mod_listar=0,$id_mod_estado=0,$id_mod_editar=0,$id_mod_eliminar=0,$permiso_mod_estado=0,$permiso_mod_editar=0,$permiso_mod_eliminar=0,$permiso_mod_hijos="",$arr_reg="",$mod_estado_url="",$mod_eliminar_url="",$tipo_mod="",$arr_apli_rol="",$prefix=""){
		static $tab=0;
		static $fila=0;
		static $iteracion=0;
		static $tot_hijos=array();
		static $numeracion=array();
		if(fncVerificarIdMenu($padre)==1){
			$query = "SELECT a.id_aplicacion, a.id_padre, a.nombre, a.alias, a.tipo, a.carpeta, a.archivo, a.estado,
										   (CASE WHEN a.id_padre<>0 THEN (SELECT p.nombre FROM adm.aplicacion p WHERE p.id_aplicacion=a.id_padre) ELSE 'SIN PADRE' END) AS padre
								FROM adm.aplicacion a WHERE a.id_padre='".$padre."' ORDER BY a.orden ASC";
			$_oControl = cls_control::get_instancia();
			$rsRegistros = $_oControl->consulta($query);
			if($rsRegistros<>0){
				$aux=0; $aux2=1;
				while($datos=$_oControl->obtener_cursor($rsRegistros)){
					$reg_id = $datos["id_aplicacion"];
					$reg_padre = fncTraducirEntidadHTML($datos["padre"]);
					$reg_nombre = fncTraducirEntidadHTML($datos["nombre"]);
					$reg_alias = fncTraducirEntidadHTML($datos["alias"]);
					$reg_tipo = $datos["tipo"];
					$reg_carpeta = fncComprobarEntradaTexto($datos["carpeta"]);
					$reg_archivo = fncComprobarEntradaTexto($datos["archivo"]);
					if($tipo_mod=="usuarios" && is_array($arr_apli_rol)){
						if(in_array($reg_id,$arr_apli_rol)){
							$aux++; $fila++;
							if($padre==0){
								$tab++; $aux2=1; $iteracion=1; $tot_hijos[$iteracion]=0; $numeracion[$iteracion]=$tab;
								$txt_modulo=$reg_nombre; $css_apli="exg_apli";
							}elseif($fila==1){
								$tab++; $aux2=1; $iteracion=1; $tot_hijos[$iteracion]=0; $numeracion[$iteracion]=$tab;
								$txt_modulo=$reg_nombre; $css_apli="";
							}else{
								$txt_modulo=$prefix.$reg_nombre; $css_apli="";
							}
							$query_hijos = "SELECT id_aplicacion FROM adm.aplicacion WHERE id_padre='".$reg_id."'";
							$total_hijos = $_oControl->totalRegistros($query_hijos);
							$css_td = ($total_hijos>0)?"exg_bold exg_upper":"";
							$number = $numeracion[$iteracion];
							switch($reg_tipo){
								case 1: $tipo_apli="APLICACI&Oacute;N"; break;
								case 2: $tipo_apli="M&Oacute;DULO"; break;
								case 3: $tipo_apli="FUNCI&Oacute;N"; break;
							}
							$rpt.="<tr>";
							$rpt.="<td class='exg_left ".$css_td." ".$css_apli."'>".$number."</td>";
							$rpt.="<td class='exg_left ".$css_td." ".$css_apli."'>".$txt_modulo."</td>";
							$rpt.="<td class='".$css_td." ".$css_apli."'>".$reg_alias."</td>";
							$rpt.="<td class='center ".$css_td." ".$css_apli."'>".$tipo_apli."</td>";
							$rpt.="</tr>";
							if($total_hijos>0){
								$iteracion++;
								$numeracion[$iteracion]=$number.".1";
								$tot_hijos[$iteracion]=$total_hijos;
								$aux2++; $css_td="";
								$rpt.=self::get_lista_aplicaciones($reg_id,$id_mod_listar,$id_mod_estado,$id_mod_editar,$id_mod_eliminar,$permiso_mod_estado,$permiso_mod_editar,$permiso_mod_eliminar,$permiso_mod_hijos,$arr_reg,$mod_estado_url,$mod_eliminar_url,$tipo_mod,$arr_apli_rol,$prefix.$prefix);
							}else{ $aux2++; }
							if($tot_hijos[$iteracion]==$aux){ $iteracion--; }
							$numeracion[$iteracion]=$numeracion[$iteracion-1].".".$aux2;
						}else{
							$iteracion++;
							if(trim($number)==""){ $numeracion[$iteracion]=$number."1"; }else{ $numeracion[$iteracion]=$number.".1"; }
							$tot_hijos[$iteracion]=$total_hijos;
							$aux2++; $css_td="";
							$rpt.=self::get_lista_aplicaciones($reg_id,$id_mod_listar,$id_mod_estado,$id_mod_editar,$id_mod_eliminar,$permiso_mod_estado,$permiso_mod_editar,$permiso_mod_eliminar,$permiso_mod_hijos,$arr_reg,$mod_estado_url,$mod_eliminar_url,$tipo_mod,$arr_apli_rol,$prefix.$prefix);
						}
					}else{
						$aux++;
						if($padre==0){
							$tab++; $aux2=1; $iteracion=1; $tot_hijos[$iteracion]=0; $numeracion[$iteracion]=$tab;
							$txt_modulo=$reg_nombre; $css_apli="exg_apli";
						}else{
							$txt_modulo=$prefix.$reg_nombre; $css_apli="";
						}
						$query_hijos = "SELECT id_aplicacion FROM adm.aplicacion WHERE id_padre='".$reg_id."'";
						$total_hijos = $_oControl->totalRegistros($query_hijos);
						$css_td = ($total_hijos>0)?"exg_bold exg_upper":"";
						$number = $numeracion[$iteracion];
						$fila++;
						switch($reg_tipo){
							case 1: $tipo_apli="APLICACI&Oacute;N"; break;
							case 2: $tipo_apli="M&Oacute;DULO"; break;
							case 3: $tipo_apli="FUNCI&Oacute;N"; break;
						}
						$rpt.="<tr>";
						$rpt.="<td class='".$css_td." ".$css_apli."'>".$number."</td>";
						$rpt.="<td class='".$css_td." ".$css_apli."'>".$txt_modulo."</td>";
						$rpt.="<td class='".$css_td." ".$css_apli."'>".$reg_alias."</td>";
						$rpt.="<td class='center upper ".$css_td." ".$css_apli."'>".$tipo_apli."</td>";
						$rpt.="<td class='".$css_td." ".$css_apli."'>".$reg_carpeta."</td>";
						$rpt.="<td class='".$css_td." ".$css_apli."'>".$reg_archivo."</td>";
						$rpt.="<td class='center ".$css_apli."'><div class='btn-group btn-group-xs'>";
						if($tipo_mod=="modulos"){
							if($permiso_mod_estado==0){
								 $rpt.=($datos["estado"]=="A")?"<span class='label label-success'>Activo</span>":"<span class='label label-default'>Inactivo</span>";
							}else{
								 if($datos["estado"]=="A"){
								 	 $rpt.="<a href='#' class='btn btn-success tooltip_exg estado_exg' title='Estado Activo' data-placement='bottom' data-url='".$mod_estado_url."' data-params='m=".$id_mod_estado."&id=".$reg_id."&es=I'><i class='fa fa-thumbs-up'></i></a>";
								 }else{
								 	 $rpt.="<a href='#' class='btn btn-default tooltip_exg estado_exg' title='Estado Inactivo' data-placement='bottom' data-url='".$mod_estado_url."' data-params='m=".$id_mod_estado."&id=".$reg_id."&es=A'><i class='fa fa-thumbs-down'></i></a>";
								 }
							}
						}elseif($tipo_mod=="roles"){
							$rpt.=($datos["estado"]=="A")?"<span class='label label-success'>Activo</span>":"<span class='label label-default'>Inactivo</span>";
						}
						$rpt.="</div></td>";
						if($tipo_mod=="modulos"){
							$btn_editar = $btn_delete = "";
							if($permiso_mod_editar==1){
							  $btn_editar = "<a href='../page/index.php?m=".$id_mod_editar."&id=".$reg_id."' class='btn btn-info tooltip_exg' title='Editar registro' data-placement='bottom'><i class='fa fa-pencil'></i></a>"; 
							}
							if($permiso_mod_eliminar==1){
								$query_del = "SELECT ur.id_usurol FROM adm.rol_aplicacion ra, adm.usuario_rol ur WHERE ra.id_rol=ur.id_rol AND ra.id_aplicacion='".$reg_id."'";
								$tot_del = $_oControl->totalRegistros($query_del);
								if($tot_del==0){
								  $btn_delete = "<a href='#' class='btn btn-danger tooltip_exg eliminar_exg' title='Eliminar registro' data-placement='bottom' data-url='".$mod_eliminar_url."' data-params='m=".$id_mod_eliminar."&id=".$reg_id."'><i class='fa fa-trash-o'></i></a>";
								}
							}
							$rpt.="<td class='center ".$css_apli."'><div class='btn-group btn-group-xs'>".$btn_editar."&nbsp;".$btn_delete."</div></td>";
						}elseif($tipo_mod=="roles"){
							$btn_hijos = "";
							if($permiso_mod_hijos==1){
								if(in_array($reg_id,$arr_reg)){ $checked="checked='checked'"; }else{ $checked=""; }
								$btn_hijos = "<div class='make-switch' data-on='danger' data-off='default'><input name='apli_".$reg_id."' value='1' type='checkbox' ".$checked."></div>";
							}
							$rpt.="<td class='".$css_apli."'><div align='center'>".$btn_hijos."</div></td>";
						}
						$rpt.="</tr>";
						if($total_hijos>0){
							$iteracion++;
							$numeracion[$iteracion]=$number.".1";
							$tot_hijos[$iteracion]=$total_hijos;
							$aux2++; $css_td="";
							$rpt.=self::get_lista_aplicaciones($reg_id,$id_mod_listar,$id_mod_estado,$id_mod_editar,$id_mod_eliminar,$permiso_mod_estado,$permiso_mod_editar,$permiso_mod_eliminar,$permiso_mod_hijos,$arr_reg,$mod_estado_url,$mod_eliminar_url,$tipo_mod,$arr_apli_rol,$prefix.$prefix);
						}else{ $aux2++; }
						if($tot_hijos[$iteracion]==$aux){ $iteracion--; }
						$numeracion[$iteracion]=$numeracion[$iteracion-1].".".$aux2; 
					}
				}
			}
		}
		return($rpt);
	}
//_Para obtener el ultimo registro insertado
	public static function get_ultimo_id($tabla="",$campo=""){
		$rpt=1;
		if(trim($tabla)<>"" && trim($campo)<>""){
			$_oControl = cls_control::get_instancia();
			$rs = $_oControl->consulta("SELECT max(".$campo.") as ultimo FROM ".$tabla);
			$tot = $_oControl->nroregistros;
			if($tot>0){
				$datos = $_oControl->obtener_cursor($rs);
				return $datos["ultimo"];
			}
		}
		return $rpt;
	}
//_Restablecer el ID de una secuencia (serial)
	public static function get_restablecer_id($campo="",$tabla=""){
		if(trim($tabla)<>""){
			$_oControl = cls_control::get_instancia();
			$rs = $_oControl->consulta("SELECT max(".$campo.") as ultimo FROM ".$tabla);
			$tot = $_oControl->nroregistros;
			if($tot>0){
				$datos = $_oControl->obtener_cursor($rs);
				$ultimo = $datos["ultimo"];
				if(fncVerificarID($ultimo)==1){ //--------> El registro eliminado no es el ultimo de la tabla
					$reset = "ALTER TABLE $tabla AUTO_INCREMENT='$ultimo'"; // true para que se inicie en el siguiente
				}elseif($ultimo==0 || $ultimo==""){ //----> Se eliminaron todos los registros de la tabla
					$reset = "ALTER TABLE $tabla AUTO_INCREMENT=1"; // false para que se inicie en 1
				}
			}else{
				$reset = "ALTER TABLE $tabla AUTO_INCREMENT=1"; // false para que se inicie en 1
			}
			$_oControl->mantto($reset);
		}
	}
}	
?>