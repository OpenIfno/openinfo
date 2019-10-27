<?php
	require_once("../scripts/permiso.php");
	$id_mod_listar = cls_sistema::get_id_alias("CAT_NEWS");
	$id_mod_agregar = cls_sistema::get_id_alias("ADD_CAT");
	$id_mod_editar = cls_sistema::get_id_alias("EDIT_CAT");
	$nombre_aplicacion = cls_sistema::get_nombre_aplicacion($id_mod_agregar);
	$mod_app_procesar = cls_sistema::get_app_procesar($id_mod_agregar);
	switch($id_modulo_sist){
		case $id_mod_agregar: $task="new"; break; //------> AGREGAR registro
		case $id_mod_editar: $task="edit"; break; //------> EDITAR registro
		default: $task=""; break;
	}
	$url_listar = "<script language='javascript'>document.location.href='../page/index.php?m=".$id_mod_listar."';</script>";
	if(trim($task)=="new" || trim($task)=="edit"){
		if(trim($task)=="new"){
			$title = "Agregar Categoría";
      // $query_ord = "SELECT MAX(orden) as orden FROM events";
      // $rs_ord = $_oControl->consulta($query_ord);
      // $total_ord = $_oControl->nroregistros;
      // if($total_ord>0){
      //   $datos_ord = $_oControl->obtener_cursor($rs_ord);
      //   $reg_orden = $datos_ord["orden"]+1;
      // }else{
      //   $reg_orden = 1;
      // }
		}elseif(trim($task)=="edit"){
			$id_categoria = fncSeguridad($_GET["id"]);
			if(fncVerificarID($id_categoria)==1){
				$title = "Editar Noticia";
				$_oControl = cls_control::get_instancia();
				$consulta = "SELECT * FROM categoria WHERE id_categoria='".$id_categoria."'";
				$rs = $_oControl->consulta($consulta);
				$total = $_oControl->nroregistros;
				if($total<>0){
					$datos = $_oControl->obtener_cursor($rs);
          $reg_nombre = $datos["nombre"];
					$reg_est = $datos["estado"];
				}else{ echo $url_listar; }
			}else{ echo $url_listar; }
		}else{ echo $url_listar; }
	}else{ echo $url_listar; }
?>

<div class="col-lg-12">
<form action="<?php echo $mod_app_procesar; ?>" method="post" name="frm_mantto" enctype="multipart/form-data" class="form-horizontal">
  <div class="card">
    <div class="card-header">
      <?php echo $nombre_aplicacion; ?>
		</div>
		<div class="card-body card-block">
			</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="titulo" class=" form-control-label">Nombre:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
            <input type="text" id="nombre" name="nombre" value="<?php if($task=="edit"){echo $reg_nombre;} ?>" class="form-control">
          </div>
				</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="estado" class=" form-control-label">Estado:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
						<?php
						if($task=="new"){
							$btn_estado = "<input type='hidden' id='estado' name='estado' value='A' class='form-control'>";
							$btn_estado .= "<span class='role member'>Activo</span>";
						}else{
							$btn_estado = "<input type='hidden' id='estado' name='estado' value='".$reg_est."' class='form-control'>";
							if($reg_est=="A"){
								$btn_estado .= "<span class='role member'>Activo</span>";
							}else{ $btn_estado .= "<span class='role admin'>Inactivo</span>"; }
						}
						echo $btn_estado;
						?>
          </div>
				</div>
				<input type="hidden" name="task" value="<?php echo $task; ?>">
						<input type="hidden" name="id_categoria" value="<?php echo $id_categoria; ?>">
						<input type="hidden" name="id_modulo_sist" value="<?php echo $id_modulo_sist; ?>">
						<input type="hidden" name="MM_mantto" value="frm_mantto" />
				<div class="card-footer">
				<div class="center-block">
				<div class="col-md-5 col-md-offset-4">
					<button type="submit" class="btn btn-primary btn-sm">
						<i class="fa fa-dot-circle-o"></i> Guardar
					</button>
					<button type="reset" class="btn btn-default btn-sm">
						<i class="fa fa-eraser"></i> Restaurar
					</button>
					<button type="button" class="btn btn-danger btn-sm" onClick="location.href='../page/index.php?m=<?php echo $id_mod_listar; ?>'">
						<i class="fa fa-ban"></i> Cancelar
					</button>
				</div>
			</div>
		</div>
					</div>
	</div>
	</form>
</div>
