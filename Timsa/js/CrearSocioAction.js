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

	$('#Filtro').live('change', function(){
		alert($(this).val());
	});

	$('#botonCrear').click( function (e){
		$('#SocioList').hide("fade");
		$('#CreacionSocio').show("slow");
	});

	$('#botonCancelar').click( function (e){
		$('#CreacionSocio').hide("slow");
		$('#SocioList').show("fade");
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

});

