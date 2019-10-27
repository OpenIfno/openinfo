<?php
    $consulta = "SELECT * FROM nosotros WHERE estado='A' AND id_seccion='1'";
    $rs = $_oControl->consulta($consulta);
    $total = $_oControl->nroregistros;
      if($total > 0){
        while($datos = $_oControl->obtener_cursor($rs)){
            $img = "img/nosotros/".$datos["img"];
            $titulo = $datos["titulo"];
            $subtitulo = $datos["subtitulo"];
            $titulo2 = $datos["titulo2"];
            $descrip1 = $datos["descripcion1"];
            $mensaje = $datos["mensaje"];
            $descrip2 = $datos["descripcion2"];
        }}
?>
        <!--Start About Area-->
        <section id="about-area">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 text-uppercase"><?php echo $titulo; ?></h2>
                            <?php 
                            if($subtitulo<>""){
                                echo "<p>".$subtitulo."</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!--Start Heading Row-->

                <!--Start Row-->
                <div class="row">
                    <!--Start About Image-->
                    <div class="col-md-6">
                        <div class="about-img">
                            <img src="<?php echo $img; ?>" class="img-responsive" alt="Image">
                        </div>
                    </div>
                    <!--End About Image-->

                    <!--Start About Content-->
                    <div class="col-md-6">
                        <div class="about-content">
                            <?php 
                            if($titulo2<>""){
                                echo "<h3 class='font-700 color-main'>".$titulo2."</h3>";
                            }
                            if($descrip1<>""){
                                echo "<p>".$descrip1."</p>";
                            }
                            if($mensaje<>""){
                                echo "<blockquote>".$mensaje."</blockquote>";
                            }
                            if($descrip2<>""){
                                echo "<p>".$descrip2."</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <!--End About Content-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End About Area-->
