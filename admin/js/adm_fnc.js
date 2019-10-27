//------------------------------------------------------------------------
// Variablea Globales
//------------------------------------------------------------------------
var nav4 = window.Event ? true : false;

// Listado de Funciones
function validarCerrarSesion(){
	var ht = document.getElementsByTagName("html");
	ht[0].style.filter = "progid:DXImageTransform.Microsoft.BasicImage(grayscale=1)";
	if(confirm("Realmente desea cerrar su sesion?")){
		ht[0].style.filter = "";
		return true;
	}else{
		ht[0].style.filter = "";
		return false;
	}
}
function marcarFila(marcado,fila,total){
	var auxCheck=0;
	for(i=1; i<=total; i++){		
		check="chk"+i;
		marcadoCheck = document.getElementById(check).checked;
		if(marcadoCheck==true) auxCheck++;
	}
	if(auxCheck==total) document.getElementById('chkGeneral').checked=true;
	else document.getElementById('chkGeneral').checked=false;
}
function marcarTodos(marcado,total){
	for(i=1; i<=total; i++){		
		check="chk"+i;
		fila="fila"+i;
		document.getElementById(check).checked=marcado;
	}
}
function eliminarUnRegistroIframeCargarCombo(urlDel,params_1,urlCombo,urlDest,params_2,combo){
	if(confirm("\xbfRealmente desea ELIMINAR este registro?")){
		jQuery.ajax({
			type: "POST",
			url: urlDel,
			data: params_1,
			dataType: "html",
			success: function(datos){
				if(datos=="si"){
					alert("Registro eliminado satisfactoriamente.");
				}else{
					alert("El registro no pudo ser eliminado.");
				}
				fncCargarComboIframe(urlCombo,urlDest,params_2,combo);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert ("error: "+textStatus);
			}
		});
	}
	return false;
}
function eliminarUnRegistroAjax(url,paramsDel,urlDest,paramsList,container){
	if(confirm("\xbfRealmente desea ELIMINAR este registro?")){
		$.ajax({
			type: "POST",
			url: url,
			data: paramsDel,
			dataType: "html",
			success: function(datos){
				if(datos=="si"){
					alert("Registro eliminado satisfactoriamente.");
					$.post(urlDest, paramsList, function(data){
						$("#"+container).html(data);
						fncDatatable();
						$("input:checkbox, input:radio, input:file").not('[data-no-uniform="true"],#uniform-is-ajax').uniform();
					});
				}else{
					alert("El registro no pudo ser eliminado.");
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert ("error: "+textStatus);
			}
		});
	}
	return false;
}
// Funcion para limpiar los espacios en blanco
function ltrim(s) { return s.replace(/^\s+/, ""); }  
function rtrim(s) { return s.replace(/\s+$/, ""); }  
function trim(s)  { return rtrim(ltrim(s)); }

function fncLimpiarFormulario(frm,obj){
	frm.reset();
	obj.focus();
}
function convertirMayuscula(obj){
	obj.value = obj.value.toUpperCase();
}
function colorFondo(src,clrOver) {
	src.bgColor = clrOver;
}
function colorBorde(src,prop){
	src.style.border = prop;
}
function soloMayusculas(obj){
	obj.value = obj.value.toUpperCase();	
}
function soloMinusculas(obj){
	obj.value = obj.value.toLowerCase();	
}
function cambiarEstilo(obj,estilo){
	obj.className = estilo;
}
function cambiarEstiloImg(obj,estilo){
	document.getElementById(obj).className = estilo;
}
function enviarFormulario(frm){
	frm.submit();
}
function oClick(url){
	document.location.href = url;
}
function mostrarOcultarCapa(capa,opc){
	document.getElementById(capa).style.display = opc;
}
function aplicarFiltro(url,params){
	document.location.href = url+params;
}
function mensajeOnclickCheck(obj,msg){
	if(msg!=undefined && msg!=""){
		if(obj.checked){ alert(msg); }
	}
}
function fncObtenerFecha(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; /* January is 0! */
	var yyyy = today.getFullYear();
	if(dd<10){dd='0'+dd}
	if(mm<10){mm='0'+mm}
	fecha = dd + '-' + mm + '-' + yyyy;
	return fecha
}
function actualizarEstado(url,params,urlDest){
	jQuery.ajax({
		type: "POST",
		url: url,
		data: params, //jQuery("#frm_prueba").serialize(),
		dataType: "html",
		success: function(datos){
			if(datos=="si"){
				alert("Estado actualizado satisfactoriamente.");
			}else{
				alert("Error en la actualizacion del estado");
			}
			document.location.href = urlDest;
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert ("error: "+textStatus);
		}
	});
}

// Funcion para dar formato a la fecha de ingreso en tu "text"
var primerslap=false;
var segundoslap=false;
function IsNumeric(valor){
	var log=valor.length; var sw="S";
	for (x=0; x<log; x++){ 
		v1 = valor.substr(x,1);
		v2 = parseInt(v1);
		if (isNaN(v2)) { sw= "N";} //Compruebo si es un valor numérico
	}
	if (sw=="S") {return true;} 
	else { return false; }
}
function formatearFecha(fecha){ // dd-mm-YYY
	var long = fecha.length;
	var dia;
	var mes;
	var ano;
	
	if ((long>=2) && (primerslap==false)) { 
		dia=fecha.substr(0,2);
		if((IsNumeric(dia)==true) && (dia<=31) && (dia!="00")){ fecha=fecha.substr(0,2)+"-"+fecha.substr(3,7); primerslap=true; }
		else{ fecha=""; primerslap=false;}
	}else{
		dia=fecha.substr(0,1);
		if (IsNumeric(dia)==false){ fecha=""; }
		if ((long<=2) && (primerslap=true)){ fecha=fecha.substr(0,1); primerslap=false; }
	}
	if((long>=5) && (segundoslap==false)){ 
		mes=fecha.substr(3,2);
		if((IsNumeric(mes)==true) &&(mes<=12) && (mes!="00")){ fecha=fecha.substr(0,5)+"-"+fecha.substr(6,4); segundoslap=true; }
		else{ fecha=fecha.substr(0,3); segundoslap=false; }
	}else{
		if((long<=5) && (segundoslap=true)) { fecha=fecha.substr(0,4); segundoslap=false; }
	}
	if(long>=7){ 
		ano=fecha.substr(6,4);
		if(IsNumeric(ano)==false) { fecha=fecha.substr(0,6); }
		else{ 
			if(long==10){ 
				if ((ano==0) || (ano<1900) || (ano>2500)){ fecha=fecha.substr(0,6); } 
			}
		}
	}
	if (long>=10){
		fecha=fecha.substr(0,10);
		dia=fecha.substr(0,2);
		mes=fecha.substr(3,2);
		ano=fecha.substr(6,4);
		// Año no viciesto y es febrero y el dia es mayor a 28
		if( (ano%4 != 0) && (mes ==02) && (dia > 28) ){ fecha=fecha.substr(0,2)+"/"; }
	}
	return (fecha);
}
function fncRestarFechas(CadenaFecha1,CadenaFecha2){  
   var fecha1 = new fncDatosFecha( CadenaFecha1 )     
   var fecha2 = new fncDatosFecha( CadenaFecha2 )  
   var miFecha1 = new Date( fecha1.anio, fecha1.mes, fecha1.dia )  
   var miFecha2 = new Date( fecha2.anio, fecha2.mes, fecha2.dia )  
   var diferencia = miFecha1.getTime() - miFecha2.getTime()  
   var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24))  
   var segundos = Math.floor(diferencia / 1000)  
   //alert ('La diferencia es de ' + dias + ' dias,\no ' + segundos + ' segundos.')  
   return dias;
}  
  
function fncDatosFecha( cadena ) {  
   var separador = "-"  
   if ( cadena.indexOf( separador ) != -1 ) {  
        var posi1 = 0  
        var posi2 = cadena.indexOf( separador, posi1 + 1 )  
        var posi3 = cadena.indexOf( separador, posi2 + 1 )  
        this.dia = cadena.substring( posi1, posi2 )  
        this.mes = cadena.substring( posi2 + 1, posi3 )  
        this.anio = cadena.substring( posi3 + 1, cadena.length )  
   } else {  
        this.dia = 0  
        this.mes = 0  
        this.anio = 0     
   }  
}

/* Funcines personalizadas *************************************************************************************/
//_Para mostrar u ocultar los ambitos de los comunicados
function fncMostrarAmbitosCom(ambito){
	if($("#amb_"+ambito).length>0){
		$(".cont_ambito").hide();
		$("#amb_"+ambito).show();
	}
}
//_Para mostrar u ocultar las opsiones del tipo de usuario
function fncMostrarOpcUser(tipo){
	if(tipo=="docente"){
		$("#user_tutor").show();
		$("#user_psicologo").show();
	}else{
		$("#user_tutor").hide();
		$("#user_psicologo").hide();
	}
}
