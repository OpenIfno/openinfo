<?php
if(!isset($_SESSION)){ @session_start(); }
require_once($system_nivel_prof."lib/conex.php");
class cls_control{
	private $_oLinkId; 
	private $_sServidor;
	private $_sNombreBD;
	private $_sPort;
	private $_sUsuario;
	private $_sClave;
	private $_sMensaje="";
	private $query;
	private $identificador;
	public  $nroregistros=0;
	private $recordset=false;
	private $array;
	private static $_oSelf = NULL;
 //_Evitamos el clonaje del objeto
	private function __clone(){
		trigger_error('Esta clase no puede clonarse', E_USER_ERROR);
	}
 //_Constructor
	private function __construct(){
		$_oConfig = cls_config::get_config();
		$this->_sServidor = $_oConfig->get("dbServer");
		$this->_sNombreBD = $_oConfig->get("dbBase");
		$this->_sPort = $_oConfig->get("dbPort");
		$this->_sUsuario = $_oConfig->get("dbUser");
		$this->_sClave = $_oConfig->get("dbPwd");
		$this->_sMensaje = "";
		$this->conectar();
    }
 //_Para evaluar si la conexion esta abierta
    public static function get_instancia(){
        if( !self::$_oSelf instanceof self ){
            self::$_oSelf = new self();
        }
        return self::$_oSelf;
    }
 //_Para conectarse a la BASE DE DATOS
    private function conectar(){
		$strconn = "'".$this->_sServidor."',";
		$strconn.= "'".$this->_sUsuario."',";
		$strconn.= "'".$this->_sClave."',";
		$strconn.= "'".$this->_sNombreBD."'";
        $conn = mysqli_connect("$this->_sServidor","$this->_sUsuario","$this->_sClave","$this->_sNombreBD");
        if(!$conn){
            $this->_sMensaje = "ERROR: No se puede conectar a la base de datos..! ".$this->_sNombreBD;
            throw new Exception($this->_sMensaje);
            die;
		}
		$this->_oLinkId = $conn;
        return true;
    }
 //_Para obtener el ID de conexion
  	public function get_link_id(){ return $this->_oLinkId; }
 //_Para obtener el mensaje de la conexion
  	public function get_mensaje(){ return $this->_sMensaje; }
 //_Para obtener a QUERY a ejecutar
	public function get_query(){ return $this->query; }
 //_Para ejecutar una sentencia SQL
	public function consulta($consul=""){
		$rs = 0;
		if(trim($consul)<>""){
			$this->query = $consul;
			$this->identificador = $this->get_link_id();
			$this->recordset = mysqli_query($this->identificador,$this->query);
			if($this->recordset==true){
				$this->nroregistros = $this->totalRegistros($consul);
				if($this->nroregistros > 0){
					$rs = $this->recordset;
				}
			}
		}else{
			$this->nroregistros = 0;
		}
		return $rs;
	}
 //_Para obtener el numero de registros de una consulta	
	public function totalRegistros($consul=""){
		if(trim($consul)<>""){
			$this->query = $consul;
			$this->identificador = $this->get_link_id();
			$this->recordset = mysqli_query($this->identificador,$this->query);
			if($this->recordset<>false){ $this->nroregistros = mysqli_num_rows($this->recordset); }
			else{ $this->nroregistros = 0; }
		}else{
			$this->nroregistros = 0;
		}
		return($this->nroregistros);
	}
 //_Para el Mantenimiento de un registro (Agregar, Editar, Eliminar)
	public function mantto($consul=""){
		if(trim($consul)<>""){
			$this->query = $consul;
			$this->identificador = $this->get_link_id();
			$this->recordset = mysqli_query($this->identificador,$this->query)or die($this->query);
			if(!$this->recordset){
			   $rs = false;
			}else{
			   $rs = true;
			}
			//mysqli_free_result($this->recordset);
		}else{ $rs = false; }
		return $rs;
	}
 //_Para filtrar el metodo de presentacion de los resultados
   	public function obtener_cursor($stmt){
   		$this->array = mysqli_fetch_assoc($stmt);
   		return $this->array;
   	}
}
?>