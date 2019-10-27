
        <!--Start Team Area-->
        <section id="team-area" class="bg-gray">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 text-uppercase">Our Team Members</h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. </p>
                        </div>
                    </div>
                </div>
                <!--Start Heading Row-->

                <!--Start Row-->
                <div class="row">
                <?php
                  $consulta = "SELECT * FROM team WHERE estado='A'";
                  $rs = $_oControl->consulta($consulta);
                  $total = $_oControl->nroregistros;
                  if($total > 0){
                    while($datos = $_oControl->obtener_cursor($rs)){
                          $id = $datos["id_persona"];
                          $origen = "img/team/";
                          $nombre = $datos["nombres"]." ".$datos["apellidos"];
                          $especialidad = $datos["especialidad"];
                          $img = $origen.$datos["img"];
                ?>
                    <!--Start Team Single-->
                    <div class="col-md-3 col-sm-6">
                        <div class="team-single fix">
                            <img src="<?php echo $img; ?>" class="img-responsive" alt="Image">
                            <div class="team-member-info text-center">
                                <h4 class="font-600 color-main m-0"><?php echo $nombre; ?></h4>
                                <p><?php echo $especialidad; ?></p>
                            </div>
                            <?php
                              $consulta = "SELECT * FROM team_smm WHERE estado='A' AND id_persona='".$id."'";
                              $rs_smm = $_oControl->consulta($consulta);
                              $total = $_oControl->nroregistros;
                              if($total > 0){
                            ?>
                            <div class="team-social text-center">
                                <ul>
                                  <?php
                                  while($datos_smm = $_oControl->obtener_cursor($rs_smm)){
                                        $icono = trim($datos_smm["icono"]);
                                        $nombre = $datos_smm["nombre"];
                                        $url = $datos_smm["url"];
                                  ?>
                                    <li><a href="<?php echo $url; ?>" target="_blank" title="<?php echo $nombre; ?>"><i class="<?php echo $icono; ?>"></i></a></li>
                                  <?php } ?>
                                </ul>
                            </div> <?php } ?>
                        </div>
                    </div>
                    <!--End Team Single-->
                    <?php
                        }
                      }
                     ?>
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Team Area-->
