<?php
	if (!isset($_SESSION)){ @session_start(); }
	require_once("seguridad.php");
	require_once("permiso.php");
	require_once("../funciones/funciones.php");
	require_once("../clases/cls.control.php");
	require_once("../clases/cls.login.php");
	require_once("../clases/cls.sistema.php");
?>