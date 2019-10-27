<!--Start Blog Post-->
<?php
    $consulta = "SELECT * FROM news WHERE id_noticia='".$_GET["n"]."'";
    $rs = $_oControl->consulta($consulta);
    $total = $_oControl->nroregistros;
    if($total > 0){
      $datos = $_oControl->obtener_cursor($rs);
      $titulo = $datos["titulo"];
      $subtitulo = $datos["subtitulo"];
      $resumen = fncTraducirEntidadHTML(fncTraducirEntidadHTML($datos["resumen"]));
      $img = "img/noticia/".$datos["img"];
    }
?>
    <div class="col-sm-8">
        <div class="blog-post-single">
            <div class="post-media" style="text-align:center;">
                <a href=""><img src="<?php echo $img; ?>" class="img-responsive img-center" alt="Image"></a>
            </div>
            <div class="post-content">
                <div class="post-meta">
                    <h3 class="m-0"><a href=""><?php echo $titulo; ?></a></h3>
                    <h2 class="f-2"><a href=""><?php echo $subtitulo; ?></a></h2>
                    <p><a href="blog.php?c=<?php echo $id_categoria; ?>"><i class="icofont icofont-listine-dots"></i> <?php echo $categoria; ?></a><small>/</small><a href=""><i class="icofont icofont-clock-time"></i> <?php echo fecha_mes3Letras($fecha); ?></a></p>
                </div>
                <div class="div-justify">
                    <?php echo $resumen; ?>
                </div>
                <?php
                    $consulta = "SELECT * FROM news_detalle WHERE id_noticia='".$_GET["n"]."' AND estado='A' ORDER BY orden ASC";
                    $rs = $_oControl->consulta($consulta);
                    $total = $_oControl->nroregistros;
                    if($total > 0){
                      while ($datos = $_oControl->obtener_cursor($rs)) {
                        $tipo = $datos["id_tipo"];
                        $descripcion = fncTraducirEntidadHTML(fncTraducirEntidadHTML($datos["descripcion"]));
                        switch ($tipo) {
                          case 1: //Imagen
                            $img = "img/noticia/".$datos["recurso"];
                            $html = "<div class='div-center' class='img-responsive img-center'>
                                      <img src='".$img."' class='img-responsive img-center' alt='Image'>
                                      <h6 style='text-align:center;padding-top:5px;'>".$descripcion."</h6>
                                    </div>";
                            echo $html;
                            break;
                            case 2: //Audio
                              $audio = "audio/noticia/".$datos["recurso"];
                              $html = "<div class='div-center' class='img-responsive img-center'>
                                        <div align='center' class='col-sm-12' style='padding-bottom:10px;'>
                                          <audio src='".$audio."' preload='auto' controls>
                                            <p>Tu navegador no es compatible con el elemento de Audio</p>
                                          </audio>
                                        </div>
                                        <h6 style='text-align:center;'>".$descripcion."</h6>
                                      </div>";
                              echo $html;
                              break;
                              case 3: //Video //https://www.youtube-nocookie.com/embed/
                                $video = substr(fncTraducirEntidadHTML(fncTraducirEntidadHTML($datos["recurso"])),9,-4);
                                $video = substr($video,0,strlen($video)/2-1);
                                $var = explode("?v=", $video);
                                $html = "<div class='div-center' class='img-responsive img-center'>
                                          <div align='center' class='col-sm-12'>
                                            <iframe width='420' height='315' src='https://www.youtube-nocookie.com/embed/".$var[1]."'>
                                            </iframe>
                                          </div>
                                          <h6 style='text-align:center;'>".$descripcion."</h6>
                                        </div>";
                                echo $html;
                                break;
                              case 4: //Texto
                                $texto = fncTraducirEntidadHTML(fncTraducirEntidadHTML($datos["recurso"]));
                                $html = "<div class='div-justify'>".$texto."</div>";
                                echo $html;
                                break;
                              case 5: //Cita
                                $cita = fncTraducirEntidadHTML(fncTraducirEntidadHTML($datos["recurso"]));
                                $html = "<blockquote style='text-align:justify;'>".$cita."</blockquote>";
                                echo $html;
                                break;
                              case 6: //Link
                                $link = substr(fncTraducirEntidadHTML(fncTraducirEntidadHTML($datos["recurso"])),9,-4);
                                $link = substr($link,0,strlen($link)/2-1);$descripcion = $datos["descripcion"];
                                $html = "<div class='div-justify'>".$descripcion." <a href='".$link."' target='_blank'>".$link."</a></div>";
                                echo $html;
                                break;
                          default:
                            break;
                        }
                      }
                    }
                ?>
                </div>
        </div>
    </div>
<!--End Blog Post-->
