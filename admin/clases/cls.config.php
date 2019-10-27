<?php
class cls_config{
	private $vars;
	private static $_oSelf = NULL;
  //_Para el constructor
	private function __construct(){
		$this->vars = array();
	}
  //_Para evaluar si la instancia esta abierta
    public static function get_config(){
        if( !self::$_oSelf instanceof self ){
            self::$_oSelf = new self();
        }
        return self::$_oSelf;
    }
  //_Con SET vamos guardando nuestras variables --------------> [dbServer]=localhost
	public function set($name,$value){
		if(!isset($this->vars[$name])){
			$this->vars[$name]=$value;
		}
	}
  //_Con GET 'nombre_de_la_variable' recuperamos un valor ----> [dbServer]
	public function get($name){
		if(isset($this->vars[$name])){
			return $this->vars[$name];
		}
	}
}
?>