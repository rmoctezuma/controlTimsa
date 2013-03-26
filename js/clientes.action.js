$(function(){

	$('#nuevaCreacionCliente').validate();

	$('.media').click(function(){
			$('.NuevaSucursal').hide();
			var imagen = $(this).children().children().attr("src");

		parametros = {
			"numero" : $(this).attr("title"),
			"nombre" : $(this).children().children(".media-heading").text()
		};

		$(this).children('div').children('button').show();

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
	$('#NuevoFlete').hide();

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

	$('#cancelarCreacion').click(function(){
		$('#NuevoFlete').hide("fade");
		$('#ListaClientes').show("slow");
	});

	$('#AgregarCliente').click(function(){
		clearOverlays();
		$('#Sucursal').hide();
		removeRoute();
		$('#ListaClientes').hide("slow");
		$('#NuevoFlete').show("fade");		
	});

	$('#mensajeCreacion').delay(900).fadeOut(300);

	$('.NuevaSucursal').hide();

	$('#InfoNueva-Sucursal').hide();

	$('.NuevaSucursal').click( function (e){
		e.preventDefault();
		$('#ListaClientes').hide("fast");
		$('#InfoNueva-Sucursal').show("fade");

		$('#tituloSucursal').empty();
		$('#tituloSucursal').append('NuevaSucursal ' + $(this).parent().children(".media-heading").text());

		addNewListener($(this).parent().parent().attr("title"));

	});

	$('#cancelarCreacion-Sucursales').click(function(){
		$('#InfoNueva-Sucursal').hide("fade");
		$('#ListaClientes').show("fast");
		removeListener();
	});

	$('#buscar').click(function(){
		  buscarUbicacion($('#busqueda').val());
	});

	$('#cuotas').live('change', function(){
		var parametros = {"value" : $('#cuotas').val()};

		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/precio.cuotaSucursal.php",
			data: parametros,
			success: function(response){
				$('#detallesPrecios').empty();
				$('#detallesPrecios').append(response.resultado);
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}

		});
	});

	$('#newSucursal').live('click', function(){
		var parametros = {"nombre" : $('#nombre').val(), 
		"telefono" : $('#telefono').val(),
		"cliente"  : getIdFromMarker(),
		"cuota" : $('#cuotas').val(),
		"Lat"   : getLatLongTemporal().lat(),
		"Long"  : getLatLongTemporal().lng()
		 };

		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../includes/registro.sucursal.php",
			data: parametros,
			success: function(response){
				window.location.replace("http://control.timsalzc.com/Timsa/html/clientes.php?sucursal=agregada");
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}
		});	
	});

	$('#mensajeCreacion').delay(900).fadeOut(300);

});