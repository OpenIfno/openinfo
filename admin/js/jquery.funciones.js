//_Apenas termina de cargar la pagina ******************************************************************************************************
$(document).ready(function(){
//_Formateo de ingreso en cajas de texto -------------------------------------------------------------
	if($('.numeric').length>0){ $('.numeric').validCampoFranz('0123456789'); }
	if($(".decimal").length>0){ $(".decimal").numeric({ decimal:".", negative:false });	}
	if($('.alpha').length>0){ $('.alpha').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou'); }
	if($('.upper').length>0){
		$('.upper').on("keyup blur", function(event){
			valor = $(this).val().toUpperCase();
			$(this).val(valor);
		});
	}
	if($(".hora").length > 0) {
		$.mask.definitions['H']='[012]'; //_Horas
		$.mask.definitions['N']='[012345]';
		$.mask.definitions['n']='[0123456789]';
		$(".hora").mask("Hn:Nn"); // Hn:Nn:Nn
	}
//_Para el efecto DATEPICKER -------------------------------------------------------------------------
	fncDatePicker();
//_Para el efecto CLOCKPICKER -------------------------------------------------------------------------
		fncClockPicker();
//_Para el recurso del detalle noticia -------------------------------------------------------------------------
		fncRecurso();
//_Para el efecto de COLORBOX ------------------------------------------------------------------------
	fncColorbox();
//_Para Generar los EDITORES -------------------------------------------------------------------------
	fncEditor();
//_Para Mostrar/Ocultar ELEMENTOS --------------------------------------------------------------------
	fncMostrarOcultar();
//_Propias de EXGADMIN -------------------------------------------------------------------------------
	fncManttoExg();
//_Para el efecto POPOVER ----------------------------------------------------------------------------
	if($(".popover_exg").length>0){
		$(".popover_exg").popover({
			html: true,
			trigger: 'hover',
			container : 'body'
		});
	}
//_Para el efecto TOOLTIP ----------------------------------------------------------------------------
	if($(".tooltip_exg").length>0){
		$(".tooltip_exg").tooltip({
			html: true,
			trigger: 'hover',
			container : 'body'
		});
	}
//_Para mostrar el listado de aplicaciones de un ROL -------------------------------------------------
	if($(".clb_usurol").length>0){
		$.fn.dataTableExt.sErrMode = 'throw';
		$(".clb_usurol").on("click", function(e){
			e.preventDefault();
			var url = $(this).data("url");
			var rol = $(this).data("rol");
			var rol_name = $(this).data("rol_name").toUpperCase();
			$.post(url, { id_rol:rol }, function(data){
				$.colorbox({
					width	  	: "100%",
					maxWidth  : "90%",
					maxHeight : "95%",
					opacity	  : 0.7,
					current   : false,
					html	  	: data,
					onLoad	  : function(){
						$('#cboxPrevious').remove();
						$('#cboxNext').remove();
						$('#cboxBottomCenter').html("<div style='padding-top:7px;'>M&oacute;dulos del Rol: <strong>\""+rol_name+"\"</strong></div>");
					},
					onComplete: function(){
						fncDatatable();
					}
				});
			});
			return false;
		});
	}
//_Para cargar pagina AJAX en un colorbox ------------------------------------------------------------
	if($(".btn-ajax-clb").length>0){
		$.fn.dataTableExt.sErrMode = 'throw';
		$(".btn-ajax-clb").on("click", function(){
			var mod_id_sist = $(this).attr("data-id-sist");
			if(mod_id_sist!="" && IsNumeric(mod_id_sist)==true){
				var mod_tipo = $(this).attr("data-tipo"); //-----> LISTAR, MANTTO o MIXTO
				var mod_url = $(this).attr("data-url");
				var mod_params = $(this).attr("data-params");
				var mod_paramsdest = $(this).attr("data-paramsdest");
				var mod_name = $(this).attr("data-name");
				var params = {};
				params.m = mod_id_sist;
				if(mod_params!="" && mod_paramsdest!=""){
					params.param_1 = mod_params;
					params.param_2 = mod_paramsdest;
				}else{
					if(mod_params!="" || mod_paramsdest!=""){
						if(mod_params!=""){ params.param_1=mod_params; }else{ params.param_2=mod_paramsdest; }
					}
				}
				$.post(mod_url, params, function(data){
					$.colorbox({
						width	  : "100%",
						maxWidth  : "90%",
						maxHeight : "95%",
						opacity	  : 0.7,
						current   : false,
						html	  : data,
						onLoad	  : function(){
							$('#cboxPrevious').remove();
							$('#cboxNext').remove();
							$('#cboxBottomCenter').html("<div style='padding-top:7px;'><strong>\""+mod_name.toUpperCase()+"\"</strong></div>");
						},
						onComplete: function(){
							if(mod_tipo!="mantto"){ fncDatatable(); }
							fncFocusAjax();
						}
					});
				});
			}
			return false;
		});
	}
//_Para cargar pagina IFRAME en un colorbox ----------------------------------------------------------
	if($(".btn-iframe-clb").length>0){
		$(".btn-iframe-clb").on("click", function(){
			var mod_url = $(this).attr("data-url");
			var mod_name = $(this).attr("data-name");
			$.colorbox({
				iframe	  : true,
				width	  : "100%",
				maxWidth  : "90%",
				height	  : "100%",
				maxHeight : "62%",
				opacity	  : 0.7,
				current   : false,
				href	  : mod_url,
				onLoad	  : function(){
					$('#cboxPrevious').remove();
					$('#cboxNext').remove();
					$('#cboxBottomCenter').html("<div style='padding-top:7px;'><strong>\""+mod_name.toUpperCase()+"\"</strong></div>");
				}
			});
			return false;
		});
	}
//_Para cargar los videos de YOUTUBE -----------------------------------------------------------------
	if($("a.youtube").length > 0){
		$("a.youtube").player({
			chromeless: 0,
			showTime: 0,
			showPlaylist: 0,
			showTitleOverlay: 0
		});
	}
});

//_Creadas para el sistema *****************************************************************************************************************
//_Para pasar el enfoque despues de una llamada AJAX -------------------------------------------------
function fncFocusAjax(){
	if($(".focus_ajax").length>0){ $(".focus_ajax").focus(); }
}
//_Para el efecto de COLORBOX ------------------------------------------------------------------------
function fncColorbox(){
	if($(".clb_img").length>0){
		$(".clb_img").colorbox({
			rel		  : 'gal',
			slideshow : true,
			current   : false,
			opacity	  : 0.7,
			maxWidth  : "90%"
		});
	}
}
//_Para cerrar todos los TOOLTIP de la pagina --------------------------------------------------------
function fncCerrarTooltip(){
	if($(".tooltip_exg").length>0){
		$(".tooltip_exg").tooltip("option", "hide");
	}
}
//_Para Generar los DATEPICKER -----------------------------------------------------------------------
function fncDatePicker(){
	$(".datepicker").datetimepicker({
			 format: 'dd-mm-yyyy',
			 minView : 2,
			 autoclose: true,
			 language: 'es'
	 });
	 $(".timepicker").datetimepicker({
 			 format: 'hh:ii',
 			 startView: 'hour',
 			 autoclose: true,
 			 language: 'es'
 	 });
	if($(".datepicker").length>0){
		$('.datepicker').datetimepicker({
			format	 : 'dd-mm-yyyy',
			pickTime: false,
			autoclose: true,
			language : 'es'
		});
	}
	if($(".datepicker_usu").length>0){
		var today = new Date();
		var yyyy = today.getFullYear();
		$('.datepicker_usu').bdatepicker({
			format	 : 'dd-mm-yyyy',
			startDate: '31-12-'+(yyyy-80),
			endDate	 : '31-12-'+(yyyy-12),
			language : 'es',
			autoclose: true
		});
	}
	if($(".datepicker_arch").length>0){
		var today = new Date();
		var yyyy = today.getFullYear();
		$('.datepicker_arch').bdatepicker({
			format	 : 'dd-mm-yyyy',
			startDate: '31-12-'+(yyyy-4),
			endDate	 : '31-12-'+(yyyy),
			language : 'es',
			autoclose: true
		});
	}

	$(".clockpicker").clockpicker({
		placement: 'bottom',
	 align: 'left',
	 autoclose: true,
	 });

}

function fncClockPicker(){
	$(".clockpicker").clockpicker({
		placement: 'bottom',
	 align: 'left',
	 autoclose: true,
	 });
}

function fncRecurso(){
	$("#imgaud").hide();
	$("#recurso").hide();
	var sel = $("#tipo").val();
	if(sel==1 || sel==2 ){
		$("#imgaud").show();
	}else{
		$("#recurso").show();
	}
	$("#tipo").change(function(){
		var sel = $("#tipo").val();
		if(sel==1 || sel==2 ){
			$("#imgaud").show();
			$("#recurso").hide();
		}else{
			$("#imgaud").hide();
			$("#recurso").hide();
			if(sel==3 || sel==4 || sel==5 || sel==6){ $("#recurso").show(); }
		}
	});
}


//_Para Generar los EDITORES -------------------------------------------------------------------------
function fncEditor(){
	if($(".editor").length>0){
		$("textarea.editor").wysihtml5({
			"font-styles": true, //-> Estilo de fuente, e.g. h1, h2, etc. Default true
			"emphasis": true, //----> Italica, negrita, etc. Default true
			"lists": true, //-------> Listas ordenadas y desordenadas. Default true
			"html": false, //-------> Permite generar codigo HTML. Default false
			"link": false, //-------> Insertar enlaces. Default true
			"image": false, //------> Insertar imagenes. Default true
			"color": false //-------> Cambiar color de la fuente
		});
	}
}
//_Propias de EXGADMIN -------------------------------------------------------------------------------
function fncManttoExg(){
//_Para limpiar un formulario
	if($("button[type=reset]").length>0){
		$("button[type=reset]").on("click", function(){
			if($(".obj_focus").length>0){ $(".obj_focus").focus(); }
		});
	}
//_Para MARCAR o DESMARCAR todos los checkbox de un listado
	if($("#chk_all").length>0){
		$("#chk_all").on("click", function(){
		   if($(".chk").length>0){
				 var marcado = $(this).prop("checked")?true:false;
				 $(".chk").prop("checked",marcado);
				 if(marcado==true){ $(".chk").siblings().addClass("checked"); }
				 else{ $(".chk").siblings().removeClass("checked"); }
		   }
		});
		if($(".chk").length>0){
			$(".chk").on("click", function(){
				if($(".chk:checked").length==$(".chk").length){
					$("#chk_all").prop("checked",true); $("#chk_all").siblings().addClass("checked");
				}else{
					$("#chk_all").prop("checked",false); $("#chk_all").siblings().removeClass("checked");
				}
			});
		}
	}
//_Para ACTUALIZAR el estado de un registro
	if($('.estado_exg').length>0){
		$(".estado_exg").on("click", function(e){
			e.preventDefault();
			var url = $(this).data("url");
			var params = $(this).data("params");
			if(url!="" && params!=""){
				$.post(url, params, function(datos){
					if(datos=="si"){
						alert("Estado editado satisfactoriamente.");
						document.location.href = document.location;
						location.reload();
					}else{
						alert("El estado de este registro no pudo ser editado.");
					}
				});
			}
		});
	}
//_Para ELIMINAR 1 solo registro
	if($('.eliminar_exg').length>0){
		$(".eliminar_exg").on("click", function(e){
			e.preventDefault();
			var url = $(this).data("url");
			var params = $(this).data("params");
			if(url!="" && params!=""){
				if(confirm("\xbfRealmente desea ELIMINAR este registro?")){
					$.post(url, params, function(datos){
						if(datos=="si"){
							alert("Registro eliminado satisfactoriamente.");
							document.location.href = document.location;
							location.reload();
						}else{
							alert("El registro no pudo ser eliminado.");
						}
					});
				}
			}
		});
	}
//_Para ELIMINAR varios registros
	if($(".eliminar_varios_exg").length>0){
		$(".eliminar_varios_exg").on("click", function(e){
			e.preventDefault();
			var url = $(this).data("url");
			var params = $(this).data("params");
			if(url!="" && params!=""){
				if($(".chk:checked").length>0){
					registros="";
					$(".chk:checked").each(function(){ registros+=$(this).val()+","; });
					if(confirm("\xbfRealmente desea eliminar los registros marcados?")){
						registros=registros.substring(0,(registros.length-1));
						params+="&id="+registros;
						$.post(url, params, function(datos){
							if(datos=="si"){
								alert("Registros eliminados satisfactoriamente.");
								document.location.href = document.location;
							}else{
								alert("Los registros no pudieron ser eliminados.");
							}
						});
					}
				}else{
					alert('No se han marcado registros a eliminar.');
				}
			}
		});
	}
}

//_Creadas para formularios ****************************************************************************************************************
//_Para Mostrar/Ocultar Elementos --------------------------------------------------------------------
function fncMostrarOcultar(){
//_MODULOS: Para Mostrar/Ocultar el url del modulo
	if($(".noti_web").length>0){
		$(".noti_web").on("change", function(){
			if($(this).val()=="si"){ $(".noti_url").show(); }else{ $(".noti_url").hide(); }
		});
	}
//_NOTIFICACIONES: Para Mostrar/Ocultar las fechas dependiendo el tipo
	if($(".notifi_fch").length>0){
		$(".notifi_fch").on("change", function(){
			if($(this).val()=="1"){ $(".notifi_limit").hide(); }else{ $(".notifi_limit").show(); }
		});
	}
}
