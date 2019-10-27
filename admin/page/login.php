<?php
	if (!isset($_SESSION)){ @session_start(); }
	$system_nivel_prof="../../admin/";
	require_once("../clases/cls.login.php");
	require_once("../funciones/funciones.php");
	$estado = cls_login::seguridad();
	if(trim($estado)<>"" && trim($estado)=="1"){ header("Location: ../page/index.php"); }
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once("_header.php"); ?>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-b-160 p-t-50">
				<form class="login100-form validate-form" method="post" action="../scripts/sesion.php">
					<span class="login100-form-title p-b-43">
						Login
					</span>

					<div class="wrap-input100 rs1 validate-input" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Usuario">
					</div>


					<div class="wrap-input100 rs2 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="pass" placeholder="Contraseña">
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Ingresar
						</button>
					</div>

					<div class="text-center w-full p-t-23">
						<a href="#" class="txt1">
							¿Olvidó su contraseña?
						</a>
					</div>
					<input type="hidden" name="MM_validar" value="frm_login">
				</form>
			</div>
		</div>
	</div>

</body>
</html>
