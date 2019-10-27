            <!--Start Main Menu-->
            <div class="main-menu">
                <nav class="navbar navbar-default bootsnav" data-spy="affix" data-offset-top="10">
                    <!--Start Container-->
                    <div class="container">
                        <!-- Start Header Navigation -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="icofont icofont-navigation-menu"></i>
                        </button>
                            <a class="navbar-brand" href="index.php"><img src="assets\images\logo-vertical.png" class="logo" alt=""></a>
                        </div>
                        <!-- End Header Navigation -->

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-menu">
                            <ul class="nav navbar-nav navbar-right" data-in="fadeIn" data-out="fadeOut">
                                <?php
                                $consulta_nav = "SELECT * FROM aplicacion WHERE id_padre='0' AND web_menu='si' ORDER BY orden ASC";
                                $rs_nav = $_oControl->consulta($consulta_nav);
                                $total = $_oControl->nroregistros;
                                $barra="";
                                if($total > 0){
                                    while($datos = $_oControl->obtener_cursor($rs_nav)){
                                        $active = "";
                                        if($datos["alias"]== "INICIO"){ $active = "active"; }
                                        $barra .= "<li class='".$active."'><a href='index.php".$datos["url"]."'>".strtoupper($datos["nombre"])."</a></li>";
                                    }}
                                echo $barra;
                                ?>
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                    <!--End Container-->
                </nav>
                <div class="clearfix"></div>
            </div>
            <!--End Main Menu-->
        </header>
        <!--End Header-->
