$(function(){

	$('#CreacionSocio').hide();

		$("input[type=radio]").live("click", function(){
		if($(this).val() == "1"){
			$('#Filtro').show("slow");
			$('.Fechas').hide("fade");
		}
		else{
			$('.Fechas').show("slow");
			$('#Filtro').hide("fade");
		}
	});


	$('#botonCrear').click( function (e){
		$('#SocioList').hide("fade");
		$('#result').hide();
		$('#CreacionSocio').show("fast");
	});

	$('#botonCancelar').click( function (e){
		$('#CreacionSocio').hide("slow");
		$('#SocioList').show("fade");
		$('#result').show();
	});

	$('#formSocio').validate();

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
			url:"../includes/detalles.socio.php",
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

	$('#mensajeCreacion').delay(900).fadeOut(300);

	//----------------------------------------------------------------------//

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

});

