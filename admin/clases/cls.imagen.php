<?php
class xg_imagen {
	var $imagen;			//string
	var $temporal;			//string
	var $nombre;			//string
	var $destino;			//string
	var $ancho_dest;		//integer
	var $alto_dest;			//integer
	var $tipo_ajuste=0;		//integer -> 0=forzar 1=ancho 2=alto
	var $miniatura=false;	//bool
	var $ancho_mini=50;		//int
	var $alto_mini=50;		//int
	var $extension;         //string
	var $error="error.php?";
	var $prefijo;
// Para subir la imagen con el mismo nombre
	var $chancar="no";		//string
	var $nombre_antes;		//string

	function xg_imagen($ima, $des, $tem, $prefijo, $chancar="no",$nombre_antes=""){
		$this->imagen = $ima;
		$this->destino = $des;
		$this->temporal = $tem;
		$this->prefijo = $prefijo;
		if(trim($chancar)<>"" && trim($chancar)=="si"){
			$this->chancar = "si";
			if(trim($nombre_antes)<>""){
				$this->nombre_antes = $nombre_antes;
			}else{
				exit("Falta indicar el nombre anterior");
			}
		}
	}
	function verificar_ext($n_arch){
		//$ext = strtoupper(substr($n_arch,-3));		
		$ext = strtoupper(end(explode(".", $n_arch)));
		if(($ext!="GIF") && ($ext!="JPG") && ($ext!="JPEG") && ($ext!="PNG")){
			$this->error.="error=1&archivo=".$this->imagen;
			header("location: ".$this->error);			
			exit;
		} else { $this->extension = strtolower($ext); }
	}
	function generarnombre(){
		if($this->chancar=="no"){
			do{
				$this->nombre = $this->prefijo.rand(1,9999).".".$this->extension;
			} while(file_exists($this->destino.$this->nombre));
		}else{
			$this->nombre = $this->nombre_antes;
		}
		return $this->nombre;
	}
	function verificar_upload($tem, $des, $nom){
		if (!move_uploaded_file($tem, $des.$nom)) {
			$this->error.="error=2&archivo=".$this->imagen;
			header("location: ".$this->error);
			exit;
		}
	}
	function ajustar_tamaño($anc, $alt, $ajus){
		list($ancho, $alto, $tipo, $atr) = getimagesize($this->destino.$this->nombre);
		switch($ajus){
			case 0: if($ancho==$anc && $alto==$alt) return true; //no se hace nada
					break;
			case 1: if($ancho==$anc) return true;                //redimensiona dependiendo el ANCHO
					else $alt=($alto/$ancho)*$anc;
					break;
			case 2: if($alto==$alt) return true;                 //redimensiona dependiendo el ALTO
					else $anc=($ancho/$alto)*$alt;
					break;
			case 3: break;
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
					imagecolortransparent($thumb, $idColorTransparente); //Ahora definimos que en la nueva imagen el color transparente será el que hemos pintado el fondo.
					imagecopyresampled($thumb,$img,0,0,0,0,$anc, $altura, $ancho, $alto);// copia y redimensiona un trozo de imagen
				}
		}
		imagecopyresampled($thumb, $img, 0, 0, 0, 0, $anc, $altura, $ancho, $alto);
		if($tipo==1){imagegif($thumb, $this->destino.$this->nombre);}  //Para GIF
		if($tipo==2){imagejpeg($thumb, $this->destino.$this->nombre);} //Para JPG
		if($tipo==3){imagepng($thumb, $this->destino.$this->nombre);}  //Para PNG
	}
	function subir($anc, $alt, $ajus, $img_ant){
		$this->ancho_dest=$anc;
		$this->alto_dest=$alt;
		if($ajus!="") $this->tipo_ajuste=$ajus;
		if($this->imagen!=""){
			$this->verificar_ext($this->imagen);
			$this->verificar_upload($this->temporal, $this->destino, $this->generarnombre());
			$this->ajustar_tamaño($this->ancho_dest, $this->alto_dest, $this->tipo_ajuste);
		} else{ $this->nombre = ""; }
		if($img_ant!=""){
			if(!unlink($this->destino.$img_ant)){
				$this->error = "Error eliminando la imagen ".$img_ant.". Probablemente la imagen no existe.";
				header("location: error.php?".$this->error);
				exit;
			}
		}
		return $this->nombre;
	}
}
?>