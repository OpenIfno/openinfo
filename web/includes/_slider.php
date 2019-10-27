<?php
    $consulta = "SELECT * FROM slider WHERE estado='A' LIMIT 1";
    $rs = $_oControl->consulta($consulta);
    $total = $_oControl->nroregistros;
      if($total > 0){
        while($datos = $_oControl->obtener_cursor($rs)){
            $img = "img/slider/".$datos["img"];
            $titulo = $datos["titulo"];
            $descrip = $datos["descrip"];
        }}
?>
<!--Start Banner Area-->
        <section id="banner-area" style="background-image: url(<?php echo $img; ?>);" class="bg-cover fix">
            <div class="overlay"></div>
            <!--Start Container-->
            <div class="container">
                <!--Start Row-->
                <div class="row">
                    <!--Start Banner Content-->
                    <div class="col-sm-7">
                        <div class="banner-content">
                            <h3 class="font-500 color-white"></h3>
                            <h1 class="font-700 color-white"><?php echo $titulo; ?></h1>
                            <p class="color-white"><?php echo $descrip; ?></p>
                            <a href="#about-area">About Us</a>
                        </div>
                    </div>
                    <!--End Banner Content-->

                    <!--Start Banner Image-->
                    <div class="col-sm-5">
                        <div class="banner-img">
                            <img src="assets\images\man.png" class="img-responsive" alt="Image">
                        </div>
                    </div>
                    <!--End Banner Image-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Banner Area-->
