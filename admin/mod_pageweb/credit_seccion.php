<?php
	require_once("../scripts/permiso.php");
	$id_mod_listar = cls_sistema::get_id_alias("FEATURES");
	$id_mod_agregar = cls_sistema::get_id_alias("ADD_SECTION");
	$id_mod_editar = cls_sistema::get_id_alias("EDIT_SECTION");
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
			$title = "Agregar Característica";
		}elseif(trim($task)=="edit"){
			$id_seccion = fncSeguridad($_GET["id"]);
			if(fncVerificarID($id_seccion)==1){
				$title = "Editar Característica";
				$_oControl = cls_control::get_instancia();
				$consulta = "SELECT * FROM features WHERE id_feature='".$id_seccion."'";
				$rs = $_oControl->consulta($consulta);
				$total = $_oControl->nroregistros;
				if($total<>0){
					$datos = $_oControl->obtener_cursor($rs);
					$reg_id = $datos["id_feature"];
          $reg_titulo = $datos["titulo"];
					$reg_detalle = fncTraducirEntidadHTML($datos["descripcion"]);
					$reg_icono = $datos["icon"];
					$reg_url = $datos["url"];
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
			<div class="form-group">
			</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="titulo" class=" form-control-label">Titulo:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
            <input type="text" id="titulo" name="titulo" value="<?php if($task=="edit"){echo $reg_titulo;} ?>" class="form-control">
          </div>
				</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="detalle" class=" form-control-label">Detalle:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
					<textarea id="inputcleditor" name="detalle" class="cleditor col-md-12 form-control" rows="12"><?php if($task=="edit"){echo $reg_detalle;} ?></textarea>
          </div>
				</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="icono" class=" form-control-label">Ícono:</label>
						</div>
					</div>
          <div class="col-12 col-md-4">
            <input type="text" id="icono" name="icono" value="<?php if($task=="edit"){echo $reg_icono;}else{ echo "icofont-"; } ?>" class="form-control">
          </div>
						<a href="https://icofont.com/icons" target="_blank"><i class="fa fa-eye fa-lg"></i></a>
				</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="url" class=" form-control-label">URL:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
            <input type="text" id="url" name="url" value="<?php if($task=="edit"){echo $reg_url;} ?>" class="form-control">
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
						<input type="hidden" name="id_seccion" value="<?php echo $reg_id; ?>">
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
