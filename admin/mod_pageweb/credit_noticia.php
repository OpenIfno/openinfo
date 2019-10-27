<?php
	require_once("../scripts/permiso.php");
	$id_mod_listar = cls_sistema::get_id_alias("NEWS");
	$id_mod_agregar = cls_sistema::get_id_alias("ADD_NEWS");
	$id_mod_editar = cls_sistema::get_id_alias("EDIT_NEWS");
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
			$title = "Agregar Noticia";
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
			$id_noticia = fncSeguridad($_GET["id"]);
			if(fncVerificarID($id_noticia)==1){
				$title = "Editar Noticia";
				$_oControl = cls_control::get_instancia();
				$consulta = "SELECT * FROM news WHERE id_noticia='".$id_noticia."'";
				$rs = $_oControl->consulta($consulta);
				$total = $_oControl->nroregistros;
				if($total<>0){
					$datos = $_oControl->obtener_cursor($rs);
          $reg_titulo = $datos["titulo"];
          $reg_subtitulo = $datos["subtitulo"];
					$reg_resumen = fncTraducirEntidadHTML($datos["resumen"]);
					$reg_fecha = $datos["fecha"];
					$reg_categoria = $datos["id_categoria"];
					$reg_img = $datos["img"];
					$reg_thumb = $datos["thumb"];
					$reg_prioridad = $datos["prioridad"];
					$reg_est = $datos["estado"];
					$reg_img_src = "../../web/img/noticia/";
					$consulta = "SELECT * FROM news_tag WHERE id_noticia='".$id_noticia."'";
					$rs = $_oControl->consulta($consulta);
					$total = $_oControl->nroregistros;
					if($total<>0){
						$datos = $_oControl->obtener_cursor($rs);
						$reg_tags = $datos["tag"];
						while ($datos = $_oControl->obtener_cursor($rs)) {
							$reg_tags .= ",".$datos["tag"];
						}
					}
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
										<strong>Nombre de la Imagen: </strong> <?php echo $reg_img; ?><br/>
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
            <label for="subtitulo" class=" form-control-label">Subtitulo:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
            <input type="text" id="subtitulo" name="subtitulo" value="<?php if($task=="edit"){echo $reg_subtitulo;} ?>" class="form-control">
          </div>
				</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="titulo" class=" form-control-label">Fecha:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
            <input type="text" id="fecha" name="fecha" value="<?php if($task=="edit"){echo  date("d-m-Y", strtotime($reg_fecha));}else{echo date("d-m-Y");} ?>" class="form-control datepicker" required>
          </div>
				</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="resumen" class=" form-control-label">Resumen:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
						<textarea id="inputcleditor" name="resumen" class="cleditor col-md-12 form-control" rows="12"><?php if($task=="edit"){echo $reg_resumen;} ?></textarea>
          </div>
				</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="categoria" class=" form-control-label">Categoria:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
						<select name="categoria" id="categoria" class="form-control-lg form-control" style="height:34px;">
								<?php
									$query = "SELECT * FROM categoria";
									$rs = $_oControl->consulta($query);
									$total = $_oControl->nroregistros;
									if($total>0){
										while($datos = $_oControl->obtener_cursor($rs)){
											$selected="";
											if ($reg_categoria==$datos["id_categoria"]) {$selected="selected";}
											echo "<option value='".$datos["id_categoria"]."'".$selected.">".$datos["nombre"]."</option>";
										}
									}
								?>
						</select>
          </div>
				</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="prioridad" class=" form-control-label">Prioridad:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
						<select name="prioridad" id="prioridad" class="form-control-lg form-control" style="height:34px;">
								<option value="1"<?php if($task=="edit"){if($reg_prioridad==1){echo "selected";}} ?>>Muy alta</option>
								<option value="2"<?php if($task=="edit"){if($reg_prioridad==2){echo "selected";}} ?>>Alta</option>
								<option value="3"<?php if($task=="edit"){if($reg_prioridad==3){echo "selected";}} ?>>Media</option>
								<option value="4"<?php if($task=="edit"){if($reg_prioridad==4){echo "selected";}} ?>>Baja</option>
								<option value="5"<?php if($task=="edit"){if($reg_prioridad==5){echo "selected";}} ?>>Muy baja</option>
						</select>
          </div>
				</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="prioridad" class=" form-control-label">Tags:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
						<input type="text" name="tags" data-role="tagsinput" value="<?php if($task=="edit"){echo $reg_tags;} ?>">
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
						<input type="hidden" name="img_thumb_antes" value="<?php echo $reg_thumb;?>" />
						<input type="hidden" name="id_noticia" value="<?php echo $id_noticia; ?>">
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
