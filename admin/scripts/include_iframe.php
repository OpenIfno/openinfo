<?php
	if (!isset($_SESSION)){ @session_start(); }
	require_once("../seguridad/seguridad_iframe.php");
	require_once("../seguridad/permiso_iframe.php");
	require_once("../funciones/funciones.php");
	require_once("../clases/cls.control.php");
	require_once("../clases/cls.login.php");
	require_once("../clases/cls.sistema.php");
?>