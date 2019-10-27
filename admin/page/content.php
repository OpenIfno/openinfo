<!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        if($id_modulo_sist==0){
                            $contenido = "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";  
                            echo $contenido;
                        }else{
                            $query = "SELECT * FROM aplicacion WHERE id_aplicacion='".$id_modulo_sist."'";
                            $rs = $_oControl->consulta($query);
                            $total = $_oControl->nroregistros;
                            if($total>0){
                                while($datos = $_oControl->obtener_cursor($rs)){
                                    $carpeta = $datos["carpeta"];
                                    $archivo = $datos["archivo"];
                                }
                                $url = "../".$carpeta."/".$archivo;
                                require_once($url);
                            }else{
                                echo "<script language='javascript'>document.location.href='../page/index.php';</script>";
                            }
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2019 Open Info. Derechos reservados</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>
