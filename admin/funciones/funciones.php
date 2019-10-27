<?php
//_Para convertir tipo de datos
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
	{
	  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

	  switch ($theType) {
		case "text":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;
		case "long":
		case "int":
		  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
		  break;
		case "double":
		  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
		  break;
		case "date":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;
		case "defined":
		  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		  break;
	  }
	  return $theValue;
	}
}
//_Para codificar el texto malicioso
function codificarTextoMalicioso($texto){
   $textoCodificado = $texto;
    // Caracteres especiales
   $textoCodificado = preg_replace('/<(.*)?>/is','', $textoCodificado);
   if(preg_match("drop",$textoCodificado)){ $textoCodificado = str_replace("drop","",$textoCodificado); }
   if(preg_match("delete",$textoCodificado)){ $textoCodificado = str_replace("delete","",$textoCodificado); }
   if(preg_match("insert",$textoCodificado)){ $textoCodificado = str_replace("insert","",$textoCodificado); }
   if(preg_match("update",$textoCodificado)){ $textoCodificado = str_replace("update","",$textoCodificado); }
   if(preg_match("select",$textoCodificado)){ $textoCodificado = str_replace("select","",$textoCodificado); }
   if(preg_match("and",$textoCodificado)){ $textoCodificado = str_replace("and","",$textoCodificado); }
   //if(ereg("(",$textoCodificado)){ $textoCodificado = str_replace("(","",$textoCodificado); }
   if(preg_match(")",$textoCodificado)){ $textoCodificado = str_replace(")","",$textoCodificado); }
   //if(ereg("&",$textoCodificado)){ $textoCodificado = str_replace("&","",$textoCodificado); }
   if(preg_match("<",$textoCodificado)){ $textoCodificado = str_replace("<","",$textoCodificado); }
   if(preg_match(">",$textoCodificado)){ $textoCodificado = str_replace(">","",$textoCodificado); }
   if(preg_match("/",$textoCodificado)){ $textoCodificado = str_replace("/","",$textoCodificado); }
   //if(ereg("\\",$textoCodificado)){ $textoCodificado = str_replace("\\","",$textoCodificado); }
   if(preg_match("#",$textoCodificado)){ $textoCodificado = str_replace("#","",$textoCodificado); }
   //if(ereg(";",$textoCodificado)){ $textoCodificado = str_replace(";","",$textoCodificado); }
   if(preg_match("'",$textoCodificado)){ $textoCodificado = str_replace("'","",$textoCodificado); }
   if(preg_match("%",$textoCodificado)){ $textoCodificado = str_replace("%","",$textoCodificado); }
   //if(ereg("[",$textoCodificado)){ $textoCodificado = str_replace("[","",$textoCodificado); }
   if(preg_match("]",$textoCodificado)){ $textoCodificado = str_replace("]","",$textoCodificado); }
   return htmlentities(htmlspecialchars(trim(stripslashes($textoCodificado))));
}
//_Para validar ENTERO que se almacene en BD
function fncValidarEnteroBD($num=""){
	if(fncVerificarID($num)==1){
		$num="'".fncCodificar($num)."'";
	}else{
		$num="NULL";
	}
	return $num;
}
//_Para validar CADENA que se almacene en BD
function fncValidarCadenaBD($cadena=""){
	if(trim($cadena)<>""){
		$cadena="'".fncCodificar($cadena)."'";
	}else{
		$cadena="NULL";
	}
	return $cadena;
}
//_Para verificar el ID de peticion
function fncVerificarID($id=""){
	if(trim($id)<>""){
		$valido=1;
		if($id<1){ $valido=0; }
		if(!is_numeric($id)){ $valido=0; }
	}else{
		$valido=0;
	}
	return $valido;
}
//_Para verificar el ID y forma el menu
function fncVerificarIdMenu($id=""){
	if(trim($id)<>""){
		$valido=1;
		if($id<0){ $valido=0; }
		if(!is_numeric($id)){ $valido=0; }
	}else{
		$valido=0;
	}
	return $valido;
}
//_Para verificar si es un decimal valido
function fncVerificarDecimal($num=""){
	$valido = 0;
	if(trim($num)<>""){ // /^(\d)+((\.)(\d){1,2})?$/
		if(preg_match("/^0[.]{0,1}[0-9]*$/",$num)){
			$valido = 1;
		}else{
			$valido = 1;
			if($num<1){ $valido=0; }
			if(!is_numeric($num)){ $valido=0; }
		}
	}
	return $valido;
}
//_Para validar FECHA que se almacene en BD
function fncValidarFechaBD($fecha=""){ // d-m-Y
	if(fncValidarFecha($fecha)==1){
		$fecha="'".fncFormatearFecha($fecha)."'";
	}else{
		$fecha="NULL";
	}
	return $fecha;
}
//_Para imprimir CADENA en un PDF
function fncImprimirCadenaPDF($cadena="",$tipo=""){
	if(trim($cadena)<>""){
		if($tipo=="fecha"){
			$cadena=fncFormatearFecha($cadena);
		}else{
			$cadena=utf8_decode(fncTraducirEntidadHTML($cadena));
		}
	}else{
		$cadena="";
	}
	return $cadena;
}
//_Para que devuelva la parte entera de un numero
function fncEntero($Numero){
	return (int)$Numero;
}
//_Para convertir a cadena
function fncString($valor){
	return (string)$valor;
}
//_Reemplaza todos los acentos por sus equivalentes sin ellos
function fncReemplazarCaracteresEspeciales($text=""){
	if(trim($text)<>""){
		$text = htmlentities($text, ENT_QUOTES, 'UTF-8');
		$patron = array(
		//_Espacios, puntos y comas por guion
			'/[\., ]+/' => ' ',
		//_Vocales
			'/&agrave;/' => 'a',
			'/&egrave;/' => 'e',
			'/&igrave;/' => 'i',
			'/&ograve;/' => 'o',
			'/&ugrave;/' => 'u',

			'/&aacute;/' => 'a',
			'/&eacute;/' => 'e',
			'/&iacute;/' => 'i',
			'/&oacute;/' => 'o',
			'/&uacute;/' => 'u',

			'/&Aacute;/' => 'A',
			'/&Eacute;/' => 'E',
			'/&Iacute;/' => 'I',
			'/&Oacute;/' => 'O',
			'/&Uacute;/' => 'U',

			'/&acirc;/' => 'a',
			'/&ecirc;/' => 'e',
			'/&icirc;/' => 'i',
			'/&ocirc;/' => 'o',
			'/&ucirc;/' => 'u',

			'/&atilde;/' => 'a',
			'/&amp;etilde;/' => 'e',
			'/&amp;itilde;/' => 'i',
			'/&otilde;/' => 'o',
			'/&amp;utilde;/' => 'u',

			'/&auml;/' => 'a',
			'/&euml;/' => 'e',
			'/&iuml;/' => 'i',
			'/&ouml;/' => 'o',
			'/&uuml;/' => 'u',
		//_Otras letras y caracteres especiales
			'/&aring;/' => 'a'
		//_Agregar aqui mas caracteres si es necesario
		);
		/*'/&ntilde;/' => '�', '/&Ntilde;/' => '�', */
		$text = preg_replace(array_keys($patron),array_values($patron),$text);
	}
	return $text;
}
//_Para codificar el texto de salida (convierte los caracteres especiales a entidades HTML) Ejm. � -> $aacute;
function codificarTexto($texto){
	//$texto = utf8_decode($texto);
	return htmlentities($texto,ENT_QUOTES,'utf-8');
}
//_Para corregir el registro de texto
function fncCodificar($texto=""){
	if($texto<>""){
		return codificarTexto(fncSeguridad($texto));
	}else{ return $texto; }
}
//_Para la seguridad de los registros
function fncSeguridad($texto=""){
	//$texto = preg_replace("/\s+/"," ",$texto);
	if(trim($texto)<>""){
		return htmlspecialchars(trim(stripslashes($texto)));
	}else{ return $texto; }
}
//_Para CODIFICAR TEXTO (TRADUCIR ENTIDADES HTML)
function fncCodificarEntidadHTML($texto=""){
	if(trim($texto)<>""){
		return htmlentities($texto);
	}else{ return $texto; }
}
//_Para DECODIFICAR TEXTO (TRADUCIR ENTIDADES HTML)
function fncTraducirEntidadHTML($texto=""){
	if(trim($texto)<>""){
		//return utf8_encode(html_entity_decode($texto));
		return html_entity_decode($texto);
	}else{ return $texto; }
}
//_Para Comprobar entrada VACIA de TEXTOS
function fncComprobarEntradaTexto($texto,$limit="",$sufix=""){
	if(fncTraducirEntidadHTML($texto)<>""){
		if($limit==""){
			$devolver = fncTraducirEntidadHTML($texto);
		}else{
			$devolver = substr($texto,0,$limit);
			if(strlen(trim($texto))>$limit){ $devolver.=" ..."; }
		}
	}else{
		if($sufix==""){ $sufix="-"; }
		$devolver=$sufix;
	}
	return $devolver;
}
//_Verifica<r si en un RUT correcto (CHILE)
function fncVerificarRut($value=""){
	if(empty($value)){ return false; }
	$RegExp = '/^([0-9])+\-([kK0-9])+$/';
	if(!preg_match($RegExp, $value)){ return false; }
	$RUT = explode("-",$value);
	$elRut = $RUT[0];
	$factor = 2;
	$suma = 0;
	for($i=strlen($elRut)-1; $i>=0; $i--){
		$factor = ($factor>7) ? 2 : $factor;
		$suma += ((int)$elRut{$i}) * ((int)$factor++ );
	}
	$ret = true;
	$dv = 11 - ($suma % 11);
	if($dv == 11){
		 $dv = 0;
	}else if($dv == 10){
		 $dv = "k";
	}
	if($dv != strtolower($RUT[1])){
		 $ret = false;
	}
	return $ret;
}
//_Para obtener el THUMBNAIL de un video de youtube
function fncObtenerUrlThumbYoutube($video_url, $quality=0){
	$video_id = fncYoutubeId($video_url);
	return 'http://img.youtube.com/vi/' . $video_id . '/' . $quality . '.jpg';
}
//_Para obtener el ID de un video de youtube
function fncYoutubeId($url){
	$query_string = array();
	parse_str(parse_url($url, PHP_URL_QUERY), $query_string);
	$id = $query_string["v"];
	return $id;
}
//_Generacion del texto aleatorio
function fncTextoAleatorio($length=5){
	$pattern = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	for($i=0;$i<$length;$i++) {
		$key .= $pattern{rand(0,35)};
	}
	return $key;
}
//_Para validar una fecha
function fncValidarFecha($fecha=""){ //-> $fecha = dd-mm-YYYY
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  $arrayFecha=explode("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("-",$fecha);

		if(checkdate($arrayFecha[1], $arrayFecha[0], $arrayFecha[2])){ // MES - DIA - ANIO
			return 1;
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}
//_Para sumar meses a un fecha
function fncSumarMesesFecha($fecha,$meses){ // $fecha = dd-mm-YYYY
	if(fncValidarFecha($fecha)==1 && fncVerificarID($meses)==1){
		return (date('d-m-Y', strtotime("+".$meses." month",strtotime($fecha))));
	}else{
		return $fecha;
	}
}
//_Para darle formato a la fecha y enviar a la BD
function fncFormatearFecha($fecha="",$separador="-"){
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("-",$fecha);

		return $arrayFecha[2].$separador.$arrayFecha[1].$separador.$arrayFecha[0];
	}else{
		return "&nbsp;";
	}
}
//_Para limitar la cantidad de palabras
function fncLimitarPalabras($cadena, $longitud, $elipsis = "...") {
	$palabras = explode(' ', $cadena);
	if(count($palabras) > $longitud){
		return implode(' ', array_slice($palabras, 0, $longitud)).$elipsis;
	}else{
		return $cadena;
	}
}
//_Para limitar la cantidad de caracteres
function fncLimitarCaracteres($cadena, $longitud, $elipsis = "...") {
	$caracteres = strlen($cadena);
	if($caracteres>$longitud){
		return substr($cadena, 0, $longitud).$elipsis;
	}else{
		return $cadena;
	}
}
//_Para obtener el total de dias de un mes en un a�o
function fncTotalDiasMesAnio($Month, $Year){
	if(is_callable("cal_days_in_month")){ //--> Si la extensi�n calendario est� instalada, usamos esa.
		return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
	}else{ //---------------------------------> En caso no tener la extension empleamos esto.
		return date("d",mktime(0,0,0,$Month+1,0,$Year));
	}
}
//_Para obtener el total de dias de un mes en un a�o sin fines de semana (ni sabado ni domingo)
function fncTotalDiasMesAnioNoFinSemana($Month, $Year){
	$total_dias = 1;
	if(is_callable("cal_days_in_month")){ //--> Si la extensi�n calendario est� instalada, usamos esa.
		$total_dias = cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
	}else{ //---------------------------------> En caso no tener la extension empleamos esto.
		$total_dias = date("d",mktime(0,0,0,$Month+1,0,$Year));
	}
	$fch_ini = strtotime("01"."-".$Month."-".$Year);
	$fch_fin = strtotime($total_dias."-".$Month."-".$Year);
	$tot_fin_semana = 0;
	while($fch_ini <= $fch_fin){
		if((date("w",$fch_ini)==0) || (date("w",$fch_ini)==6)){ //--> 0 para domingo, 6 para sabado
			++$tot_fin_semana;
		}
		$fch_ini += 86400;
	}
	return($total_dias-$tot_fin_semana);
}
//_Para obtener el total de dias entre 2 fechas sin fines de semana (ni sabado ni domingo)
function fncTotalDiasEntreFechasNoFinSemana($fch_1, $fch_2){ // dd-mm-YYYY
	$tot_dias = 0;
	if(fncValidarFecha($fch_1)==1 && fncValidarFecha($fch_2)==1){
		if(preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fch_1)){ list($dia_1,$mes_1,$anio_1)=explode("/", $fch_1); }
		if(preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fch_1)){ list($dia_1,$mes_1,$anio_1)=explode("-",$fch_1); }

		if(preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fch_2)){ list($dia_2,$mes_2,$anio_2)=explode("/", $fch_2); }
		if(preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fch_2)){ list($dia_2,$mes_2,$anio_2)=explode("-",$fch_2); }
		$fch_ini = strtotime($dia_1."-".$mes_1."-".$anio_1);
		$fch_fin = strtotime($dia_2."-".$mes_2."-".$anio_2);
		while($fch_ini <= $fch_fin){
			if((date("w",$fch_ini)<>0) && (date("w",$fch_ini)<>6)){ //--> 0 para domingo, 6 para sabado
				++$tot_dias;
			}
			$fch_ini += 86400;
		}
	}
	return($tot_dias);
}
//_Para obtener el total de meses entre 2 fechas
function fncTotalMesesFechas($fch_1,$fch_2){ // dd-mm-YYYY
	$tot_meses = 0;
	if(fncValidarFecha($fch_1)==1 && fncValidarFecha($fch_2)==1){
		$inicio = fncFormatearFecha($fch_1)." 00:00:00";
		$fin = fncFormatearFecha($fch_2)." 23:59:59";
		$datetime1 = new DateTime($inicio);
		$datetime2 = new DateTime($fin);
	//_Obtenemos la diferencia entre las dos fechas
		$interval = $datetime2->diff($datetime1);
	//_Obtenemos la diferencia en meses
		$intervalMeses = $interval->format("%m");
	//_Obtenemos la diferencia en a�os y la multiplicamos por 12 para tener los meses
		$intervalAnos = $interval->format("%y")*12;
	//_Obtenemos el total de meses entre las 2 fechas
		$tot_meses = $intervalMeses + $intervalAnos;
	}
	return($tot_meses);
}
//_Para saber si una fecha ingresada es fin de semana (sabado o domingo)
function fncEsFinSemana($fecha){ // dd-mm-YYYY
	$rpt = "no";
	if(fncValidarFecha($fecha)==1){
		if(preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha)){ list($dia,$mes,$anio)=explode("/", $fecha); }
		if(preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha)){ list($dia,$mes,$anio)=explode("-",$fecha); }
		$fch_evaluar = strtotime($dia."-".$mes."-".$anio);
		if((date("w",$fch_evaluar)==0) || (date("w",$fch_evaluar)==6)){
			$rpt = "si";
		}
	}
	return $rpt;
}
//_Para emitir el Nombre en Espa�ol del mes ingresado
function nombre_mes($mes){
	$meses = array(1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre");
	return $meses[GetSQLValueString($mes, "int")];
}
//_Para las noticias
function nombre_mes_corto($mes){
	$meses = array(1=>"Ene",2=>"Feb",3=>"Mar",4=>"Abr",5=>"May",6=>"Jun",7=>"Jul",8=>"Ago",9=>"Sept",10=>"Oct",11=>"Nov",12=>"Dic");
	return $meses[GetSQLValueString($mes, "int")];
}
//_Para que imprime el nombre del dia
function dia($fecha){
	$fechats = strtotime($fecha);
	switch (date('w', $fechats)){
		case 0: $diaTexto = "Domingo"; break;
		case 1: $diaTexto = "Lunes"; break;
		case 2: $diaTexto = "Martes"; break;
		case 3: $diaTexto = "Miercoles"; break;
		case 4: $diaTexto = "Jueves"; break;
		case 5: $diaTexto = "Viernes"; break;
		case 6: $diaTexto = "Sabado"; break;
	}
	return $diaTexto;
}
function fecha_not($fec=""){
	if(trim($fec)==""){ $fec=date("Y-m-d"); }
	list($anio,$mes,$dia) = explode("-",$fec);
	$fec = "TACNA, ".$dia." de ".strtoupper(nombre_mes($mes))." del ".$anio;
	return $fec;
}
//_Para imprimir la fecha corta
function fecha_letrasCorta($fecha=""){ // d-m-Y
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  $arrayFecha=explode("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("-",$fecha);

		$meses = array(1=>"Ene",2=>"Feb",3=>"Mar",4=>"Abr",5=>"May",6=>"Jun",7=>"Jul",8=>"Ago",9=>"Sept",10=>"Oct",11=>"Nov",12=>"Dic");
		$ret = $meses[GetSQLValueString($arrayFecha[1], "int")].", ".$arrayFecha[0];
		return $ret;
	}else{ return ""; }
}
//_Para imprimir la fecha para las noticias
function fecha_letrasNoticia($fecha=""){ // d-m-Y
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  $arrayFecha=explode("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("-",$fecha);

		$meses = array(1=>"Ene",2=>"Feb",3=>"Mar",4=>"Abr",5=>"May",6=>"Jun",7=>"Jul",8=>"Ago",9=>"Sept",10=>"Oct",11=>"Nov",12=>"Dic");
		$ret = $arrayFecha[0]." / ".$meses[GetSQLValueString($arrayFecha[1], "int")]." / ".$arrayFecha[2];
		return $ret;
	}else{ return ""; }
}
function fecha_letrasCompacto($fec=""){// date("Y-m-d")
	if(trim($fec)==""){ $fec=date("Y-m-d"); }
	list($anio,$mes,$dia) = explode("-",$fec);
	$fec = dia($dia."-".$mes."-".$anio).", ".$dia." de ".nombre_mes($mes)." del ".$anio;
	return $fec;
}

function fecha_mes3Letras($fec=""){// date("Y-m-d")
	if(trim($fec)==""){ $fec=date("Y-m-d"); }
	list($anio,$mes,$dia) = explode("-",$fec);
	$fec = $dia." ".nombre_mes_corto($mes).", ".$anio;
	return $fec;
}
function fecha_datetime($fecha, $formato='%d-%m-%Y %H:%i:%s'){
	if(trim($fecha)<>""){
		$timestamp = strtotime($fecha);
		return strftime($formato,$timestamp);
	}else{ return ""; }
}
//_Para emitir la Fecha completa
function fecha_letras($fecha=""){ //dd-mm-YYYY
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  $arrayFecha=explode("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("-",$fecha);

		$fec = $arrayFecha[0]." de ".nombre_mes(GetSQLValueString($arrayFecha[1], "int"))." de ".$arrayFecha[2];
		return $fec;
	}else{ return ""; }
}
//_Para emitir la Fecha completa
function fecha(){
	$fec = date("d")." de ".nombre_mes(GetSQLValueString(date("m"), "int"))." del ".date("Y");
	return $fec;
}
//_Para emitir la Fecha Sin Dia
function fechaSinDia(){
	$fec = "Tacna, ".nombre_mes(GetSQLValueString(date("m"), "int"))." del ".date("Y");
	return $fec;
}
//_Para recuperar la fecha del sistema
function fecha_corta(){
	$fec = date("d/m/Y");
	return $fec;
}
//_Para recuperar la Hora del sistema
function hora_corta(){
	$hor = date("h:i:s");
	return $hor;
}
//_Para validar una hora con formato: HH:MM
function fncValidarHoraCorta($hora=""){
	if($hora<>""){
		$arrayHora = explode(":",$hora);
		if(count($arrayHora)<2){ return false; }
		$h = $arrayHora[0];
		$m = $arrayHora[1];
		if(is_numeric($h) && is_numeric($m)){
			if($h<0 || $h>23){ return false; }
			if($m<0 || $m>59){ return false; }
			return true;
		}else{ return false; }
	}else{ return false; }
}
//_Para obtener un nuevo ID con ceros delante
function fncRellenarCeros($nro,$numCeros=3){
	for($i=strlen($nro); $i<$numCeros; $i++){
		$cero.= "0";
	}
	return $cero.$nro;
}
//_Para reemlazar NUMERO por IMAGEN (imagen con el mismo nombre del numero)
function fncNumeroImagen($numero="",$rutaImagen="",$extensionImagen=""){
	if($numero<>"" && $rutaImagen<>"" && $extensionImagen<>""){
		$numeroImagen = preg_replace("/\d/","<img src=\"".$rutaImagen."\\0".$extensionImagen."\" border=\"0\" />",$numero);
		return $numeroImagen;
	}else{
		return $numero;
	}
}
//_Para calcular el peso de un archivo
function tamano_archivo($peso , $decimales = 2 ) {
	$clase = array(" Bytes", " KB", " MB", " GB", " TB"); return
	round($peso/pow(1024,($i = floor(log($peso, 1024)))),$decimales ).$clase[$i];
}
//_Para obtener el PRIMER y ULTIMO dia de una semana X
function primerUltimoDiaSemana($semana,$dia="primero"){
	// Primera semana del a�o:
	$anio = date('Y', time());
	$inicio = strtotime("$anio-01-01 12:00am");
	// Obtenemos el timestamp del lunes para la primera semana
	$inicio += (1-4) * 86400;
	// Agregamos el total de semanas dadas por el usuario:
	$inicio += ($semana - 1) * 7 * 86400;
	// Agregamos 6 dias y obtenemos el timestamp del fin de semana
	$fin = $inicio + (6 * 86400);

	if($dia=="primero"){ return date("d/m/Y",$inicio); }
	else{ return date("d/m/Y",$fin); }
}
//_Para restar Fechas - Devuelve resultado en DIAS --> dd/mm/yyyy o dd-mm-yyyy
function fncRestaFechas($dFecIni, $dFecFin){
	$dFecIni = str_replace("-","",$dFecIni);
	$dFecIni = str_replace("/","",$dFecIni);
	$dFecFin = str_replace("-","",$dFecFin);
	$dFecFin = str_replace("/","",$dFecFin);

	preg_match( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
	preg_match( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

	$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
	$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);

	return round(($date2 - $date1) / (60 * 60 * 24));
}
//_Para sumar dias a una fecha
function sumaDiasFecha($fecha,$ndias,$separador=""){
  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  list($dia,$mes,$anio)=explode("/", $fecha);

  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
		  list($dia,$mes,$anio)=explode("-",$fecha);

	$nueva = mktime(0,0,0, $mes,$dia,$anio) + $ndias * 24 * 60 * 60;
	if($separador=="") $separador="-";
	$nuevafecha = date("d".$separador."m".$separador."Y",$nueva);

  return ($nuevafecha);
}
// Funcion pata validar EMAIL
function comprobar_email($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminaci�n del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if($mail_correcto){ return 1; }
    else{ return 0; }
}
//_Para validar IMAGEN a insertar
function fncValidarImagen($foto){
	$ext_perm = array(0=>"gif",1=>"jpg",2=>"jpe",3=>"png",4=>"jpeg");
	$ext = strtolower(end(explode(".", $foto)));
	$permitida = 0;
	for ($j=0; $j<count($ext_perm); $j++){
		if ($ext_perm[$j] == $ext){
			$permitida = 1;
			break;
		}
	}
	return $permitida;
}
function fncValidarAudio($audio){
	$ext_perm = array(0=>"webm",1=>"ogg",2=>"mp3",3=>"wav");
	$ext = strtolower(end(explode(".", $audio)));
	$permitida = 0;
	for ($j=0; $j<count($ext_perm); $j++){
		if ($ext_perm[$j] == $ext){
			$permitida = 1;
			break;
		}
	}
	return $permitida;
}
//_Para validar ARCHIVO a insertar
function fncValidarArchivo($foto,$video=""){
	if($video=="" || $video=="no"){ $ext_perm = array(0=>"gif",1=>"jpg",2=>"jpe",3=>"png",4=>"swf"); }
	else{ $ext_perm = array(0=>"gif",1=>"jpg",2=>"jpe",3=>"png",4=>"mpg",5=>"mpe"); }
	$ext = strtolower(end(explode(".", $foto)));
	$permitida = 0;
	for ($j=0; $j<count($ext_perm); $j++){
		if ($ext_perm[$j] == $ext){
			$permitida = 1;
			break;
		}
	}
	return $permitida;
}
//_Para validar un archivo PDF
function fncValidarArchivoPDF($pdf=""){
	if(trim($pdf)<>""){
		//$ext_perm = array(0=>"pdf");
		$ext_perm = array(0=>"pdf",1=>"doc",2=>"docx");
		$ext = strtolower(end(explode(".", $pdf)));
		$permitida = 0;
		for ($j=0; $j<count($ext_perm); $j++){
			if ($ext_perm[$j] == $ext){
				$permitida = 1;
				break;
			}
		}
		return $permitida;
	}else{ return 0; }
}
//_Para validar un archivo EXCEL
function fncValidarArchivoEXCEL($excel=""){
	if(trim($excel)<>""){
		$ext_perm = array(0=>"xls",1=>"xlsx");
		$ext = strtolower(end(explode(".", $excel)));
		$permitida = 0;
		for ($j=0; $j<count($ext_perm); $j++){
			if ($ext_perm[$j] == $ext){
				$permitida = 1;
				break;
			}
		}
		return $permitida;
	}else{ return 0; }
}
//_Para CONTROLAR la subida de archivos maliciosos
function fncValidarMalicioso($archivo=""){ // Compatible para cualquier subida de archivos (nombre del artchivo)
	if(trim($archivo)<>""){
		$ext_perm = array(0=>"php",1=>"asp",2=>"net",3=>"jsp",4=>"js",5=>"xml",6=>"perl",7=>"python",8=>"ruby");
		$malicioso = 1;
		for ($j=0; $j<count($ext_perm); $j++){
			$ext = ".".$ext_perm[$j]."."; // Ejem: imagen.php.jpg
			if(preg_match($ext,$archivo)){
				$malicioso = 1; // Esta INFECTADO
				break;
			}else{
				$malicioso = 0; // Esta LIMPIO
			}
		}
	}else{ $malicioso = 0; } // Esta LIMPIO
	return $malicioso;
}
//_Para devolver datos paginados
function paginar($count,$hasta,$ultMostrado,$pag,$link_totales,$extra_variables){
	if($link_totales==1) $link_totales=2;
	$links = ceil($count / $hasta); // 55 = 494/9
	$arriba = $link_totales - 1;

	if($pag > ceil($link_totales / 2)){
		$abajo = $pag - (ceil($link_totales / 2)); //$pag - 1;
	}else{
		$abajo = 1; //$pag - (ceil($pag / 2));
	}
	if($abajo==0) $abajo = 1;
	$temp_r = $links - $pag;
	if($temp_r>=$arriba){
		$link_break = $pag + $arriba;
		if($link_break>$link_totales){ $link_break=$abajo+$link_totales-1; }
	}else{
		$link_break = $links;
		//$abajo = $pag + 1 - $arriba;
		if($pag==($links-1)){ $abajo = $pag - $arriba; }
		if($pag==$links){ $abajo = $pag - 1 - $arriba; }
		if($abajo<0){ $abajo=0; }
		if($link_break>$link_totales){ $link_break=$abajo+$link_totales; }
		if($link_break>$links){ $link_break=$links; }
	}
	//if($pag==1)$link_break = $link_totales;
	if($abajo==0)$abajo=1;
	if(strlen($extra_variables)!=0) $extra_variables = "&".ereg_replace(" ","+",$extra_variables);
	if($pag==1){
		$anterior = 1;
	}else{
		$anterior = $pag - 1;
	}
	$faltanMostrar = $count - $ultMostrado; // 20 - 15

	echo "<table class='paginacion' border='0' cellspacing='1' cellpadding='0'>
		  <tr>";
		  if($pag!=1){
		  		$url_primero = $_SERVER['PHP_SELF']."?pag=1".$extra_variables;
				$url_anterior = $_SERVER['PHP_SELF']."?pag=".$anterior.$extra_variables;
				echo "<td class='page'><a href='".$url_primero."' class='paginacion_antes' title='Ir a la primera pagina'>Primero</a></td>
					  <td class='paginacion_separacion page'>-</td>
					  <td class='page'><a href='".$url_anterior."' class='paginacion_antes' title='Ir a la pagina anterior'>Anterior</a></td>
					  <td class='paginacion_separacion page'>-</td>";
		   }
			if(round($link_break)<=0){$link_break=1;}
			if(round($link_break)==1){if($faltanMostrar<>0){$link_break=2;}}
			if(round($link_break)==1){if($pag==2){$link_break=2;}}
			$tot_links = round($link_break);
			for($i=$abajo;$i<=$tot_links;$i++){
				if($pag==$i){
					echo "<td class='paginacion_elegido page'>".$i."</td>";
				}else{
					$url_numero = $_SERVER['PHP_SELF']."?pag=".$i.$extra_variables;
					echo "<td class='page'><a href='".$url_numero."' class='paginacion_enlace' title='Ir a pagina ".$i."'>".$i."</a></td>";
				}
				if($faltanMostrar<>0 || $i<>$tot_links){
					echo "<td class='paginacion_separacion page'>-</td>";
				}
			}
			if($pag==$links){
					$siguiente = $links;
			}else{
					$siguiente = $pag + 1;
			}
			if($faltanMostrar<>0){
				$url_siguiente = $_SERVER['PHP_SELF']."?pag=".$siguiente.$extra_variables;
				$url_ultimo = $_SERVER['PHP_SELF']."?pag=".round($links).$extra_variables;
				echo "<td class='page'><a href='".$url_siguiente."' class='paginacion_sigue' title='Ir a la pagina siguiente'>Siguiente</a></td>
					  <td class='paginacion_separacion page'>-</td>
					  <td class='page'><a href='".$url_ultimo."' class='paginacion_sigue' title='Ir a la ultima pagina'>Ultimo</a></td>";
			}
	 echo "</tr>
		   </table>";
}

// Para obtener el URl completo
function averiguaUrl() {
	$protocolo = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http'; // Se extrae el protocolo (http o https)
	return $protocolo.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; // Se devuelve la URL completa
}
// Para obtener el URL sin variables
function averiguaUrlSinVars() {
	$protocolo = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http'; // Se extrae el protocolo (http o https)
	return $protocolo.'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}

/* FUNCIONES PROPIAS DEL SISTEMA */
// Saber si un dia ingresado es domingo o no
function fncEsDomingo($fecha=""){ // fecha -> DIA - MES - A�O
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha)){ list($dia,$mes,$anio) = explode("/", $fecha); }
	    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha)){ list($dia,$mes,$anio) = explode("-",$fecha); }
		$timestamp = mktime(0,0,0,$mes,$dia,$anio);
		$diaDeLaSemana = strftime("%A",$timestamp); //Obtenemos el nombre del d�a de la semana en espa�ol
		if($diaDeLaSemana == "domingo"){
			$finDeSemana = true;
		}else{
			$finDeSemana = false;
		}
		return $finDeSemana;
	}
}
// Cantidad de dias a sumar dependiendo el periodo ingresado
function fncDiasASumar($periodo){
	switch($periodo){
		case "Diario": $dias=1; break;
		case "Semanal": $dias=7; break;
		case "Quincenal": $dias=15; break;
		case "Mensual": $dias=30; break;
		case "Bimestral": $dias=60; break;
		case "Trimestral": $dias=90; break;
	}
	return $dias;
}
// Sumar dias a una fecha
function fncSumaDiasFecha($fecha="",$dia_=0){ // fecha -> DIA - MES - A�O
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha)){ list($dia,$mes,$anio) = explode("/", $fecha); }
	    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha)){ list($dia,$mes,$anio) = explode("-",$fecha); }
		return date('d-m-Y',mktime(0,0,0,$mes,$dia+$dia_,$anio));
	}
}
// Para convertir un numero entero a romano
function fncNumToRomano($num) {
	if ($num <0 || $num >9999) {return -1;}
	$r_ones = array(1=>"I", 2=>"II", 3=>"III", 4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII", 9=>"IX");
	$r_tens = array(1=>"X", 2=>"XX", 3=>"XXX", 4=>"XL", 5=>"L", 6=>"LX", 7=>"LXX", 8=>"LXXX", 9=>"XC");
	$r_hund = array(1=>"C", 2=>"CC", 3=>"CCC", 4=>"CD", 5=>"D", 6=>"DC", 7=>"DCC", 8=>"DCCC", 9=>"CM");
	$r_thou = array(1=>"M", 2=>"MM", 3=>"MMM", 4=>"MMMM", 5=>"MMMMM", 6=>"MMMMMM", 7=>"MMMMMMM", 8=>"MMMMMMMM", 9=>"MMMMMMMMM");
	$ones = $num % 10;
	$tens = ($num - $ones) % 100;
	$hundreds = ($num - $tens - $ones) % 1000;
	$thou = ($num - $hundreds - $tens - $ones) % 10000;
	$tens = $tens / 10;
	$hundreds = $hundreds / 100;
	$thou = $thou / 1000;
	if ($thou) {$rnum .= $r_thou[$thou];}
	if ($hundreds) {$rnum .= $r_hund[$hundreds];}
	if ($tens) {$rnum .= $r_tens[$tens];}
	if ($ones) {$rnum .= $r_ones[$ones];}
	return $rnum;
}
// Para contar las palabras de una cadena
function fncTotalPalabras($cadena=""){
	if(trim($cadena)<>""){
		$totalPalabras = sizeof(explode(" ", $cadena));
	}else{
		$totalPalabras = 0;
	}
	return $totalPalabras;
}
// Para OBTENER el IP del usuario entrante
function obtenerIP() {
   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "unknown" );

      $entries = explode('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
         {
            $private_ip = array(
                  '/^0\./',
                  '/^127\.0\.0\.1/',
                  '/^192\.168\..*/',
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                  '/^10\..*/');

            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "unknown" );
   }

   return $client_ip;
}
//_Obtener protocolo de mi pagina actual
function fncProtocoloUrlWeb(){
	if(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
		return $protocol = 'https://';
	}else{
		return $protocol = 'http://';
	}
}
//_Obtener el protocolo de una URL
function fncProtocoloUrl($url=""){
	$protocolo = "";
	if(trim($url)<>""){
		if(strpos($url,"//")!==false){
			list($protocolo,$extra) = explode("//",$url);
		}
	}
	return $protocolo;
}
//error de header - prueba
function redirect($filename) {
    if (!headers_sent())
        header('Location: '.$filename);
    else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$filename.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
        echo '</noscript>';
    }
}
?>
