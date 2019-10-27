<?php
class TraducirEntidad{
	public static function traducirAbreviacion($abreviacion){
		$retorno = $abreviacion;
		$traductor['FA'] = 'Familia';
		$traductor['FC'] = 'Familia Civil';
		$traductor['FP'] = 'Familia Infracción';
		$traductor['FT'] = 'Familia Tutelar';
		$traductor['CI'] = 'Civil';
		$traductor['CO'] = 'Comercial';
		$traductor['DC'] = 'Constitucional';
		$traductor['CA'] = 'Contencioso Administrativo';
		$traductor['PE'] = 'Penal';
		$traductor['LA'] = 'Laboral';
		if($traductor[$abreviacion] != ''){
			$retorno = $traductor[$abreviacion];
		}
		return $retorno;
	}	
}
?>