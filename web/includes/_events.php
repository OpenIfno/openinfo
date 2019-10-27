
        <!--Start Event Area-->
        <section id="event-area">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 text-uppercase">Upcoming Events</h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. </p>
                        </div>
                    </div>
                </div>
                <!--Start Heading Row-->
                <!--Start Row-->
                <div class="row">
                <?php
                $consulta = "SELECT * FROM event WHERE estado='A'";
                $rs = $_oControl->consulta($consulta);
                $total = $_oControl->nroregistros;
                if($total > 0){
                  while($datos = $_oControl->obtener_cursor($rs)){
                        $img = "img/event/".$datos["thumb"];
                        $titulo = $datos["titulo"];
                        $fechaI = $datos["fecha_inicio"];
                        $fechaF = $datos["fecha_final"];
                        $Emanana = $datos["Emanana"];
                        $Smanana = $datos["Smanana"];
                        $Etarde = $datos["Etarde"];
                        $Starde = $datos["Starde"];
                        if ($fechaI==$fechaF) {
                          $fecha = fecha_mes3Letras($fechaI);
                        }
                        if ($Smanana=="") {
                          $horario = $Emanana." a.m. - ".$Starde." p.m.";
                        }else{
                          if (substr($Smanana, 0, 2)=="12") {$Smanana .= " p.m.";}else{$Smanana .= " a.m.";}
                          $horario = $Emanana." a.m. - ".$Smanana." y ".$Etarde." p.m. - ".$Starde." p.m.";
                        }
                        $direccion = $datos["direccion"];
                ?>
                    <!--Start Event Single-->
                    <div class="col-sm-4">
                        <div class="event-single">
                            <img src="<?php echo $img; ?>" class="img-responsive" alt="Image">
                            <div class="event-content">
                                <h4 class="font-600 m-0"><a href=""><?php echo $titulo; ?></a></h4>
                                <h6 class="m-0"><span><i class="icofont icofont-calendar"></i> <?php echo $fecha; ?></span><br><span><i class="icofont icofont-clock-time"></i> <?php echo $horario; ?></span></h6>
                                <p><i class="icofont icofont-social-google-map"></i><?php echo $direccion; ?></p>
                            </div>
                        </div>
                    </div>
                    <!--End Event Single-->
                <?php
                  }
                }
                ?>
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Event Area-->
