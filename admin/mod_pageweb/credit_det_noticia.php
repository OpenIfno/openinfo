<?php
	require_once("../scripts/permiso.php");
	$id_mod_listar = cls_sistema::get_id_alias("DET_NEWS");
	$id_mod_agregar = cls_sistema::get_id_alias("ADD_DETNEWS");
	$id_mod_editar = cls_sistema::get_id_alias("EDIT_DETNEWS");
	$nombre_aplicacion = cls_sistema::get_nombre_aplicacion($id_mod_agregar);
	$mod_app_procesar = cls_sistema::get_app_procesar($id_mod_agregar);
	switch($id_modulo_sist){
		case $id_mod_agregar: $task="new"; break; //------> AGREGAR registro
		case $id_mod_editar: $task="edit"; break; //------> EDITAR registro
		default: $task=""; break;
	}
	$url_listar = "<script language='javascript'>document.location.href='../page/index.php?m=".$id_mod_listar."';</script>";
	if(trim($task)=="new" || trim($task)=="edit"){
		$id_noticia = fncSeguridad($_GET["n"]);
		$query = "SELECT max(orden) as ultimo FROM news_detalle WHERE id_noticia='".$id_noticia."'";
		$rs = $_oControl->consulta($query);
		$total = $_oControl->nroregistros;
		if($total>0){
				$datos = $_oControl->obtener_cursor($rs);
				$reg_orden = $datos["ultimo"]+1;
				if($reg_orden==""){$reg_orden=1;}
		}
		if(trim($task)=="new"){
			$title = "Agregar Detalle Noticia";
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
			$id_detalle = fncSeguridad($_GET["id"]);
			if(fncVerificarID($id_detalle)==1){
				$title = "Editar Detalle Noticia";
				$_oControl = cls_control::get_instancia();
				$consulta = "SELECT * FROM news_detalle WHERE id_detalle='".$id_detalle."'";
				$rs = $_oControl->consulta($consulta);
				$total = $_oControl->nroregistros;
				if($total<>0){
					$datos = $_oControl->obtener_cursor($rs);
          $reg_tipo = $datos["id_tipo"];
          $reg_img = $reg_recurso = fncTraducirEntidadHTML($datos["recurso"]);
					$reg_thumb = "thumb_".$reg_img;
					$reg_descripcion = fncTraducirEntidadHTML($datos["descripcion"]);
					$reg_nombre = $datos["nombre"];
					$reg_orden = $datos["orden"];
					$reg_img_src = "../../web/img/noticia/";

					$reg_est = $datos["estado"];
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
						if($reg_tipo==1){ //Imagen
							if(trim($reg_img)<>"" && file_exists($reg_img_src.$reg_thumb)){
		    				list($anch,$alt) = getimagesize($reg_img_src.$reg_thumb);
		    				list($ancho,$alto) = getimagesize($reg_img_src.$reg_thumb);
								if($ancho>200){$ancho = 200;}?>
	              <div align="center" style="padding:0 0 30px 0;">
	                <table border="0" cellpadding="15" cellspacing="15">
	                  <tr>
	                    <td><img src="<?php echo $reg_img_src.$reg_thumb;?>" width="<?php echo $ancho;?>" border='0' /></td>
	                    <td>
	                      <div align='left' style="line-height:17px; padding-left:10px;">
	                        <strong>Nombre de la Imagen: </strong> <?php echo $reg_img;?><br />
	                        <strong>Dimensiones de la Imagen: </strong> <?php echo $anch." x ".$alt." pixeles";?><br />
	                        <strong>Peso de la Imagen: </strong> <?php echo round((filesize($reg_img_src.$reg_img)/1024),3)." Kb";?>
	                      </div>
	                    </td>
	                  </tr>
	                </table>
	              </div>
					<?php
    					}
						}elseif($reg_tipo==2){ //Audio
							$ruta_audio = "../../web/audio/noticia/";
							?>
							<div class="row form-group">
							<div align="center" class="col-sm-12" style="padding-bottom:30px;">
								<audio src="<?php echo $ruta_audio.$reg_recurso; ?>" preload="auto" controls>
									<p>Tu navegador no es compatible con el elemento de Audio</p>
								</audio>
							</div>
							</div>
					<?php
				}elseif($reg_tipo==3){ //Video
					$video = substr(fncTraducirEntidadHTML(fncTraducirEntidadHTML($reg_recurso)),9,-4);
					$video = substr($video,0,strlen($video)/2-1);
					$var = explode("?v=", $video);
					?>
						<div class="row form-group">
						<div align="center" class="col-sm-12">
							<iframe width="420" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $var[1]; ?>">
							</iframe>
						</div>
						</div>
					<?php
					}
    		}
    	?>
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
            <label for="tipo" class=" form-control-label">Tipo:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
						<select name="tipo" id="tipo" class="form-control-lg form-control" style="height:34px;">
								<?php
									$query = "SELECT * FROM detalle_tipo";
									$rs = $_oControl->consulta($query);
									$total = $_oControl->nroregistros;
									if($total>0){
										while($datos = $_oControl->obtener_cursor($rs)){
											$selected="";
											if ($reg_tipo==$datos["id_tipo"]) {$selected="selected";}
											echo "<option value='".$datos["id_tipo"]."'".$selected.">".$datos["nombre"]."</option>";
										}
									}
								?>
						</select>
          </div>
				</div>
				<div class="row form-group">
	          <div class="col col-md-3 col-md-offset-1">
							<div class="pull-right">
		            <label for="recurso" class=" form-control-label">Recurso:</label>
							</div>
						</div>
          	<div class="col-12 col-md-5" id="imgaud">
							<div class="fileupload fileupload-new margin-none" data-provides="fileupload">
		    				<div class="input-group">
		    					<div class="form-control col-md-3"><i class="fa fa-file fileupload-exists"></i>
		    						<span class="fileupload-preview"></span>
		    					</div>
		    					<span class="input-group-btn">
		    						<span class="btn btn-default btn-file">
		    							<span class="fileupload-new">Seleccione el archivo</span>
		    							<span class="fileupload-exists">Cambiar</span>
		    							<input type="file" class="margin-none" name="imagen" id="fileinput01"  onchange="validarRecurso(this.value);" />
		    						</span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Quitar</a>
		    					</span>
		    				</div>
		    			</div>
						</div>
						<div class="col-12 col-md-5" id="recurso">
			      	<textarea type="text" id="inputcleditor2" name="recurso" class="cleditor2 col-md-12 form-control"><?php if($task=="edit"){echo $reg_recurso;} ?></textarea>
						</div>
				</div>
				<div class="row form-group">
          <div class="col col-md-3 col-md-offset-1">
						<div class="pull-right">
            <label for="descripcion" class=" form-control-label">Descripción:</label>
						</div>
					</div>
          <div class="col-12 col-md-5">
						<textarea id="inputcleditor" name="descripcion" class="cleditor col-md-12 form-control" rows="12"><?php if($task=="edit"){echo $reg_descripcion;} ?></textarea>
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
						<input type="hidden" name="img_thumb_antes" value="<?php echo $reg_thumb;?>" />
						<input type="hidden" name="id_noticia" value="<?php echo $id_noticia; ?>">
						<input type="hidden" name="id_detalle" value="<?php echo $id_detalle; ?>">
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
