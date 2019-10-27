
        <!--Start Gallery Area-->
        <section id="gallery-area">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 text-uppercase">Galer&iacute;a</h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. </p>
                        </div>
                    </div>
                </div>
                <!--Start Heading Row-->

                <!--Start Gallery Menu-->
                <div class="gallery-menu row">
                    <div class="col-md-12">
                        <div class="button-group filter-button-group text-center">
                            <button class="active" data-filter="*">Todo</button>
                            <?php
                              $consulta = "SELECT * FROM gallery_tipo WHERE estado='A'";
                              $rs = $_oControl->consulta($consulta);
                              $total = $_oControl->nroregistros;
                              if($total > 0){
                                while ($datos = $_oControl->obtener_cursor($rs)) {
                                  $nombre = $datos["nombre"];
                                  $filtro = $datos["filter"];
                                  echo "<button data-filter='.".$filtro."'>".$nombre."</button>";
                                }
                              }
                            ?>
                        </div>
                    </div>
                </div>
                <!--End Gallery Menu-->

                <!--Start Gallery List-->
                <div class="gallery-list row">
                  <?php
                    $consulta = "SELECT * FROM gallery WHERE estado='A' ORDER BY fchreg LIMIT 6";
                    $rs = $_oControl->consulta($consulta);
                    $total = $_oControl->nroregistros;
                    if($total > 0){
                      while ($datos = $_oControl->obtener_cursor($rs)) {
                        $id_tipo = $datos["id_tipo"];
                        $img = "img/galeria/".$datos["thumb"];
                        $thumb = "img/galeria/".$datos["thumb"];
                        $consulta = "SELECT * FROM gallery_tipo WHERE id_tipo='".$id_tipo."'";
                        $rs1 = $_oControl->consulta($consulta);
                        $total = $_oControl->nroregistros;
                        if($total > 0){
                          $datos1 = $_oControl->obtener_cursor($rs1);
                          $filtro = $datos1["filter"];
                        }

                  ?>
                    <!--Start Gallery Single-->
                    <div class="col-md-4 col-sm-6 gallery-grid <?php echo $filtro; ?>">
                        <div class="gallery-single fix">
                            <img src="<?php echo $thumb; ?>" class="img-responsive" alt="Image">
                            <div class="gallery-overlay">
                                <div class="display-table">
                                    <div class="table-cell">
                                        <a class="popup-img" href="<?php echo $img; ?>"><i class="icofont icofont-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Gallery Single-->
                  <?php
                      }
                    }
                  ?>
                </div>
                <!--End Gallery List-->
            </div>
            <!--End Container-->
        </section>
        <!--End Gallery Area-->
