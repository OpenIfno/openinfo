/* VALIDACION DEL ADMINISTRADOR GENERAL ************************************************************************************/
//_Validar: RECUPERAR CLAVE DE INGRESO --------------------------------------
function fncValidarRecuperarClave(frm){
	try{
		var email = trim(frm.email.value);
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(email==""){ alert(msg+"- No ingreso su E-mail."); frm.email.value=''; frm.email.focus(); return false; }
		else{
			var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
			if(filter.test(email)==false){
				alert(msg+="- El E-MAIL ingresado no es correcto."); frm.email.focus(); return false;
			}else{
				if(jQuery("#spinner").length>0){ jQuery("#spinner img").show(); }
				var params = jQuery("#"+frm.id).serializeArray();
				jQuery.post("../restaurar/validar.php", params, function(data){
					if(jQuery("#spinner").length>0){ jQuery("#spinner img").hide(); }
					if(data.length>0){
						if(data=="existe"){
							alert("Revice su bandeja de entrada (E-mail) para continuar con la restauracion."); 
							frm.reset(); jQuery("#modal-restaurar").modal('hide');
						}else{
							switch(data){
								case "envio": alert(msg+="- Se produjo un error en el envio de su restauracion."); break;
								case "estado": alert(msg+="- El E-mail ingresado no se encuentra activo."); frm.reset(); jQuery("#modal-restaurar").modal('hide'); break;
								case "error": alert(msg+="- El E-mail ingresado no es correcto."); frm.email.focus(); break;
								case "vacio": alert(msg+"- No ingreso su E-mail."); frm.email.value=''; frm.email.focus(); break;
								default: alert(msg+="- El E-mail ingresado no se encuentra registrado."); frm.email.select(); break;
							}
						}
					}else{
						alert(msg+="- Se produjo un error en la verificacion de su cuenta\nIntentelo de nuevo."); frm.email.focus();
					}
				});
			}
		}
	}catch(ex){
		alert(ex.description);
	}
	return false;
}
//_Validar: MI CUENTA -------------------------------------------------------
function fncValidarCuentaUsuario(frm){
	try{
		var nombre = trim(frm.nombre.value);
		var email = trim(frm.email.value);
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(nombre==""){ alert(msg+"- No ingreso el NOMBRE del usuario."); frm.nombre.value=''; frm.nombre.focus(); return false; }
		if(email==""){ alert(msg+"- No ingreso su E-MAIL del usuario."); frm.email.value=''; frm.email.focus(); return false; }
		else{
			var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
			if(filter.test(email)==false){
				alert(msg+="- El E-MAIL ingresado no es correcto."); frm.email.focus(); return false;
			}	
		}
		if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
	}catch(ex){
		alert(ex.description); return false;
	}
}
//_Validar: CAMBIAR CLAVE USUARIO ACTUAL ------------------------------------
function fncValidarClaveUsuario(frm){
	try{
		var clave = trim(frm.clave_antes.value);
		var clave_new = trim(frm.clave_new.value);
		var clave_renew = trim(frm.clave_renew.value);
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(clave==""){ alert(msg+"- No ingreso la CLAVE ANTERIOR."); frm.clave_antes.value=''; frm.clave_antes.focus(); return false; }
		if(clave_new==""){ alert(msg+"- No ingreso la NUEVA CLAVE."); frm.clave_new.value=''; frm.clave_new.focus(); return false; }
		if(clave_renew==""){ alert(msg+"- No ingreso la REPETICION DE LA NUEVA CLAVE."); frm.clave_renew.value=''; frm.clave_renew.focus(); return false; }
		if(clave_new!=clave_renew){ alert(msg+"- Las CLAVES NUEVAS ingresadas no coinciden."); frm.clave_new.select(); return false; }
		jQuery.post("../page/clave_validar.php", { clave:clave }, function(data){
			if(data.length>0){
				if(data=="correcto"){
					if(confirm("\xbfEst\xe1 seguro de CAMBIAR su clave de acceso?")){ frm.submit(); }else{ return false; }
				}else{
					if(data=="incorrecto"){
						alert(msg+"- La CLAVE ANTERIOR ingresada no coincide con su cuenta de usuario."); frm.clave_antes.select(); return false;
					}else{
						alert(msg+"- No ingreso la CLAVE ANTERIOR."); frm.clave_antes.value=''; frm.clave_antes.focus(); return false;
					}
				}
			}
		});
	}catch(ex){
		alert(ex.description);
	}
	return false;
}
//_Validar: MODULOS ---------------------------------------------------------
function fncValidarModulo(frm){
	try{
		var nombre = trim(frm.nombre.value);
		var tipo = trim(frm.tipo.value);
		var orden = trim(frm.orden.value);
		var web_menu = trim(frm.web_menu.value);
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(nombre==""){ alert(msg+"- No ingreso el NOMBRE de la aplicacion."); frm.nombre.value=''; frm.nombre.focus(); return false; }
		if(tipo!="1"){ //--> Aplicacion
			var carpeta = trim(frm.carpeta.value);
			var archivo = trim(frm.archivo.value);
			var mantto = trim(frm.mantto.value);
			var clase = trim(frm.clase.value);
			if(tipo=="2" || tipo=="3"){ //--> Modulo o Funcion
				if(carpeta==""){ alert(msg+"- No ingreso la CARPETA de la aplicacion."); frm.carpeta.value=''; frm.carpeta.focus(); return false; }
				if(archivo==""){ alert(msg+"- No ingreso el ARCHIVO de la aplicacion."); frm.archivo.value=''; frm.archivo.focus(); return false; }
				if(tipo=="2"){ //--> Modulo
					if(clase==""){ alert(msg+"- No ingreso la CLASE de la aplicacion."); frm.clase.value=''; frm.clase.focus(); return false; }
				}
			}
		}
		if(orden==""){ alert(msg+"- No ingreso el ORDEN de la aplicacion"); frm.orden.value=''; frm.orden.focus(); return false; }
		else{
			if(IsNumeric(orden)==false){ alert(msg+"- El ORDEN ingresado es erroneo."); frm.orden.select(); return false; }
		}
		if(web_menu=="si"){
			var url = trim(frm.url.value);
			if(url==""){ alert(msg+"- No ingreso el URL de la aplicacion en el MENU WEB."); frm.url.value=''; frm.url.focus(); return false; }
		}
		if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
	}catch(ex){
		alert(ex.description); return false;
	}
}
//_Validar: ROLES -----------------------------------------------------------
function fncValidarRol(frm){
	try{
		var nombre = trim(frm.nombre.value);
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(nombre==""){ alert(msg+"- No ingreso el NOMBRE del rol."); frm.nombre.value=''; frm.nombre.focus(); return false; }
		if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
	}catch(ex){
		alert(ex.description); return false;
	}
}
//_Validar: ROLES - APLICACIONES POR ROL ------------------------------------
function fncValidarRolAplicacion(frm){
	try{
		if(confirm("\xbfEst\xe1 seguro de almacenar las aplicaciones seleccionadas?")){ return true; }else{ return false; }
	}catch(ex){
		alert(ex.description); return false;
	}
}
//_Validar: USUARIOS --------------------------------------------------------
function fncValidarUsuario(frm){
	try{
		var nombre = trim(frm.nombre.value);
		var foto = trim(frm.foto.value);
		var email = trim(frm.email.value);
		var task = trim(frm.task.value);
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(nombre==""){ alert(msg+"- No ingreso el NOMBRE del usuario."); frm.nombre.value=''; frm.nombre.focus(); return false; }
		if(foto!=""){
			if(!verificar_imagen(foto)){
				alert(msg+"- La imagen elegida tiene una extension no permitida."); frm.foto.focus(); return false;
			}	
		}
		if(email!=""){
			var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
			if(filter.test(email)==false){
				alert(msg+="- El CORREO ELECTRONICO no es correcto."); frm.email.focus(); return false;
			}	
		}
		if(task=="new"){
			var usuario = trim(frm.usuario.value);
			var clave = trim(frm.clave.value);
			var carpeta = trim(frm.carpeta.value);
			if(usuario==""){ alert(msg+"- No ingreso el USUARIO."); frm.usuario.value=''; frm.usuario.focus(); return false; }
			else{
				if(/\s/.test(usuario)){ alert(msg+="- El campo USUARIO no debe tener espacios en blanco."); frm.usuario.select(); return false; }
				else{
					jQuery.post("../"+carpeta+"/usu_login.php", { usuario:usuario }, function(data){
						if(data.length>0){
							if(data=="libre"){
								if(clave==""){ alert(msg+"- No ingreso la CLAVE."); frm.clave.value=''; frm.clave.focus(); return false; }
								else{ if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ frm.submit(); }else{ return false; } }
							}else{
								if(data=="ocupado"){
									alert(msg+"- El USUARIO ingresado ya se encuentra registrado."); frm.usuario.select(); return false;
								}else{
									alert(msg+"- No ingreso el USUARIO."); frm.usuario.value=''; frm.usuario.focus(); return false;
								}
							}
						}
					});
				}
				return false;
			}
		}else{
			if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
		}
	}catch(ex){
		alert(ex.description); return false;
	}
}
//_Validar: USUARIOS - CAMBIO DE CLAVE --------------------------------------
function fncValidarUsuarioClave(frm){
	try{
		var clave = trim(frm.clave.value);
		var reclave = trim(frm.reclave.value);
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(clave==""){ alert(msg+"- No ingreso la NUEVA CLAVE."); frm.clave.value=''; frm.clave.focus(); return false; }
		if(reclave==""){ alert(msg+"- No ingreso la REPETICION DE LA NUEVA CLAVE."); frm.reclave.value=''; frm.reclave.focus(); return false; }
		if(clave!=reclave){ alert(msg+"- Las CLAVES ingresadas no coinciden."); frm.clave.select(); return false; }
		if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
	}catch(ex){
		alert(ex.description); return false;
	}
}
//_Validar: USUARIOS - ROLES POR USUARIO ------------------------------------
function fncValidarRolUsuario(frm){
	try{
		if(confirm("\xbfEst\xe1 seguro de almacenar las aplicaciones seleccionadas?")){ return true; }else{ return false; }
	}catch(ex){
		alert(ex.description); return false;
	}
}
//_Validar: NOTIFICACIONES --------------------------------------------------
function fncValidarNotificacion(frm){
	try{
		var titulo = trim(frm.titulo.value);
		var tipo = trim(frm.tipo.value);
		var descrip = trim(frm.descrip.value);
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(titulo==""){ alert(msg+"- No ingreso el TITULO de la notificacion."); frm.titulo.value=''; frm.titulo.focus(); return false; }
		if(tipo=="2"){
			var fch_ini = trim(frm.fch_ini.value);
			var fch_fin = trim(frm.fch_fin.value);
			if(fch_ini==""){ alert(msg+"- No ingreso la FECHA INICIO de la notificacion."); frm.fch_ini.value=''; frm.fch_ini.focus(); return false; }
			else{
				if(!fncValidarFecha(fch_ini)){ alert(msg+"- La FECHA INICIO ingresada es erronea."); return false; }
			}
			if(fch_fin==""){ alert(msg+"- No ingreso la FECHA INICIO de la notificacion."); frm.fch_fin.value=''; frm.fch_fin.focus(); return false; }
			else{
				if(!fncValidarFecha(fch_fin)){ alert(msg+"- La FECHA FIN ingresada es erronea."); return false; }
			}
		}
		if(descrip==""){ alert(msg+"- No ingreso la DESCRIPCION de la notificacion."); return false; }
		if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
	}catch(ex){
		alert(ex.description); return false;
	}
}
//_Validar: RED SOCIAL ------------------------------------------------------
function fncValidarSmm(frm){
	var tipo = trim(frm.tipo.value);
	var url = trim(frm.url.value);
	var orden = trim(frm.orden.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(tipo==""){ alert(msg+"- No eligio la RED SOCIAL."); frm.tipo.focus(); return false; }
	if(url==""){ alert(msg+"- No ingreso el URL de la red social."); frm.url.value=''; frm.url.focus(); return false; }
	if(orden==""){ alert(msg+"- No ingreso el ORDEN de la red social."); frm.orden.value=''; frm.orden.focus(); return false; }
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: ACTA DE CREACIÓN ------------------------------------------------
function fncValidarIlaHistoria(frm){
	var acta = trim(frm.descrip.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(acta==""){alert(msg+"- No se ha registrado el Acta.");frm.descrip.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_validar: UBICACION -------------------------------------------------------
function fncValidarIlaUbicacion(frm){
	var ubicacion = trim (frm.descrip.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(ubicacion==""){alert(msg+"- No se ha registrado la Ubicación.");frm.descrip.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: POBLACION -------------------------------------------------------
function fncValidarIlaPoblacion(frm){
	var poblacion = trim(frm.descrip.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(poblacion==""){alert(msg+"- No se ha registrado la Población.");frm.descrip.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Turismo ---------------------------------------------------------
function fncValidarIlaTurismo(frm){
	var nombre = trim(frm.nombre.value);
	var detalle = trim(frm.detalle.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha registrado un nombre para este Lugar.");frm.nombre.focus();return false;}
	if(detalle==""){alert(msg+"- No se ha registrado una descripción para este Lugar.");frm.detalle.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Detalle de Lugar -----------------------------------------------
function fncValidarIlaTurismoImg(frm){
	var nombre = trim(frm.nombre.value);
	var orden = trim(frm.orden.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha registrado un nombre para este Lugar.");frm.nombre.focus();return false;}
	var comp = parseInt(orden);
	if(comp != orden || comp.toString() != orden.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.orden.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarIlaRecursos(frm){
	var recurso = trim(frm.descrip.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(recurso==""){alert(msg+"- No se ha registrado contenido para la Página.");frm.descrip.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarIlaHidrografia(frm){
	var recurso = trim(frm.descrip.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(recurso==""){alert(msg+"- No se ha registrado contenido para la Página.");frm.descrip.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarMunInstitucion(frm){
	var recurso = trim(frm.descrip.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(recurso==""){alert(msg+"- No se ha registrado contenido para la Página.");frm.descrip.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarMunVision(frm){
	var recurso = trim(frm.descrip.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(recurso==""){alert(msg+"- No se ha registrado contenido para la Página.");frm.descrip.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarMunAlcalde(frm){
	var recurso = trim(frm.descrip.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(recurso==""){alert(msg+"- No se ha registrado contenido para la Página.");frm.descrip.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Concejo Municipal
function fncValidarMunConcejo(frm){
	var imagen = trim(frm.imagen.value);
	var nombre = trim(frm.nombre.value);
	var tipo = trim(frm.tipo.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(tipo==""){alert(msg+"- No se ha colocado un tipo en el Formulario.");frm.tipo.focus();return false;}
	if(imagen==""){alert(msg+"- No se ha colocado una imagen en el Formulario.");frm.imagen.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }	
}
//_Validar: Organigrama -----------------------------------------------------
function fncValidarMunOrganigrama(frm){
	var imagen = trim(frm.imagen.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(imagen==""){alert(msg+"- No se ha colocado una imagen en el Formulario.");frm.imagen.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }	
}
//_Validar: Directorio Municipal --------------------------------------------
function fncValidarMunDirectorio(frm){
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Obras -----------------------------------------------------------
function fncValidarObrEjecucion(frm){
	var nombre = trim(frm.nombre.value);
	var resol = trim(frm.resolucion.value);
	var orden = trim(frm.orden.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	var comp = parseInt(orden);
	if(comp != orden || comp.toString() != orden.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.orden.focus();return false;}
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(resol==""){alert(msg+"- No se ha colocado la Resolución de la obra.");frm.resolucion.focus();return false;}
	var fch_ini = trim(frm.fchini.value);
	var fch_fin = trim(frm.fchfin.value);
	if(fch_ini==""){ alert(msg+"- No ingreso la FECHA INICIO de la notificacion."); frm.fchini.value=''; frm.fchini.focus(); return false; }
	else{
		if(!fncValidarFecha(fch_ini)){ alert(msg+"- La FECHA INICIO ingresada es erronea."); return false; }
	}
	if(fch_fin==""){ alert(msg+"- No ingreso la FECHA INICIO de la notificacion."); frm.fchfin.value=''; frm.fchfin.focus(); return false; }
	else{
		if(!fncValidarFecha(fch_fin)){ alert(msg+"- La FECHA FIN ingresada es erronea."); return false; }
	}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarObrEjecutadas(frm){
	var nombre = trim(frm.nombre.value);
	var resol = trim(frm.resolucion.value);
	var orden = trim(frm.orden.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	var comp = parseInt(orden);
	if(comp != orden || comp.toString() != orden.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.orden.focus();return false;}
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(resol==""){alert(msg+"- No se ha colocado la Resolución de la obra.");frm.resolucion.focus();return false;}
	var fch_ini = trim(frm.fchini.value);
	var fch_fin = trim(frm.fchfin.value);
	if(fch_ini==""){ alert(msg+"- No ingreso la FECHA INICIO de la notificacion."); frm.fchini.value=''; frm.fchini.focus(); return false; }
	else{
		if(!fncValidarFecha(fch_ini)){ alert(msg+"- La FECHA INICIO ingresada es erronea."); return false; }
	}
	if(fch_fin==""){ alert(msg+"- No ingreso la FECHA INICIO de la notificacion."); frm.fchfin.value=''; frm.fchfin.focus(); return false; }
	else{
		if(!fncValidarFecha(fch_fin)){ alert(msg+"- La FECHA FIN ingresada es erronea."); return false; }
	}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarObrMantto(frm){
	var nombre = trim(frm.nombre.value);
	var resol = trim(frm.resolucion.value);
	var orden = trim(frm.orden.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	var comp = parseInt(orden);
	if(comp != orden || comp.toString() != orden.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.orden.focus();return false;}
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(resol==""){alert(msg+"- No se ha colocado la Resolución de la obra.");frm.resolucion.focus();return false;}
	var fch_ini = trim(frm.fchini.value);
	var fch_fin = trim(frm.fchfin.value);
	if(fch_ini==""){ alert(msg+"- No ingreso la FECHA INICIO de la notificacion."); frm.fchini.value=''; frm.fchini.focus(); return false; }
	else{
		if(!fncValidarFecha(fch_ini)){ alert(msg+"- La FECHA INICIO ingresada es erronea."); return false; }
	}
	if(fch_fin==""){ alert(msg+"- No ingreso la FECHA INICIO de la notificacion."); frm.fchfin.value=''; frm.fchfin.focus(); return false; }
	else{
		if(!fncValidarFecha(fch_fin)){ alert(msg+"- La FECHA FIN ingresada es erronea."); return false; }
	}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarObrRestablecida(frm){
	var nombre = trim(frm.nombre.value);
	var resol = trim(frm.resolucion.value);
	var orden = trim(frm.orden.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	var comp = parseInt(orden);
	if(comp != orden || comp.toString() != orden.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.orden.focus();return false;}
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(resol==""){alert(msg+"- No se ha colocado la Resolución de la obra.");frm.resolucion.focus();return false;}
	var fch_ini = trim(frm.fchini.value);
	var fch_fin = trim(frm.fchfin.value);
	if(fch_ini==""){ alert(msg+"- No ingreso la FECHA INICIO de la notificacion."); frm.fchini.value=''; frm.fchini.focus(); return false; }
	else{
		if(!fncValidarFecha(fch_ini)){ alert(msg+"- La FECHA INICIO ingresada es erronea."); return false; }
	}
	if(fch_fin==""){ alert(msg+"- No ingreso la FECHA INICIO de la notificacion."); frm.fchfin.value=''; frm.fchfin.focus(); return false; }
	else{
		if(!fncValidarFecha(fch_fin)){ alert(msg+"- La FECHA FIN ingresada es erronea."); return false; }
	}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Proyectos -------------------------------------------------------
function fncValidarProyInversion(frm){
	var nombre = trim(frm.nombre.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarProySocial(frm){
	var nombre = trim(frm.nombre.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarProyecto(frm){
	var nombre = trim(frm.nombre.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Servicios -------------------------------------------------------
function fncValidarServicio(frm){
	var task = trim(frm.task.value);
	var nombre = trim(frm.nombre.value);
	var icon = trim(frm.imagen.value);
	var orden = trim(frm.orden.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	var comp = parseInt(orden);
	if(comp != orden || comp.toString() != orden.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.orden.focus();return false;}
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(task=="new"){
		if(icon==""){alert(msg+"- No se ha designado un ícono para el Servicio.");frm.imagen.focus();return false;}
	}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarServicioCat(frm){
	var nombre = trim(frm.nombre.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarServicioCatArchivo(frm){
	var nombre = trim(frm.nombre.value);
	var archivo = trim(frm.archivo.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(archivo==""){alert(msg+"- No se ha seleccionado ningún archivo en el Formulario.");frm.archivo.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarServicioCatRecurso(frm){
	var titulo = trim(frm.titulo.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(titulo==""){alert(msg+"- No se ha colocado un título en el Formulario.");frm.titulo.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: transparencia ---------------------------------------------------
function fncValidarTraPia(frm){
	var archivo = trim(frm.archivo.value);
	var nombre = trim(frm.nombre.value);
	var anio = trim(frm.anio.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(archivo==""){alert(msg+"- No se ha seleccionado ningún archivo en el Formulario.");frm.archivo.focus();return false;}
	var cant = parseInt(anio);
	if(cant != anio || cant.toString() != anio.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.anio.focus();return false;}
	if(cant<2014||cant>2020){alert(msg+"- El año no es válido para ser ingresado.");frm.anio.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarTraPim(frm){
	var archivo = trim(frm.archivo.value);
	var nombre = trim(frm.nombre.value);
	var anio = trim(frm.anio.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(archivo==""){alert(msg+"- No se ha seleccionado ningún archivo en el Formulario.");frm.archivo.focus();return false;}
	var cant = parseInt(anio);
	if(cant != anio || cant.toString() != anio.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.anio.focus();return false;}
	if(cant<2014||cant>2020){alert(msg+"- El año no es válido para ser ingresado.");frm.anio.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarTraPie(frm){
	var archivo = trim(frm.archivo.value);
	var nombre = trim(frm.nombre.value);
	var anio = trim(frm.anio.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(archivo==""){alert(msg+"- No se ha seleccionado ningún archivo en el Formulario.");frm.archivo.focus();return false;}
	var cant = parseInt(anio);
	if(cant != anio || cant.toString() != anio.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.anio.focus();return false;}
	if(cant<2014||cant>2020){alert(msg+"- El año no es válido para ser ingresado.");frm.anio.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarTraEga(frm){
	var archivo = trim(frm.archivo.value);
	var nombre = trim(frm.nombre.value);
	var anio = trim(frm.anio.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(archivo==""){alert(msg+"- No se ha seleccionado ningún archivo en el Formulario.");frm.archivo.focus();return false;}
	var cant = parseInt(anio);
	if(cant != anio || cant.toString() != anio.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.anio.focus();return false;}
	if(cant<2014||cant>2020){alert(msg+"- El año no es válido para ser ingresado.");frm.anio.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarTraPoi(frm){
	var archivo = trim(frm.archivo.value);
	var nombre = trim(frm.nombre.value);
	var anio = trim(frm.anio.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(archivo==""){alert(msg+"- No se ha seleccionado ningún archivo en el Formulario.");frm.archivo.focus();return false;}
	var cant = parseInt(anio);
	if(cant != anio || cant.toString() != anio.toString()){alert(msg+"- El año debe ser un Número Entero.");frm.anio.focus();return false;}
	if(cant<2014||cant>2020){alert(msg+"- El año no es válido para ser ingresado.");frm.anio.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarTraDocInstitucional(frm){
	var num = trim(frm.num.value);
	var fch_rec = trim(frm.fchrcp.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(num==""){alert(msg+"- No se ha colocado el número de la resolución.");frm.num.focus();return false;}
	if(fch_rec==""){alert(msg+"- No se ha registrado una fecha de recepción del documento.");frm.fchrcp.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarTraConvocatoria(frm){
	var nombre = trim(frm.nombre.value);
	var fch_ini = trim(frm.fecha.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(fch_ini==""){alert(msg+"- No se ha registrado una fecha de inicio de la convocatoria.");frm.fecha.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
function fncValidarTraAgenda(frm){
	var act = trim(frm.titulo.value);
	var fecha = trim(frm.fecha.value);
	var hora = trim(frm.hora.value);
	var lugar = trim(frm.lugar.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(act==""){alert(msg+"- No se ha colocado un nombre a la Actividad.");frm.titulo.focus();return false;}
	if(fecha==""){alert(msg+"- No se ha registrado una fecha para la Actividad.");frm.fecha.focus();return false;}
	if(fncValidarFecha(fecha)==false){alert(msg+"- La fecha no tiene un formato correcto.");frm.fecha.focus();return false;}
	if(hora==""){alert(msg+"- No se ha registrado una hora para la Actividad.");frm.hora.focus();return false;}
	if(lugar==""){alert(msg+"- No se ha registrado un lugar para la Actividad.");frm.lugar.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Contacto --------------------------------------------------------
function fncValidarContacto(frm){
	
	var descrip = trim(frm.descrip.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	
	if(descrip==""){alert(msg+"- No se ha registrado contenido para esta página.");frm.hora.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Buzón -----------------------------------------------------------
function fncValidarBuzon(frm){
	var descrip = trim(frm.descrip.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	
	if(descrip==""){alert(msg+"- No se ha registrado contenido para esta página.");frm.hora.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: FAQ -------------------------------------------------------------
function fncValidarFaqPregunta(frm){
	var preg = trim(frm.pregunta.value);
	var resp = trim(frm.respuesta.value);
	var orden = trim(frm.orden.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	var comp = parseInt(orden);
	if(comp != orden || comp.toString() != orden.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.orden.focus();return false;}
	if(preg==""){alert(msg+"- No se ha registrado ninguna pregunta.");frm.pregunta.focus();return false;}
	if(resp==""){alert(msg+"- No se ha registrado la respuesta.");frm.respuesta.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Atención de Reclamos --------------------------------------------
function fncValidarRecAtencion(frm){
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: SOS -------------------------------------------------------------
function fncValidarSos(frm){
	var imagen = trim(frm.imagen.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(imagen==""){alert(msg+"- No se ha colocado una imagen en el Formulario.");frm.imagen.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: CATEGORIA PPO ---------------------------------------------------
function fncValidarTraCategoria(frm){
	var nombre = trim(frm.nombre.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Documento participativo -----------------------------------------
function fncValidarTraCatDocumento(frm){
	var archivo = trim(frm.archivo.value);
	var nombre = trim(frm.nombre.value);
	var anio = trim(frm.anio.value);
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(archivo==""){alert(msg+"- No se ha seleccionado ningún documento para su publicación.");frm.archivo.focus();return false;}
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	var cant = parseInt(anio);
	if(cant != anio || cant.toString() != anio.toString()){alert(msg+"- El año debe ser un Número Entero.");frm.anio.focus();return false;}
	if(cant<2000||cant>2020){alert(msg+"- El año no es válido para ser ingresado.");frm.anio.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
//_Validar: Publicidad -------------------------------------------------------
function fncValidarPublicidad(frm){
	var nombre = trim(frm.nombre.value);
	var enlace = trim(frm.enlace.value);
	var fch_ini = trim(frm.fchini.value);
	var fch_fin = trim(frm.fchfin.value);
	var orden = trim(frm.orden.value);
	var regex = /^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?$/i;
	var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
	if(nombre==""){alert(msg+"- No se ha colocado un nombre en el Formulario.");frm.nombre.focus();return false;}
	if(enlace!=""){
		if(!regex.test(enlace)){alert(msg+"- La URL de enlace ingresada, no es válida.");frm.enlace.focus();return false;}
	}
	if(fch_ini==""){ alert(msg+"- No ingreso la FECHA INICIO de la publicación."); frm.fchini.value=''; frm.fchini.focus(); return false; }
	else{
		if(!fncValidarFecha(fch_ini)){ alert(msg+"- La FECHA INICIO ingresada es erronea."); return false; }
	}
	if(fch_fin==""){ alert(msg+"- No ingreso la FECHA INICIO de la publicación."); frm.fchfin.value=''; frm.fchfin.focus(); return false; }
	else{
		if(!fncValidarFecha(fch_fin)){ alert(msg+"- La FECHA FIN ingresada es erronea."); return false; }
	}
	var comp = parseInt(orden);
	if(comp != orden || comp.toString() != orden.toString()){alert(msg+"- El orden debe ser un Número Entero.");frm.orden.focus();return false;}
	if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
}
/* VALIDACION DEL SISTEMA ***************************************************************************************************/
//_Validar: CONFIGURACION DE PAGINA WEB -------------------------------------
function fncValidarConfiguracion(frm){
	try{
		var titulo = trim(frm.titulo.value);
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(titulo==""){ alert(msg+"- Debe de ingresar al menos el TITULO de la pagina."); frm.titulo.value=''; frm.titulo.focus(); return false; }
		if(confirm("\xbfEst\xe1 seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
	}catch(ex){
		alert(ex.description); return false;
	}
}
//_Validar: NOTICIA ---------------------------------------------------------
function fncValidarNoticia(frm){
	try{
		var fch = trim(frm.fch.value);
		var imagen = trim(frm.imagen.value);
		var titulo = trim(frm.titulo.value);
		var resumen = trim(frm.resumen.value);
		var detalle = trim(frm.detalle.value);
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(imagen!=""){
			if(!verificar_imagen(imagen)){
				alert(msg+"- La imagen elegida tiene una extension no permitida."); frm.imagen.focus(); return false;	
			}	
		}
		if(fch==""){ alert(msg+"- No ingreso la FECHA"); frm.fch.value=''; frm.fch.focus(); return false; }
		if(titulo==""){ alert(msg+"- No ingreso el TITULO"); frm.titulo.value=''; frm.titulo.focus(); return false; }
		if(resumen==""){ alert(msg+"- No ingreso el RESUMEN"); frm.resumen.value=''; frm.resumen.focus(); return false; }
		if(detalle==""){ alert(msg+"- No ingreso el CONTENIDO de la noticia."); return false; }
		if(confirm("Esta seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
	}catch(ex){
		alert(ex.description); return false;
	}
}
//_Validar: NOTICIA DETALLE -------------------------------------------------
function fncValidarNoticiaDet(frm){
	try{
		var titulo = trim(frm.titulo.value);
		var tiprec = frm.tiprec.value;
		var msg = "OCURRIERON LOS SIGUIENTES ERRORES:\n\n";
		if(titulo==""){ alert(msg+"- No ingreso el TITULO"); frm.titulo.value=''; frm.titulo.focus(); return false; }
		switch(tiprec){
			case "1": //--> Imagen
				var imagen = trim(frm.imagen.value);
				if(imagen!=""){
					if(!verificar_imagen(imagen)){
						alert(msg+"- La imagen elegida tiene una extension no permitida."); frm.imagen.focus(); return false;	
					}	
				}
				break;
			case "2": //--> Audio
				var imagen = trim(frm.imagen.value);
				if(imagen!=""){
					if(!verificar_audio(imagen)){
						alert(msg+"- La imagen elegida tiene una extension no permitida."); frm.imagen.focus(); return false;	
					}	
				}
				break;
			case "3": //--> Video
				var recurso = trim(frm.recurso.value);
				if(recurso==""){ alert(msg+"- No ingreso el URL DEL VIDEO"); frm.recurso.value=''; frm.recurso.focus(); return false; }
				break;
		}
		if(confirm("Esta seguro de almacenar los datos ingresados?")){ return true; }else{ return false; }
	}catch(ex){
		alert(ex.description); return false;
	}
}

/* FUNCIONES VARIAS ********************************************************************************************************/
//_Validar CAMPO FECHA (dd-mm-aaaa) -----------------------------------------
function fncValidarFecha(Cadena){  
	var Fecha= new String(Cadena);   // Crea un string  
	var RealFecha= new Date();   // Para sacar la fecha de hoy  
	// Cadena Año  
	var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length));
	// Cadena Mes  
	var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")));
	// Cadena Día  
	var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")));
	
	// Valido el año  
	if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){  
		//alert('Año inválido')  
		return false;
	}  
	// Valido el Mes  
	if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){  
		//alert('Mes inválido')  
		return false;
	}  
	// Valido el Dia  
	if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){  
		//alert('Día inválido')  
		return false;
	}  
	if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {  
		if (Mes==2 && Dia > 28 || Dia>30) {  
			//alert('Día inválido')  
			return false;
		}  
	}  
	
	return true;
}
//_Validar CAMPO HORA -------------------------------------------------------
function fncValidarHora(hora){
	arrayHora = hora.split(":");
	if(arrayHora.length<2){
		alert("La HORA ingresada es erronea");
		return false;
	}
	hour = arrayHora[0];
	minute = arrayHora[1];
	if(IsNumeric(hour) && IsNumeric(minute)){
		if(hour < 0  || hour > 23) { 
		alert("La HORA debe estar entre 0 y 23 para formato militar"); 
		return false; 
		} 
		if(minute<0 || minute > 59) { 
			alert ("Los MINUTOS deben estar entre 0 y 59. "); 
			return false; 
		}
		return true;
	}else{
		alert("La HORA ingresada es erronea");
		return false;
	}
}
//_Validar IMAGEN -----------------------------------------------------------
function validarImagen(imagen){
	var permitida = verificar_imagen(imagen);
	if (permitida==false){
		var extensiones_permitidas = new Array(".gif",".jpg",".jpeg",".png"); 
		var errores = "";
		errores = errores + "- Solo se pueden trabajar archivos con extensiones: " + extensiones_permitidas.join();
		alert("OCURRIERON LOS SIGUIENTES ERRORES:\n\n"+errores);
	}
}
//_Verificar IMAGEN ---------------------------------------------------------
function verificar_imagen(imagen){
	var permitida = false;
	if(imagen!=""){
		var extensiones_permitidas = new Array(".gif",".jpg",".jpeg",".png"); 
		extension = (imagen.substring(imagen.lastIndexOf("."))).toLowerCase(); 
		permitida = false; 
		for (var i = 0; i < extensiones_permitidas.length; i++) { 
			if (extensiones_permitidas[i] == extension) { 
				permitida = true; 
				break; 
			} 
		}
	}
	return permitida;	
}
//_Validar ARCHIVO PDF ------------------------------------------------------
function validarArchivoPDF(archivo){
	var permitida = verificar_archivo_pdf(archivo);
	if (permitida==false){
		var extensiones_permitidas = new Array(".pdf",".doc",".docx"); 
		var errores = "";
		errores = errores + "- Solo se pueden trabajar archivos con extension: " + extensiones_permitidas.join();
		alert("OCURRIERON LOS SIGUIENTES ERRORES:\n\n"+errores);
	}
}
//_Verificar ARCHIVO PDF ----------------------------------------------------
function verificar_archivo_pdf(archivo){
	var permitida = false;
	if(archivo!=""){
		var extensiones_permitidas = new Array(".pdf",".doc",".docx");
		extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
		permitida = false; 
		for (var i = 0; i < extensiones_permitidas.length; i++) { 
			if (extensiones_permitidas[i] == extension) { 
				permitida = true; 
				break; 
			} 
		}
	}
	return permitida;	
}
//_Validar ARCHIVO XLS o XLSX -----------------------------------------------
function validarArchivoXLS(archivo){
	var permitida = verificar_archivo_xls(archivo);
	if (permitida==false){
		var extensiones_permitidas = new Array(".xls",".xlsx"); 
		var errores = "";
		errores = errores + "- Solo se pueden trabajar archivos con extension: " + extensiones_permitidas.join();
		alert("OCURRIERON LOS SIGUIENTES ERRORES:\n\n"+errores);
	}
}
//_Verificar ARCHIVO XLS o XLSX ---------------------------------------------
function verificar_archivo_xls(archivo){
	var permitida = false;
	if(archivo!=""){
		var extensiones_permitidas = new Array(".xls",".xlsx"); 
		extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
		permitida = false; 
		for (var i = 0; i < extensiones_permitidas.length; i++) { 
			if (extensiones_permitidas[i] == extension) { 
				permitida = true; 
				break; 
			} 
		}
	}
	return permitida;	
}
//_Validar AUDIO ------------------------------------------------------------
function validar_audio(archivo){
	var permitida = verificar_audio(archivo);
	if (permitida==false){
		var extensiones_permitidas = new Array(".mp3",".wav"); 
		var errores = "";
		errores = errores + "- Solo se pueden trabajar archivos con extension: " + extensiones_permitidas.join();
		alert("OCURRIERON LOS SIGUIENTES ERRORES:\n\n"+errores);
	}
}
//_Verificar AUDIO ----------------------------------------------------------
function verificar_audio(archivo){
	var permitida = false;
	if(archivo!=""){
		var extensiones_permitidas = new Array(".mp3",".wav"); 
		extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
		permitida = false; 
		for (var i = 0; i < extensiones_permitidas.length; i++) { 
			if (extensiones_permitidas[i] == extension) { 
				permitida = true; 
				break; 
			} 
		}
	}
	return permitida;	
}
//_Validar Recurso ----------------------------------------------------------
function validarRecurso(archivo){
	var permitida = verificar_recurso(archivo);
	if (permitida==false){
		var extensiones_permitidas = new Array(".gif",".jpg",".jpeg",".png",".mp3",".ogg",".wav",".mp4",".avi",".wmv"); 
		var errores = "";
		errores = errores + "- Solo se pueden trabajar archivos con extensiones: " + extensiones_permitidas.join();
		alert("OCURRIERON LOS SIGUIENTES ERRORES:\n\n"+errores);
	}
}
//_Verificar IMAGEN ---------------------------------------------------------
function verificar_recurso(recurso){
	var permitida = false;
	if(recurso!=""){
		var extensiones_permitidas = new Array(".gif",".jpg",".jpeg",".png",".mp3",".ogg",".wav",".mp4",".avi",".wmv"); 
		extension = (recurso.substring(recurso.lastIndexOf("."))).toLowerCase(); 
		permitida = false; 
		for (var i = 0; i < extensiones_permitidas.length; i++) { 
			if (extensiones_permitidas[i] == extension) { 
				permitida = true; 
				break; 
			} 
		}
	}
	return permitida;	
}
