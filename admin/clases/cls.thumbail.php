<?php
  class onn_thumbail {
	var $imagenOriginal;			//string
	var $imagenNueva; 				//string
	
// PARA CREAR UN THUMBNAIL Y VAYA ACOMPAÑADO DE UNA IMAGEN GRANDE -----------------------------------------------------
	function CrearThumbnail($original, $destino, $thumbD=120){
		$this->imagenOriginal = $original;
		$this->imagenNueva = $destino;
		
		//Obtenemos la informacion de la imagen, el array info tendra los siguientes indices:
		// 0: Ancho de la imagen
		// 1: Alto de la imagen
		// 2: Tipo de imagen
		$info = getimagesize($this->imagenOriginal);

		//Dependiendo del mime type, creamos una imagen a partir del archivo original:
		if($info[2]==1){$image = @imagecreatefromgif($this->imagenOriginal);}  // Para GIF
		if($info[2]==2){$image = @imagecreatefromjpeg($this->imagenOriginal);} // Para JPG
		if($info[2]==3){$image = @imagecreatefrompng($this->imagenOriginal);}  // Para PNG
		
		//Si el ancho es igual al alto, la imagen ya es cuadrada, por lo que podemos ahorrarnos unos pasos:		
		if($info[0] == $info[1]){
			$xpos = 0;
			$ypos = 0;
			$width = $info[1];
			$height = $info[1];
		}
		//Si la imagen no es cuadrada, hay que hacer un par de averiguaciones:
		else{
			if($info[0] <= $thumbD || $info[1] <= $thumbD){ // Si el ancho o el alto de la imagen es menor que el que se desea tener
				$xpos = 0;
				$ypos = 0;
				if($info[0] <= $thumbD){
					$width = $thumbD;
					$height = $info[1];
				}else{
					if($info[1] <= $thumbD){
						$width = $info[0];
						$height = $thumbD;
					}
				}
			}else{
				if($info[0] > $info[1]){ 
					// Imagen horizontal
					$xpos = ceil(($info[0] - $info[1]) /2);
					$ypos = 0;
					$width  = $info[1];
					$height = $info[1];
				}else{ 
					// Imagen vertical
					$ypos = ceil(($info[1] - $info[0]) /2);
					$xpos = 0;
					$width  = $info[0];
					$height = $info[0];
				}
			}
		}
		//En caso de que las dimensiones de la imagen original sea menor que las del thumb
		//realizamos una comparacion previa
		if($width<=$thumbD || $height<=$thumbD){
			if($width<=$thumbD){$thumbD=$width;}
			else{$thumbD=$height;}
		}
		
		//Creamos una nueva imagen cuadrada con las dimensiones que queremos:
		if($info[0] <= $thumbD || $info[1] <= $thumbD){
			$image_new = imagecreatetruecolor($width,$height);
			$idColor = imagecolorallocate($image_new,255,255,255);
			imagefill($image_new, 0, 0, $idColor);
		//Copiamos la imagen original con las nuevas dimensiones
			imagecopyresampled($image_new, $image, 0, 0, $xpos, $ypos, $width, $height, $width, $height);
		}else{
			$image_new = imagecreatetruecolor($thumbD,$thumbD);
			$idColor = imagecolorallocate($image_new,255,255,255);
			imagefill($image_new, 0, 0, $idColor);
		//Copiamos la imagen original con las nuevas dimensiones
			imagecopyresampled($image_new, $image, 0, 0, $xpos, $ypos, $thumbD, $thumbD, $width, $height);
		}
		
		//Guardamos la nueva imagen como JPG
		if($info[2]==1){imagegif($image_new, $this->imagenNueva);}  // Para GIF
		if($info[2]==2){imagejpeg($image_new, $this->imagenNueva, 100);} // Para JPG
		if($info[2]==3){imagepng($image_new, $this->imagenNueva);}  // Para PNG
	}

// PARA CREAR SOLO UNA IMAGEN PEQUEÑA PERFECTA DE UNA YA CREADA ---------------------------------------------------------
	function CrearImgPequenaIndirecto($archivo, $destino, $alt, $thumbD=120, $nombre=""){
		// Para el TEMPORAL
			$img_tmp = "tmp_".$nombre;
			$ancho = $thumbD+82;
			$this->CrearThumbnailImperfecto($destino.$archivo, $ancho, $alt, $destino.$img_tmp);
			$this->CrearThumbnail($destino.$img_tmp, $destino.$nombre, $thumbD);
		// Para destruir la IMAGEN TEMPORAL
			if($img_tmp<>"" && file_exists($destino.$img_tmp)){ unlink($destino.$img_tmp); }
		// Para devolver el nombre de la NUEVA IMAGEN
			return $img;
	}

// PARA CREAR SOLO UNA IMAGEN PEQUEÑA PERFECTA ------------------------------------------------------------------------
	function CrearImgPequenaDirecto($prefijo, $archivo, $temporal, $destino, $thumbD=120, $nombre=""){
		// Para el TEMPORAL
			$imgXG = new xg_imagen($archivo, $destino, $temporal, $prefijo);
			list($ancho, $alto, $tip, $atr) = getimagesize($temporal);
			$img_tmp = $imgXG->subir($ancho,$alto,1,"");
			/*
			$anchoD = $thumbD;
			if($ancho>$anchoD){ 
				$ancho = $anchoD;
				$img_tmp = $imgXG->subir($ancho,$alto,1,"");
			}else{
				$alto = $anchoD;
				$img_tmp = $imgXG->subir($ancho,$alto,2,"");
			}*/
		// Para la IMAGEN
			if($nombre==""){
				$ext = strtolower(end(explode(".", $archivo)));
				do{
					$img = $prefijo.rand(1,9999).".".$ext;
					$arch = $destino.$img;
				} while(file_exists($img));
			}else{
				$img = $nombre;
			}
			$this->CrearThumbnail($destino.$img_tmp, $destino.$img, $thumbD);
		// Para destruir la IMAGEN TEMPORAL
			if($img_tmp<>"" && file_exists($destino.$img_tmp)){ unlink($destino.$img_tmp); }
		// Para devolver el nombre de la NUEVA IMAGEN
			return $img;
	}

// PARA CREAR SOLO UNA IMAGEN PEQUEÑA ---------------------------------------------------------------------------------
	function CrearThumbnailImperfecto($original, $anchonuevo, $alt, $destino){
		$this->imagenOriginal = $original;
		$this->imagenNueva = $destino;
		
		list($ancho, $alto, $tipo, $atr) = getimagesize($original);
		if($ancho<>$anchonuevo) $alt=($alto/$ancho)*$anchonuevo;
		
		$ratio  = ($ancho / $anchonuevo); 
		$altonuevo = ($alto / $ratio); 
		if($altonuevo>$alt){$anchonuevo2=$alt*$anchonuevo/$altonuevo;$altonuevo=$alt;$anchonuevo=$anchonuevo2;}
		switch($tipo){
			case 1: //Para GIF
				$orig = @imagecreatefromgif($original);
				$thumb = @imagecreate($anchonuevo,$altonuevo);
				break;
			case 2: //Para JPG
				$orig = @imagecreatefromjpeg($original);
				$thumb = @imagecreatetruecolor($anchonuevo,$altonuevo);
				break;
			case 3: //Para PNG
				$orig = @imagecreatefrompng($original);
				$thumb = @imagecreatetruecolor($anchonuevo,$altonuevo);
				$colorBlanco = imagecolorallocate($orig,255,255,255);
				$colorTransparancia = imagecolortransparent($orig,$colorBlanco);// devuelve el color usado como transparencia o -1 si no tiene transparencias
				if($colorTransparancia!=-1){ //TIENE TRANSPARENCIA
					$colorTransparente = imagecolorsforindex($orig, $colorTransparancia); //devuelve un array con las componentes de los colores RGB + alpha
					$idColorTransparente = imagecolorallocatealpha($thumb, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue'],$colorTransparente['alpha']); // Asigna un color en una imagen retorna identificador de color o FALSO o -1 apartir de la version 5.1.3
					imagefill($thumb, 0, 0, $idColorTransparente);// rellena de color desde una cordenada, en este caso todo rellenado del color que se definira como transparente
					imagecolortransparent($thumb, $idColorTransparente); //Ahora definimos que en la nueva imagen el color transparente será el que hemos pintado el fondo.
					imagecopyresampled($thumb,$orig,0,0,0,0,$anchonuevo,$altonuevo, $ancho, $alto);// copia y redimensiona un trozo de imagen
				}
		}
		imagecopyresampled($thumb, $orig, 0, 0, 0, 0, $anchonuevo,$altonuevo, $ancho, $alto);
		if($tipo==1){imagegif($thumb, $destino);}  //Para GIF
		if($tipo==2){imagejpeg($thumb, $destino, 100);} //Para JPG
		if($tipo==3){imagepng($thumb, $destino);}  //Para PNG
	}
	
  }
?>