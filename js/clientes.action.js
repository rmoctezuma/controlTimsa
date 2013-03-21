$(function(){
		$('.media').click(function(){
			var imagen = $(this).children().children().attr("src");

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
			url:"../includes/sucursales.clientes.php",
			data: parametros,
			success: function(response){
				var nombres = response.nombres;
				var latlon = response.LatLon;

				clearOverlays();

				for (var i  in nombres) {
					sucursalesClientes(imagen, latlon[i], nombres[i] ,i);
				};

				showSucursales();
				$('#Sucursal').hide();
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}

		});
	});

	$('#Sucursal').hide();

	$('#DetallesRutas').live("click", function(){
		var economico = $('#NombreOperador').attr("title");

		parametros = {"economico" : economico}

		if( $('#DetallesRutas').hasClass('active')){
			$('#Rutas').show("fade");
			requestRoute();
		}
		else {
			$('#Rutas').hide("fade");
			removeRoute();
		}
	});	

});