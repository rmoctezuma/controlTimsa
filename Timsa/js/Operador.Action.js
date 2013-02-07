$(function(){

	$('#formSocio').validate();

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

	$('#Filtro').live('change', function(){

		parametros = {
			"filtro" : $(this).val(),
			"economico" : $('#FiltroEconomico').val(),
			"numero" : $('#NombreOperador').attr('title')
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

	$('#FiltroEconomico').live("change". function(){

	});

	$('#CreacionOperador').hide();

	$('#botonCrear').click(function (){
		$('#OperadorList').hide();
		$('#CreacionOperador').show('fast');
		$('#result').hide();
	});

	$('#botonCancelar').click(function(){
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

});