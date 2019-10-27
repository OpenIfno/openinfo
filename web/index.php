<?php
//_Incluimos la configuracion de la pagina
require_once("includes/_config.php");
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="zxx">
<!--<![endif]-->
<?php
require_once("includes/_head.php");
?>
<body>
<?php
require_once("includes/_header.php");
require_once("includes/_nav.php");
require_once("includes/_slider.php");
require_once("includes/_about.php");
require_once("includes/_caract.php");
require_once("includes/_events.php");
require_once("includes/_gallery.php"); //Falta módulo completo de galeria
require_once("includes/_team.php");
require_once("includes/_blog.php");
require_once("includes/_contact.php"); //falta agregar API Google Maps

require_once("includes/_footer.php");
require_once("includes/_load.php");
?>
</body>
</html>
