
        <!--Start Latest News Area-->
        <section id="news-area">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 text-uppercase">Noticias</h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. </p>
                        </div>
                    </div>
                </div>
                <!--Start Heading Row-->
                <!--Start Blog Post Row-->
                <div class="row">
                <?php
                  $consulta = "SELECT * FROM news WHERE estado='A' ORDER BY fecha DESC LIMIT 3";
                  $rs = $_oControl->consulta($consulta);
                  $total = $_oControl->nroregistros;
                  if($total > 0){
                    while ($datos = $_oControl->obtener_cursor($rs)) {
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
                    <!--Start Blog Single-->
                    <div class="col-md-4">
                        <div class="blog-post-single">
                            <div class="post-media">
                                <a href="blog-single.php?n=<?php echo $id; ?>"><img src="<?php echo $img; ?>" class="img-responsive" alt="Image"></a>
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <h3 class="m-0"><a href="blog-single.php?n=<?php echo $id; ?>"><?php echo $titulo; ?></a></h3>
                                    <p><a href=""><i class="icofont icofont-listine-dots"></i> <?php echo $categoria; ?></a><small>/</small><a href=""><i class="icofont icofont-clock-time"></i> <?php echo fecha_mes3Letras($fecha); ?></a></p>
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <!--End Blog Single-->
                <?php }} ?>
                </div>
                <!--End Blog Post Row-->
                <div class="more-blog-btn text-center">
                    <a href="blog.php">Blog</a>
                </div>
            </div>
            <!--End Container-->
        </section>
        <!--End Latest News Area-->
