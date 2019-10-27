<?php
class Images{
	var $imagen;			//string
	var $temporal;			//string
	var $nombre;			//string -> Nombre de la imagen grande
	var $destino;			//string
	var $ancho_dest;		//integer
	var $alto_dest;			//integer
	var $tipo_ajuste=0;		//integer -> 0=forzar 1=ancho 2=alto
	var $miniatura=false;	//bool
	var $mini_nombre="";	//string
	var $mini_ancho=85;		//int
	var $error="error.php?";
	var $prefijo;

	//constructor
	function Images($ima, $des, $tem, $prefijo,$min=false,$min_ancho=""){
		$this->imagen = $ima;
		$this->destino = $des;
		$this->temporal = $tem;
		$this->prefijo = $prefijo;
		$this->miniatura = $min;
		$this->mini_ancho = $min_ancho;
	}

	function verificar_ext($n_arch){
		$ext = strtoupper(end(explode(".", $n_arch)));
		if(($ext!="GIF") && ($ext!="JPG") && ($ext!="JPEG") && ($ext!="PNG")){
			$this->error.="error=1&archivo=".$this->imagen;
			header("location: ".$this->error);
			exit;
		} else { $this->extension = strtolower($ext); }
	}
	function generarnombre(){
		do{
			$this->nombre = $this->prefijo.rand(1,9999).".".$this->extension;
		} while(file_exists($this->destino.$this->nombre));
		return $this->nombre;
	}

	function verificar_upload($tem, $des, $nom){
		if (!move_uploaded_file($tem, $des.$nom)) {
			$this->error.="error=2&archivo=".$this->imagen;
			header("location: ".$this->error);
			exit;
		}
	}

