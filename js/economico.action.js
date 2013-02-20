$(function(){

	$('#formEconomico').hide();

	$('#formEco').validate();
	
	$('#nuevoEconomico').click( function(){
		$('#formEconomico').show();
		$('#MuestraEconomicos').hide();
	});

	$('#botonCancelar').click( function(){
		$('#formEconomico').hide();
		$('#MuestraEconomicos').show();
	});

	$('.camiones').live('click', function (e){
		e.preventDefault();
		
		var parametros = { "economico" : $(this).children().attr("title"),
							"placas"   : $(this).parent().children("h6").text()
						 }		
		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/detalles.economico.php",
			data: parametros,
			success: function(response){

				$('#MuestraEconomicos').hide();
				$('#economicoDetalle').show("fade");
				$('#economicoDetalle').append(response.results);
				$('.Fechas').hide();
				$('#Filtro').hide();
				$('#appendOperador').hide();
				
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}
		});
	});

	$("input[type=radio]").live("click", function(){
		var filtro;
		var action;

		if($(this).val() == "1"){
			$('#Filtro').show("fade");
			$('.Fechas').hide();
			filtro = $('#Filtro').val();
			action = "general";
		}
		else{
			$('.Fechas').show("fade");
			$('#Filtro').hide();
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
			url:"../includes/fletes.economico.php",
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
			url:"../includes/fletes.economico.php",
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
			url:"../includes/fletes.economico.php",
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
			url:"../includes/fletes.economico.php",
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

	$('#back').live("click", function (e){
		e.preventDefault();
		$('#economicoDetalle').hide();
		$('#economicoDetalle').empty();
		$('#MuestraEconomicos').show("fade");
	});

	

	$('#EditarOperador').live("click", function(){
		var economico = $('#NombreOperador').attr("title");

		parametros = {"economico" : economico}

		if( $('#EditarOperador').hasClass('active')){
			$('#appendOperador').show("fade");
		}
		else {
			$('#appendOperador').hide("fade");
		}

		
	/*		
		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/editar.economico.php",
			data: parametros,
			success: function(response){

			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}

		});
		*/
	});

});