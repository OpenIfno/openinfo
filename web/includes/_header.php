    <!--Start Preloader-->
    <div class="site-preloader">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    <!--End Preloader-->
    <!--Start Body Wrap-->
    <div id="body-wrap">
        <!--Start Header-->
        <header id="header">
            <!--Start Header Top-->
            <div class="header-top">
                <!--Start Container-->
                <div class="container">
                    <!--Start Row-->
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="header-contact-info">
                                <ul>
                                    <li><i class="icofont icofont-email"></i><?php echo $page_email; ?></li>
                                    <li><i class="icofont icofont-phone"></i><?php echo $page_fono; ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="header-social text-right">
                                <ul>
                                    <li><span>S&iacute;guenos :</span></li>
                                    <?php
                                        $consulta_redsocial = "SELECT smm.id_smm,smmt.id_smmtipo,smm.url,smm.orden,smm.estado,
                                        smmt.nombre,smmt.clase FROM smm smm JOIN smm_tipo smmt 
                                        ON smm.id_smmtipo=smmt.id_smmtipo WHERE smm.estado='A' ORDER BY smm.orden ASC";
                                        $rs_redsocial = $_oControl->consulta($consulta_redsocial);
                                        $total = $_oControl->nroregistros;
                                          if($total > 0){
                                            while($datos = $_oControl->obtener_cursor($rs_redsocial)){ ?>
                                                <li><a href="<?php echo $datos["url"]; ?>"><i class="<?php echo $datos["clase"]; ?>"></i></a></li>
                                            <?php }} ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Row-->
                </div>
                <!--End Container-->
            </div>
            <!--End Header Top-->
