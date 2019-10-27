<?php
	require_once("../scripts/permiso.php");
	$id_mod_listar = cls_sistema::get_id_alias("SEC_NOSOTROS");
	$nombre_aplicacion = cls_sistema::get_nombre_aplicacion($id_mod_listar);
	$mod_app_procesar = cls_sistema::get_app_procesar($id_mod_listar);
	$url_listar = "<script language='javascript'>document.location.href='../page/index.php';</script>";

			$id_seccion = 1;
			if(fncVerificarID($id_seccion)==1){
				$title = "Sección Nosotros";
				$_oControl = cls_control::get_instancia();
				$consulta = "SELECT * FROM nosotros WHERE id_seccion='".$id_seccion."'";
				$rs = $_oControl->consulta($consulta);
				$total = $_oControl->nroregistros;
				if($total<>0){
					$datos = $_oControl->obtener_cursor($rs);
          $reg_titulo = $datos["titulo"];
					$reg_subtitulo = $datos["subtitulo"];
					$reg_titulo2 = $datos["titulo2"];
					$reg_mensaje = $datos["mensaje"];
					$reg_detalle1 = $datos["descripcion1"];
					$reg_detalle2 = $datos["descripcion2"];
					$reg_img = $datos["img"];
					$reg_img_src = "../../web/img/nosotros/";
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
							<label for="nombre" class=" form-control-label">Titulo:</label>
							</div>
						</div>
						<div class="col-12 col-md-5">
							<input type="text" id="nombre" name="titulo" value="<?php echo $reg_titulo; ?>" class="form-control">
						</div>
				</div>
					<div class="row form-group">
						<div class="col col-md-3 col-md-offset-1">
							<div class="pull-right">
							<label for="titulo" class=" form-control-label">Sub Titulo:</label>
							</div>
						</div>
						<div class="col-12 col-md-5">
							<input type="text" id="titulo" name="subtitulo" value="<?php echo $reg_subtitulo; ?>" class="form-control">
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3 col-md-offset-1">
							<div class="pull-right">
							<label for="nombre" class=" form-control-label">Titulo 2:</label>
							</div>
						</div>
						<div class="col-12 col-md-5">
							<input type="text" id="nombre" name="titulo2" value="<?php echo $reg_titulo2; ?>" class="form-control">
						</div>
				</div>
					<div class="row form-group">
						<div class="col col-md-3 col-md-offset-1">
							<div class="pull-right">
							<label for="detalle1" class=" form-control-label">Detalle superior:</label>
							</div>
						</div>
						<div class="col-12 col-md-5">
						<textarea id="inputcleditor" name="detalle1" class="cleditor col-md-12 form-control" rows="12"><?php echo $reg_detalle1; ?></textarea>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3 col-md-offset-1">
							<div class="pull-right">
							<label for="mensaje" class=" form-control-label">Mensaje:</label>
							</div>
						</div>
						<div class="col-12 col-md-5">
						<textarea id="inputcleditor" name="mensaje" class="cleditor col-md-12 form-control" rows="12"><?php echo $reg_mensaje; ?></textarea>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3 col-md-offset-1">
							<div class="pull-right">
							<label for="detalle" class=" form-control-label">Detalle inferior:</label>
							</div>
						</div>
						<div class="col-12 col-md-5">
						<textarea id="inputcleditor" name="detalle2" class="cleditor col-md-12 form-control" rows="12"><?php echo $reg_detalle2; ?></textarea>
						</div>
					</div>
							<input type="hidden" name="img_antes" value="<?php echo $reg_img; ?>" />
							<input type="hidden" name="id_seccion" value="<?php echo $id_seccion; ?>">
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
								<button type="button" class="btn btn-danger btn-sm" onClick="location.href='../page/index.php'">
									<i class="fa fa-ban"></i> Cancelar
								</button>
							</div>
						</div>
				</div>
			</div>
		</div>
	</form>
</div>


