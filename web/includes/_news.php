<!--Start Page Content-->
<section id="page-content">
    <!--Start Page Heading-->
    <div class="page-heading bg-cover" style="padding: 20px 0 20px 0;">
        <div class="overlay"></div>
        <div class="page-heading-content text-center">
            <h2 class="font-700 text-uppercase color-white">Blog</h2>
            <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <?php
                if(isset($_GET["c"])){
                    $categoria = $_GET["c"];
                    $consulta = "SELECT * FROM categoria WHERE id_categoria='".$categoria."'";
                    $rs = $_oControl->consulta($consulta);
                    $total = $_oControl->nroregistros;
                    if($total > 0){
                      $datos = $_oControl->obtener_cursor($rs);
                      $nombre = $datos["nombre"];
                    }
                    echo "<li><a href='blog.php'>Blog</a></li>";
                    echo "<li><a class='active' href='blog.php?c=".$categoria."'>".$nombre."</a></li>";
                }else{
                  if(isset($_GET["t"])){
                    $tag = $_GET["t"];
                    echo "<li><a href='blog.php'>Blog</a></li>";
                    echo "<li><a class='active' href='blog.php?t=".$tag."'>#".$tag."</a></li>";
                  }else{
                    echo "<li><a class='active' href='blog.php'>Blog</a></li>";
                  }
                }
                ?>
            </ol><br><br>
            <div class="form-group widget category-nav">
              <ul>
                  <?php
                  $consulta = "SELECT * FROM categoria WHERE estado='A'";
                  $rs = $_oControl->consulta($consulta);
                  $total = $_oControl->nroregistros;
                  if($total > 0){
                    while ($datos = $_oControl->obtener_cursor($rs)) { ?>
                      <li><a href="blog.php?c=<?php echo $datos["id_categoria"]; ?>"><?php echo $datos["nombre"]; ?></a></li>
                  <?php
                }}
                  ?>
              </ul>
            </div>
        </div>
    </div>
    <!--End Page Heading-->
    <?php
      if(isset($_GET["p"])){
        $pagina = $_GET["p"];
      }else{ $pagina=1;}
      if(isset($_GET["c"])){
        $c = $_GET["c"];
        $consulta = "SELECT count(id_noticia) as c FROM news WHERE estado='A' AND id_categoria='".$c."'";
      }else{
        if(isset($_GET["t"])){
          $tag_entities = fncCodificar($tag);
          $consulta = "SELECT count(id_noticia) as c FROM news_tag WHERE tag='".$tag."' OR tag='".$tag_entities."'";
        }else{
          $consulta = "SELECT count(id_noticia) as c FROM news WHERE estado='A'";
        }
      }
      $rs = $_oControl->consulta($consulta);
      $total = $_oControl->nroregistros;
      if($total > 0){
        $datos = $_oControl->obtener_cursor($rs);
        $n =$datos["c"];
        $paginas = ceil($n/6);
      }
      $inicio=($pagina-1)*6;
    ?>
    <!--Start Blog Wrap-->
    <div class="blog-wrap">
        <!--Start Container-->
        <div class="container">
            <!--Start Row-->
            <div class="row">
                <!--Start Blog Single-->
                <?php
                if(isset($_GET["c"])){
                  $consulta = "SELECT * FROM news WHERE estado='A' AND id_categoria='".$c."' ORDER BY fecha DESC LIMIT ".$inicio.",6";
                }else{
                  if(isset($_GET["t"])){
                    $consulta = "SELECT DISTINCT * FROM news_tag nt INNER JOIN news n ON nt.id_noticia=n.id_noticia WHERE nt.tag='".$tag."' OR nt.tag='".$tag_entities."' AND n.estado='A' ORDER BY fecha DESC LIMIT ".$inicio.",6";
                  }else{
                    $consulta = "SELECT * FROM news WHERE estado='A' ORDER BY fecha DESC LIMIT ".$inicio.",6";
                  }
                }
                $rs = $_oControl->consulta($consulta);
                $total = $_oControl->nroregistros;
                if($total > 0){
                  while($datos = $_oControl->obtener_cursor($rs)){
                    $id = $datos["id_noticia"];
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
                <div class="col-md-4 col-sm-6">
                    <div class="blog-post-single">
                        <div class="post-media">
                            <a href="blog-single.php?n=<?php echo $id; ?>"><img src="<?php echo $img; ?>" class="img-responsive" alt="Image"></a>
                        </div>
                        <div class="post-content">
                            <div class="post-meta">
                                <h3 class="m-0"><a href="blog-single.php?n=<?php echo $id; ?>"><?php echo $titulo; ?></a></h3>
                                <p><a href="blog.php?c=<?php echo $id_categoria; ?>"><i class="icofont icofont-listine-dots"></i> <?php echo $categoria; ?></a><small>/</small><a href=""><i class="icofont icofont-clock-time"></i> <?php echo fecha_mes3Letras($fecha); ?></a></p>
                            </div>
                            <!--<p><?php //echo $resumen; ?></p>-->
                        </div>
                    </div>
                </div>
                <?php
                  }
                }
                ?>
                <!--End Blog Single-->
            </div>
            <!--End Row-->


            <!--Start Pagination Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="blog-pagination text-center">
                        <ul class="pagination">
                            <?php
                            $href="#";
                            if($pagina<>1){
                              $href="blog.php?p=".($pagina-1);
                              if(isset($_GET["c"])){
                                $href="blog.php?p=".($pagina-1)."&c=".$c;
                              }
                              if(isset($_GET["t"])){
                                $href="blog.php?p=".($pagina-1)."&t=".$tag;
                              }
                            }
                            echo "<li><a href='".$href."'>&laquo;</a></li>";
                            for ($i=1; $i <= $paginas ; $i++) {
                              $active="";
                              if($i==$pagina){$active="active";}
                              if(isset($_GET["c"])){
                                $href="blog.php?p=".$i."&c=".$c;
                              }else{
                                if(isset($_GET["t"])){
                                  $href="blog.php?p=".$i."&t=".$tag;
                                }else{$href="blog.php?p=".$i;}
                              }
                              echo "<li class='".$active."'><a href='".$href."'>".$i."</a></li>";
                            }
                            $href="#";
                            if($pagina<>$paginas){
                              $href="blog.php?p=".($pagina+1);
                              if(isset($_GET["c"])){
                                $href="blog.php?p=".($pagina+1)."&c=".$c;
                              }
                              if(isset($_GET["t"])){
                                $href="blog.php?p=".($pagina+1)."&t=".$tag;
                              }
                            }
                            echo "<li><a href='".$href."'>&raquo;</a></li>";
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!--End Pagination Row-->
        </div>
        <!--End Container-->
    </div>
    <!--End Blog Wrap-->
</section>
<!--End Page Content-->
