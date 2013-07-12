$(function(){


	$('#mensajeCreacion').delay(900).fadeOut(300);

	$("input[type=radio]").live("click", function(){
		var filtro;
		var action;

		if($(this).val() == "1"){
			$('#Filtro').show("slow");
			$('.Fechas').hide("fade");
			filtro = $('#Filtro').val();
			action = "general";
		}
		else{
			$('.Fechas').show("slow");
			$('#Filtro').hide("fade");
			filtro = [];
			action = "rango";

			 $('.Fechas').each(function (index){
			 	 	filtro[index] = $(this).val();
			 	 	
				});
		}
		
		parametros = {
			"filtro" : filtro,
			"economico" : $('#FiltroEconomico').val(),
			"numero" : $('#NombreOperador').attr('title'),
			"action" : action
		};

		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/fletes.operador.php",
			data: parametros,
			success: function(response){
				$('#table').empty();
				$('#table').append(response.results);
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}

		});
	});

	$('#Filtro').live('change', function(){

		parametros = {
			"filtro" : $(this).val(),
			"economico" : $('#FiltroEconomico').val(),
			"numero" : $('#NombreOperador').attr('title'),
			"action" : "general"
		};

		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/fletes.operador.php",
			data: parametros,
			success: function(response){
				$('#table').empty();
				$('#table').append(response.results);
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}
		});

	});

	$('#FiltroEconomico').live("change", function(){
		var valor = $('input[name=optionsRadios]:checked', '#FormFiltro').val();
		var filtro;
		var action;

		if(valor == 1 ){
			filtro = $('#Filtro').val();
			action = "general";
		}
		else if(valor == 2){
			filtro = [];
			action = "rango";

			 $('.Fechas').each(function (index){
			 	 	filtro[index] = $(this).val();
			 	 	
				});
		}
		else{
		}
		parametros = {
			"filtro" : filtro,
			"economico" : $('#FiltroEconomico').val(),
			"numero" : $('#NombreOperador').attr('title'),
			"action" : action
		};

		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/fletes.operador.php",
			data: parametros,
			success: function(response){
				$('#table').empty();
				$('#table').append(response.results);
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}

		});

	});

	$('.Fechas').live("change", function(){
		filtro = [];
			action = "rango";

			 $('.Fechas').each(function (index){
			 	 	filtro[index] = $(this).val();
			 	 	
				});

		parametros = {
			"filtro" : filtro,
			"economico" : $('#FiltroEconomico').val(),
			"numero" : $('#NombreOperador').attr('title'),
			"action" : action
		};

		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/fletes.operador.php",
			data: parametros,
			success: function(response){
				$('#table').empty();
				$('#table').append(response.results);
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}

		});
	});

	$('#CreacionOperador').hide();

	$('#botonCrear').click(function (){
		$('#OperadorList').hide();
		$('#CreacionOperador').show('fast');
		$('#result').hide();
	});

	$('body').on('click', '#botonCancelar',   function(e){
		$('#CreacionOperador').hide("fade");
		$('#OperadorList').show("slow");
		$('#result').show();
	});

	$('.media').click(function(){

		parametros = {
			"numero" : $(this).attr("title"),
			"nombre" : $(this).children().children(".media-heading").text()
		};

		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/detalles.operador.php",
			data: parametros,
			success: function(response){
				$('#result').empty();
				$('#result').append(response.results);

				$('.Fechas').hide();
				$('#Filtro').hide();
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}

		});
	});

	$('.editarOperador').live('click', function(){
		$('#OperadorList').hide("slow");
		$('#result').hide();

		parametros = {
			"operador" : $(this).val(),
			"tipo"		: "Operador"
		};

		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/editar.data.php",
			data: parametros,
			success: function(response){
				$('#CreacionOperador')
				.data( "creacion", $('#CreacionOperador').html() )
				.html(response.contenido)
				.show();
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}

		});


	});

	$('.cancelarEdicion').live("click", function(){
		$('#CreacionOperador').hide("fade").html( $('#CreacionOperador').data('creacion') );
		$('#OperadorList').show("slow");
		$('#result').show();
	});

	$('body').on('change', '.controlDeOperador',   function(e){
		parametros = { 'value' : $(this).val(),
					   'actual' : $('#actual').val(),
					   'tipo'  : 'Operador'};

		$.ajax({
			beforeSend: function(){
				$('.statusClave').empty()
								.append('<img height="10" width="10" src="../img/loading.gif">');
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/comprobar.claves.php",
			data: parametros,
			success: function(response){
				$('.statusClave').empty()
								 .append(response.contenido);
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}

		});
		
	});

	$('body').on("submit" , "#OperadorForm" , function(e) {

		if($('#statusClaveModificada').attr("value") === "false" ){
			alert("Accion no permitida. \n Elija un numero de control correcto");
			return false;
		}

			//Important. Stop the normal POST
			//return false;

	});

});