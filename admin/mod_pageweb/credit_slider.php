<?php
	require_once("../scripts/permiso.php");
	$id_mod_listar = cls_sistema::get_id_alias("SLIDER");
	$id_mod_agregar = cls_sistema::get_id_alias("ADD_SLIDER");
	$id_mod_editar = cls_sistema::get_id_alias("EDIT_SLIDER");
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
			$title = "Agregar Slider";
			$reg_fch = date("d-m-Y");
      $query_ord = "SELECT MAX(orden) as orden FROM slider";
      $rs_ord = $_oControl->consulta($query_ord);
      $total_ord = $_oControl->nroregistros;
      if($total_ord>0){
        $datos_ord = $_oControl->obtener_cursor($rs_ord);
        $reg_orden = $datos_ord["orden"]+1;
      }else{
        $reg_orden = 1;
      }
		}elseif(trim($task)=="edit"){
			$id_slider = fncSeguridad($_GET["id"]);
			if(fncVerificarID($id_slider)==1){
				$title = "Editar Slider";
				$_oControl = cls_control::get_instancia();
				$consulta = "SELECT * FROM slider WHERE id_slider='".$id_slider."'";
				$rs = $_oControl->consulta($consulta);
				$total = $_oControl->nroregistros;
				if($total<>0){
					$datos = $_oControl->obtener_cursor($rs);
					$reg_nombre = $datos["nombre"];
          $reg_titulo = $datos["titulo"];
          $reg_orden = $datos["orden"];
					$reg_detalle = fncTraducirEntidadHTML($datos["descrip"]);
					$reg_img = $datos["img"];
					//$reg_thumb = $datos["thumb"];
					$reg_est = $datos["estado"];
					$reg_img_src = "../../web/img/slider/";
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
			<?php
    		if($task=="edit"){
    			if(trim($reg_img)<>"" && file_exists($reg_img_src.$reg_img)){
    				list($anch,$alt) = getimagesize($reg_img_src.$reg_img);
    				list($ancho,$alto) = getimagesize($reg_img_src.$reg_img);
						if($ancho>200){ $ancho=200; }
					?>
					<div align="center" style="padding:0 0 30px 0;">
						<table border="0" cellpadding="15" cellspacing="15">
							<tr>
								<td><img src="<?php echo $reg_img_src.$reg_img; ?>" width="<?php echo $ancho;?>" border='0' /></td>
								<td>
									<div align='left' style="line-height:17px; padding-left:10px;">
										<strong>Nombre de la Imagen: </strong> <?php echo $reg_img; ?><br />
										<strong>Dimensiones de la Imagen: </strong> <?php echo $anch." x ".$alt." pixeles"; ?><br />
										<strong>Peso de la Imagen: </strong> <?php echo round((filesize($reg_img_src.$reg_img)/1024),3)." Kb"; ?>
                    <div style="display:block; padding-top:5px;">
                      <input type="checkbox" name="eliminar" id="imagen_delete" class="exg_delete_img" onclick="mensajeOnclickCheck(this,'Indica que eliminara la imagen')"><label for="imagen_delete" class="exg_delete_img" title="Eliminar Imagen">Eliminar Imagen</label>
                    </div>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<?php
    			}
    		}
    	?>
			<div class="row form-group">
				<div class="col col-md-3 col-md-offset-1">
					<div class="pull-right">
						<label for="fileinput01" class="control-label">Imagen:</label>
					</div>
				</div>
    		<div class="col-12 col-md-5">
    			<div class="fileupload fileupload-new margin-none" data-provides="fileupload">
    				<div class="input-group">
    					<div class="form-control col-md-12"><i class="fa fa-file fileupload-exists"></i>
    						<span class="fileupload-preview"></span>
    					</div>
    					<span class="input-group-btn">
    						<span class="btn btn-default btn-file">
    							<span class="fileupload-new">Seleccione el archivo</span>
    							<span class="fileupload-exists">Cambiar</span>
    							<input type="file" class="margin-none" name="imagen" id="fileinput01" onchange="validarImagen(this.value);" />
    					</span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Quitar</a>
    					</span>
    					</div>
    				</div>
    			</div>
				</div>
			</div>	
			<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="nombre" class=" form-control-label">Nombre:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
            <input type="text" id="nombre" name="nombre" value="<?php if($task=="edit"){echo $reg_nombre;} ?>" class="form-control">
          </div>
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
            <label for="orden" class=" form-control-label">Orden:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
            <input type="text" id="orden" name="orden" value="<?php echo $reg_orden; ?>" class="form-control">
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
						<input type="hidden" name="img_antes" value="<?php echo $reg_img; ?>" />
						<input type="hidden" name="id_slider" value="<?php echo $id_slider; ?>">
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






