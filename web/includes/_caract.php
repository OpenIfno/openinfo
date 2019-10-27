        <!--Start Mission Area-->
        <section id="mission-area" class="bg-gray">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 text-uppercase">Our Mission & Vission</h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. </p>
                        </div>
                    </div>
                </div>
                <!--Start Heading Row-->

                <!--Start Row-->
                <div class="row">
                  <?php
                      $consulta = "SELECT * FROM features WHERE estado='A'";
                      $rs = $_oControl->consulta($consulta);
                      $total = $_oControl->nroregistros;
                        if($total > 0){
                          while($datos = $_oControl->obtener_cursor($rs)){
                            $titulo = $datos["titulo"];
                            $descrip = fncTraducirEntidadHTML($datos["descripcion"]);
                            $icono = $datos["icon"];
                            ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="mission-single text-center">
                                    <i class="icofont <?php echo $icono; ?> color-main"></i>
                                    <h5 class="font-600"><?php echo $titulo; ?></h5>
                                    <p><?php echo $descrip; ?></p>
                                </div>
                            </div>
                          <?php
                          }} ?>
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Mission Area-->
