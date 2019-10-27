<!--Start Blog Sidebar-->
<div class="col-sm-4">
    <div class="blog-sidebar">
        <!--Start Search Widget-->
        <div class="widget search">
            <h4 class="font-600 color-main">Search</h4>
            <input type="text" class="form-control" placeholder="Search">
            <span><i class="icofont icofont-search"></i></span>
        </div>
        <!--End Search Widget-->

        <!--Start Category Widget-->
        <div class="widget category">
            <h4 class="font-600 color-main">Categor&iacute;as</h4>
            <ul>
              <?php
                $consulta = "SELECT * FROM categoria WHERE estado='A'";
                $rs = $_oControl->consulta($consulta);
                $total = $_oControl->nroregistros;
                if($total > 0){
                  while ($datos = $_oControl->obtener_cursor($rs)) {
                    $consulta = "SELECT count(id_noticia) as cantidad FROM news WHERE estado='A' AND id_categoria='".$datos["id_categoria"]."'";
                    $rs1 = $_oControl->consulta($consulta);
                    $total = $_oControl->nroregistros;
                    if($total > 0){
                      $datos1 = $_oControl->obtener_cursor($rs1);
                      $cantidad = $datos1["cantidad"];
                    }
              ?>
                    <li><a href="blog.php?c=<?php echo $datos["id_categoria"]; ?>"><i class="icofont icofont-rounded-double-right"></i> <?php echo $datos["nombre"]; ?> <span class="float-right">(<?php echo $cantidad; ?>)</span></a></li>
              <?php
            }}
              ?>
            </ul>
        </div>
        <!--End Category Widget-->

        <!--Start Recent Post Widget-->
        <div class="widget recent-post">
            <h4 class="font-600 color-main">Noticias Recientes</h4>
            <?php
              $consulta = "SELECT id_categoria FROM news WHERE id_noticia='".$_GET["n"]."'";
              $rs = $_oControl->consulta($consulta);
              $total = $_oControl->nroregistros;
              if($total > 0){
                $datos = $_oControl->obtener_cursor($rs);
                $id_categoria = $datos["id_categoria"];
              }
              $consulta = "SELECT * FROM news WHERE id_categoria='".$id_categoria."' ORDER BY fecha DESC LIMIT 3";
              $rs = $_oControl->consulta($consulta);
              $total = $_oControl->nroregistros;
              if($total > 0){
                while($datos = $_oControl->obtener_cursor($rs)){
                  $Key = "OpenInfo2019";
                  //$id_noticia =  password_hash($datos["id_noticia"],PASSWORD_BCRYPT);
                  $id_noticia =  $datos["id_noticia"];
                  $titulo = $datos["titulo"];
                  $resumen = $datos["resumen"];
                  $fecha = $datos["fecha"];
                  $img = "img/noticia/".$datos["thumb"];
                  $id_categoria = $datos["id_categoria"];
                  $consulta = "SELECT nombre FROM categoria WHERE estado='A' AND id_categoria='".$id_categoria."'";
                  $rs1 = $_oControl->consulta($consulta);
                  $total = $_oControl->nroregistros;
                  if($total > 0){
                    $datos1 = $_oControl->obtener_cursor($rs1);
                    $categoria = $datos1["nombre"];
                  }
            ?>
            <!--Start Recent Post Single-->
            <div class="recent-post-single row">
                <div class="col-md-5">
                    <div class="recent-post-img">
                        <img src="<?php echo $img; ?>" class="img-responsive" alt="Image">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="recent-post-cont">
                        <h5 class="m-0"><a class="font-500" href="blog-single.php?n=<?php echo $id_noticia; ?>"><?php echo $titulo; ?></a></h5>
                        <p class="m-0 color-main"><span><?php echo fecha_mes3Letras($fecha); ?></span></p>
                        <p></p><br/>
                    </div>
                </div>
            </div>
            <!--End Recent Post Single-->
            <?php }} ?>
        </div>
        <!--End Recent Post Widget-->

        <!--Start Tag Widget-->
        <div class="widget tags">
            <h4 class="font-600 color-main">Tags</h4>
            <ul>
                <?php
                $consulta = "SELECT * FROM news_tag WHERE id_noticia='".$_GET["n"]."'";
                $rs = $_oControl->consulta($consulta);
                $total = $_oControl->nroregistros;
                if($total > 0){
                  while($datos = $_oControl->obtener_cursor($rs)){
                  echo "<li><a href='blog.php?t=".$datos["tag"]."'>".$datos["tag"]."</a></li>";
                  }
                }
                ?>
            </ul>
        </div>
        <!--End Tag Widget-->
    </div>
</div>
<!--End Blog Sidebar-->