	function ajustar_tamano($anc, $alt, $ajus){
		list($ancho, $alto, $tipo, $atr) = getimagesize($this->destino.$this->nombre);
		switch($ajus){
			case 1: if($ancho==$anc) return true;                //redimensiona dependiendo el ANCHO
					else $alt=($alto/$ancho)*$anc;
					break;
			case 2: if($alto==$alt) return true;                 //redimensiona dependiendo el ALTO
					else $anc=($ancho/$alto)*$alt;
					break;
			default: if($ancho==$anc && $alto==$alt) return true; //no se hace nada
					break;
		}
		$ratio  = ($ancho / $anc);
		$altura = ($alto / $ratio);
		if($altura>$alt){$anc2=$alt*$anc/$altura;$altura=$alt;$anc=$anc2;}
		switch($tipo){
			case 1: //Para GIF
				$img = @imagecreatefromgif($this->destino.$this->nombre);
				$thumb = @imagecreate($anc,$altura);
				break;
			case 2: //Para JPG
				$img = @imagecreatefromjpeg($this->destino.$this->nombre);
				$thumb = @imagecreatetruecolor($anc,$altura);
				break;
			case 3: //Para PNG
				$img = @imagecreatefrompng($this->destino.$this->nombre);
				$thumb = @imagecreatetruecolor($anc,$altura);
				$colorBlanco = imagecolorallocate($img,255,255,255);
				$colorTransparancia = imagecolortransparent($img,$colorBlanco);// devuelve el color usado como transparencia o -1 si no tiene transparencias
				if($colorTransparancia!=-1){ //TIENE TRANSPARENCIA
					$colorTransparente = imagecolorsforindex($img, $colorTransparancia); //devuelve un array con las componentes de los colores RGB + alpha
					$idColorTransparente = imagecolorallocatealpha($thumb, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue'],$colorTransparente['alpha']); // Asigna un color en una imagen retorna identificador de color o FALSO o -1 apartir de la version 5.1.3
					imagefill($thumb, 0, 0, $idColorTransparente);// rellena de color desde una cordenada, en este caso todo rellenado del color que se definira como transparente
					imagecolortransparent($thumb, $idColorTransparente); //Ahora definimos que en la nueva imagen el color transparente ser� el que hemos pintado el fondo.
					imagecopyresampled($thumb,$img,0,0,0,0,$anc, $altura, $ancho, $alto);// copia y redimensiona un trozo de imagen
				}
		}
		imagecopyresampled($thumb, $img, 0, 0, 0, 0, $anc, $altura, $ancho, $alto);
		if($tipo==1){ imagegif($thumb, $this->destino.$this->nombre); }  //Para GIF
		if($tipo==2){ imagejpeg($thumb, $this->destino.$this->nombre); } //Para JPG
		if($tipo==3){ imagepng($thumb, $this->destino.$this->nombre); }  //Para PNG
	}

	//subir imagen
	function subirImage($anc, $alt, $ajus){
		$this->ancho_dest=$anc;
		$this->alto_dest=$alt;
		if($ajus!="") $this->tipo_ajuste=$ajus;
		if($this->imagen!=""){
			$this->verificar_ext($this->imagen);
			$this->verificar_upload($this->temporal, $this->destino, $this->generarnombre());
			$this->ajustar_tamano($this->ancho_dest, $this->alto_dest, $this->tipo_ajuste);
		} else{ $this->nombre = ""; }
	//subimo el thumbnail
		$rpt="";
		if(trim($this->nombre)<>"" && $this->miniatura==true){
			if($this->thumbnail()==true){
				$this->mini_nombre="thumb_".$this->nombre;
			}else{
				 $this->mini_nombre="";
			}
			$rpt = array($this->nombre,$this->mini_nombre);
		}else{
			$rpt = $this->nombre;
		}
		return ($rpt);
	}
	function thumbnail(){
		list($width,$height,$tipo) = getimagesize($this->destino.$this->nombre);
		//Dependiendo del mime type, creamos una imagen a partir del archivo original:
		if($tipo==1){ $image=@imagecreatefromgif($this->destino.$this->nombre); }  // Para GIF
		if($tipo==2){ $image=@imagecreatefromjpeg($this->destino.$this->nombre); } // Para JPG
		if($tipo==3){ $image=@imagecreatefrompng($this->destino.$this->nombre); }  // Para PNG
		//Si el ancho es igual al alto, la imagen ya es cuadrada, por lo que podemos ahorrarnos unos pasos:
		if($width == $height){
			$xpos = 0;
			$ypos = 0;
		}//Si la imagen no es cuadrada, hay que hacer un par de averiguaciones:
		else{
			if($width <= $thumbD || $height <= $thumbD){ // Si el ancho o el alto de la imagen es menor que el que se desea tener
				$xpos = 0;
				$ypos = 0;
				if($width <= $thumbD){
					$width = $thumbD;
					$height = $height;
				}else{
					if($height <= $thumbD){
						$width = $width;
						$height = $thumbD;
					}
				}
			}else{
				if($width > $height){
					// Imagen horizontal
					$xpos = ceil(($width - $height) /2);
					$ypos = 0;
					$width  = $height;
					$height = $height;
				}else{
					// Imagen vertical
					$ypos = ceil(($height - $width) /2);
					$xpos = 0;
					$width  = $width;
					$height = $width;
				}
			}
		}
		//En caso de que las dimensiones de la imagen original sea menor que las del thumb realizamos una comparacion previa
		$thumbD = $this->mini_ancho;
		if($width<=$thumbD || $height<=$thumbD){
			if($width<=$thumbD){$thumbD=$width;}else{$thumbD=$height;}
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
		$thumbnail = false;
		if($tipo==1){ $thumbnail=imagegif($image_new, $this->destino."thumb_".$this->nombre); }  // Para GIF
		if($tipo==2){ $thumbnail=imagejpeg($image_new, $this->destino."thumb_".$this->nombre, 100); } // Para JPG
		if($tipo==3){ $thumbnail=imagepng($image_new, $this->destino."thumb_".$this->nombre); }  // Para PNG
		return $thumbnail;
	}
}
?>
