<?php
    require_once("../scripts/permiso.php");
    $id_mod_listar = $id_modulo_sist;
  	$id_mod_agregar = cls_sistema::get_id_alias("ADD_DETNEWS");
  	$id_mod_editar = cls_sistema::get_id_alias("EDIT_DETNEWS");
  	$id_mod_estado = cls_sistema::get_id_alias("STA_DETNEWS");
    $id_mod_eliminar = cls_sistema::get_id_alias("DEL_DETNEWS");
    $id_mod_noticia = cls_sistema::get_id_alias("NEWS");
    $mod_estado_url = cls_sistema::get_url_aplicacion($id_mod_estado);
    $mod_eliminar_url = cls_sistema::get_url_aplicacion($id_mod_eliminar);
    $nombre_aplicacion = cls_sistema::get_nombre_aplicacion($id_mod_listar);
    $class_aplicacion = cls_sistema::get_class_aplicacion($id_mod_listar);
?>
<div class="user-data m-b-30" style="width:100%;">
    <h3 class="title-3 m-b-30">
        <i class="<?php echo $class_aplicacion; ?>"></i><?php echo $nombre_aplicacion; ?></h3>
        <hr>
    <div class="filters m-b-45">
        <div class="pull-right" style="margin-bottom:5%;" >
			<?php
        $id_noticia = $_GET["id"];
        echo "<a style='padding-right: 15px;' href='../page/index.php?m=".$id_mod_noticia."&id=".$id_noticia."' class=''><i class='fa fa-arrow-circle-left'></i> ".cls_sistema::get_nombre_aplicacion($id_mod_noticia)."</a>";
        echo "<a href='../page/index.php?m=".$id_mod_agregar."&n=".$id_noticia."' class=''><i class='fa fa-plus-circle'></i> ".cls_sistema::get_nombre_aplicacion($id_mod_agregar)."</a>";
      ?>
		</div>
        <?php
            $query = "SELECT * FROM news_detalle WHERE id_noticia='".$id_noticia."'";
            $rs = $_oControl->consulta($query);
            $total = $_oControl->nroregistros;
            $table = "<div class='table-responsive table-data'>
                            <table class='table'>
                            <thead style ='text-align:center;'>
                                <tr>
                                    <td width='10%'>N&deg;</td>
                                    <td>Nombre</td>
                                    <td>Tipo</td>
                                    <td>Orden</td>
                                    <td width='10%'>Estado</td>
                                    <td width='15%'>Acciones</td>
                                </tr>
                            </thead>
                            <tbody>";
            if($total>0){
                $aux = 1;
                while($datos = $_oControl->obtener_cursor($rs)){
                    $id = $datos["id_detalle"];
                    $id_tipo = $datos["id_tipo"];
                    $nombre = $datos["nombre"];
                    $recurso = $datos["recurso"];
                    $descripcion = $datos["descripcion"];
                    $orden = $datos["orden"];
                    $estado = $datos["estado"];
                    $query = "SELECT * FROM detalle_tipo WHERE id_tipo='".$id_tipo."'";
                    $rs1 = $_oControl->consulta($query);
                    $total = $_oControl->nroregistros;
                    if($total>0){
                      $datos1 = $_oControl->obtener_cursor($rs1);
                      $nombre_tipo = $datos1["nombre"];
                    }
                    $btn_editar = "<a href='../page/index.php?m=".$id_mod_editar."&n=".$id_noticia."&id=".$id."' class='btn btn-info tooltip_exg' title='Editar registro' data-placement='bottom'><i class='fa fa-edit'></i></a>";
                    $btn_delete = "<a href='#' class='btn btn-danger tooltip_exg eliminar_exg' title='Eliminar registro' data-placement='bottom' data-url='".$mod_eliminar_url."' data-params='m=".$id_mod_eliminar."&id=".$id."'><i class='fa fa-trash'></i></a>";
                    $btn_estado = ($estado=="A")?"<a href='#' class='btn btn-success btn-xs tooltip_exg estado_exg' title='Estado Activo' data-placement='bottom' data-url='".$mod_estado_url."' data-params='m=".$id_mod_estado."&id=".$id."&es=I'><i class='fa fa-thumbs-up'></i></a>":"<a href='#' class='btn btn-default btn-xs tooltip_exg estado_exg' title='Estado Inactivo' data-placement='bottom' data-url='".$mod_estado_url."' data-params='m=".$id_mod_estado."&id=".$id."&es=A'><i class='fa fa-thumbs-down'></i></a>";
                    $table .= " <tr>
                                    <td style ='text-align:center;'>".$aux."</td>
                                    <td>".$nombre."</td>
                                    <td style ='text-align:center;'>".$nombre_tipo."</td>
                                    <td style ='text-align:center;'>".$orden."</td>
                                    <td style ='text-align:center;'>".$btn_estado."</td>
                                    <td class='text-center actions'><div class='btn-group btn-group-xs'>".$btn_editar.$btn_delete."</div></td>
                                </tr>";
                    $aux++;
                }
            }
            $table .= "</tbody>
                            </table>
                        </div>
                    </div>";
            echo $table;
        ?>
    </div>
