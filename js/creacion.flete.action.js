$(function(){

	$('#listaContenedor a').on("click", function (e){
		if(! ($('#botonGroupViaje button').hasClass('active'))){
			e.stopPropagation();
		}
	});

	$('#listaFlete a').on("click", function (e){
		if($('#listaFlete').hasClass('disabled')){
			e.stopPropagation();
		}
	});

	$('.tipoContenedor').live("change", function(){
		$('#' + $(this).attr("title")).empty();
		$('#' + $(this).attr("title")).append($(this).val());
	});

	$('.selloInput').live("keyup", function(){
		$('#' + $(this).attr("name")).empty();
		$('#' + $(this).attr("name")).append($(this).val());
	});

	$('.sellos').live("change", function(){
		var pane = $(this).attr("title"); //Pane donde se dibujara.
		var tipo = 0; // Si hay mas de un cotenedor, esta variable define en que pane dibujar.
		var rango = 0; // Esta variable comprueba si hay 2 sellos o 1.
		var option = $(this).val();

		$( ".sellos" ).each(function() {
		    if($(this).val() > option){
		    	option = $(this).val();
		    }
		});
		// Aqui se comprueba la existencia de sellosPane2, ya que si no es menor que 4, es por que no existe.
		if($('#sellosPanes2').val() < 4){
			rango = 2;
		}
		else{
			rango = 1;
		}

		if(pane.indexOf("2") >= 0){
			tipo = 1;
		}

		var parametros = {
			"value" : $(this).val(),
			"tipo" : tipo,
			"rango" : rango,
			"option" : option
		};

		$.ajax({
			beforeSend : function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../../includes/detalles.creacion.sellos.php",
			data: parametros,
			success: function(response){
				$('#'+ pane).empty();
				$('#'+ pane).append(response.contenido);
				$('#tablaContenedor').empty();
				$('#tablaContenedor').append(response.contenidoResult);

				$(".selloInput").each(function(){
					var name = $(this).attr("name"); 
					var value = $(this).val();
					$("#" + name ).empty();
					$("#" + name ).append(value);
				});
			},
			error: function(xhr, ajaxOptions, thrownError){	
				alert("eRROR");		
			}
		});
	});

	$('.contenedorInput').live("keyup", function(){
		var name = $(this).attr("name");
		$('#' + name + "").empty();
		$('#' + name + "").append($(this).val());
	});

	$("input[type=radio]").live("click", function(){

		$('#Operador').empty();
		$('#Operador').append($(this).parent().text());
		$('#Operador').attr("title",$(this).val());
	});

	 $("#listaAgencia li").each(function(i){
	      var value = $(this).children().attr("href");
	      var tit = $(this).children().text();
	      if(tit == 'MAERSK'){
	      	$("#listaAgencia").attr("href",value);
	      	$('#Agencia').attr("title", value);
	      }
	   });

//Botones de busqueda de economico, via Socio. Toman los datos de los botones,
//para buscar a los operadores que han conducido dichos economicos.
 	$('#botonGroupEconomico button').live("click", function (){
		$('#Economico').empty();
		$('#Economico').append($(this).text());
		$('#Economico').attr("title", $(this).attr("title"));

		$('#OperadorTab').empty();

		var parametros = { "value" : $(this).attr("title"),
							"action" : "Operador",
							"Socio" : $('#Socio').attr('title'),
							"Economico" : $('#Economico').attr('title')
						};

		$.ajax({
		        beforeSend: function(){
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../../includes/detalles.creacion.flete.php",
		            data: parametros,
		            success: function(response){

		            	// Validar mensaje de error
		            	if(response.respuesta == false){
		            		$('#OperadorTab').append("<h3> Error </h3>");
		            	}
		            	else{
		            		if(response.contenido.length == 74){
		            			$('#OperadorTab').append("<h1> Este Socio no Posee economicos </h1>");
		            		}

		            		else
		            			{
		            			$('#OperadorTab').append(response.contenido);
		            		  }

		            		// si es exitosa la operación
		                	// alert(response.contenido)		                	
		                	// Validad tipo de acción	                	           	
						}	            	

		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	alert("error, comprueba tu conexion a internet");
		                $('#EconomicoTab').append(xhr.responseText);            
		            }
		        });
	});


	$('#botonGroup button').live("click", function (){
		$('#Cliente').attr("title", $(this).val());

		$('#listaFlete').removeClass('disabled');
		$('#listaContenedor').addClass('disabled');

		$('#createFlete button').attr("disabled","disabled");

		$('#Sucursal').empty();
		$('#Sucursal').append($(this).text());
		$('#Sucursal').attr("title", $(this).attr("title"));

		$('#Trafico').empty();
		$('#Trafico').append("Sin especificar");

		$('#Viaje').empty();
		$('#Viaje').append("Sin especificar");

		$('#Cuota').empty();
		$('#Cuota').append("Sin especificar");
		$('#Cuota').attr("title","");

		$('#Tarifa').empty();
		$('#Tarifa').append("Sin especificar");

		$('#botonGroupViaje button').removeClass();
		$('#botonGroupViaje button').addClass("btn btn-large");
		$('#botonGroupTrafico button').removeClass();
		$('#botonGroupTrafico button').addClass("btn btn-large");

		$('#Contenedor').empty();
		$('#Contenedor').append("<td> Contenedor </td>");
		$('#Booking').empty();
		$('#Booking').append("<td> Booking </td>");
		$('#WorkOrder').empty();
		$('#WorkOrder').append("<td> WorkOrder </td>");
		$('#Tipo').empty();
		$('#Tipo').append("<td> Tipo Contenedor </td>");
		$('#tablaContenedor').empty();

	});

	$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });

	$('#ClienteTab').hide();

	$('#listaAgencia li a').click(function (e){
		e.preventDefault();
		$(this).parent().parent().attr("href", $(this).attr("href"));

		$('#title').empty();

		$('#title').append('Flete ');
		$('#title').append($(this).text());

		$('#Agencia').empty();
		$('#Agencia').append($(this).text());
		$('#Agencia').attr("title", $(this).attr("href"));

	});

	$('#pagerR ul li a').click(function (e){	
		e.preventDefault();

		$('#createFlete button').attr("disabled","disabled");

		$('#listaFlete').addClass('disabled');
		$('#listaContenedor').addClass('disabled');

		$('#Trafico').empty();
		$('#Trafico').append("Sin especificar");

		$('#Viaje').empty();
		$('#Viaje').append("Sin especificar");

		$('#Cuota').empty();
		$('#Cuota').append("Sin especificar");
		$('#Cuota').attr("title","");

		$('#Tarifa').empty();
		$('#Tarifa').append("Sin especificar");

		$('#botonGroupViaje button').removeClass();
		$('#botonGroupViaje button').addClass("btn btn-large");
		$('#botonGroupTrafico button').removeClass();
		$('#botonGroupTrafico button').addClass("btn btn-large");

		$('#Contenedor').empty();
		$('#Contenedor').append("<td> Contenedor </td>");
		$('#Booking').empty();
		$('#Booking').append("<td> Booking </td>");
		$('#WorkOrder').empty();
		$('#WorkOrder').append("<td> WorkOrder </td>");
		$('#Tipo').empty();
		$('#Tipo').append("<td> Tipo Contenedor </td>");
		$('#tablaContenedor').empty();

		$('#listaClientes').show("fade");
		$('#ClienteTab').hide();

		$('#Sucursal').empty();
		$('#Sucursal').append("Sin asignar");
		$('#Sucursal').attr("title","");

	});

	$('#listaClientes li a').click(function (e){
		e.preventDefault();

		$('#Data').empty();
		$('#lD').empty();

		var cliente = $(this).text();

		$(this).parent().parent().attr("href", $(this).attr("href"));
		$(this).parent().parent().hide();

		$('#ClienteTab').show("slow");


		$('#Cliente').empty();
		$('#Cliente').append($(this).text());
		

		var parametros = { "value" : $(this).attr("href"),
							"action" : "Cliente" };

		$.ajax({
		        beforeSend: function(){
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../../includes/detalles.creacion.flete.php",
		            data: parametros,
		            success: function(response){

		            	// Validar mensaje de error
		            	if(response.respuesta == false){
		            		$('#Data').append("<h3> Error </h3>");
		            	}
		            	else{
		            		if(response.contenido.length == 74){
		            			$('#Data').append("<h1> Este Socio no Posee economicos </h1>");
		            		}

		            		else
		            			{
		            			$('#Data').append('<h2>' + cliente + '</h2>');
		            			$('#Data').append(response.contenido);
		            		  }

		            		// si es exitosa la operación
		                	// alert(response.contenido)		                	
		                	// Validad tipo de acción	                	           	
						}	            	

		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	alert("error" + xhr.responseText);
		                $('#Data').append(xhr.responseText);            
		            }
		        });

	});

	$('#listaSocios li a').click(function (e){
		e.preventDefault();

		$('#OperadorTab').empty();
		$('#EconomicoTab').empty();
		$("#Economico").empty();
		$('#Economico').attr("title","");
		$("#Economico").append("Sin asignar");
		$('#Socio').empty();
		$('#Socio').append($(this).text());
		$('#Socio').attr("title", $(this).attr("href"));
		$('#Operador').empty();
		$('#Operador').append("SIn asignar");
		$('#Operador').attr("title","");


		var parametros = { "value" : $(this).attr("href"),
							"action" : "Socio" };

		$.ajax({
		        beforeSend: function(){
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../../includes/detalles.creacion.flete.php",
		            data: parametros,
		            success: function(response){

		            	// Validar mensaje de error
		            	if(response.respuesta == false){
		            		$('#EconomicoTab').append("<h3> Error </h3>");
		            	}
		            	else{
		            		if(response.contenido.length == 74){
		            			$('#EconomicoTab').append("<h1> Este Socio no Posee economicos </h1>");
		            		}

		            		else
		            			{
		            			$('#EconomicoTab').append(response.contenido);
		            		  }
		            		// si es exitosa la operación
		                	// alert(response.contenido)		                	
		                	// Validad tipo de acción	                	           	
						}	            	
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	alert("error, comprueba tu conexion a internet" + xhr.responseText);
		                $('#EconomicoTab').append(xhr.responseText);            
		            }
		        });


	});

	$('#SocioTab').hide();

	$('ul.nav.nav-pills li a').click(function() {           
    $(this).parent().addClass('active').siblings().removeClass('active');           
});

	$('#botonGroupTrafico button').click( function (e){
		$('#Trafico').empty();
		$('#Trafico').append($(this).text());

		var parametros = {"trafico" : $('#Trafico').text(),
						  "viaje" : $('#Viaje').text(),
						  "value" : $('#Sucursal').attr("title")
						 };

		$.ajax({
			beforeSend: function (){

			},
			cache: false,
			type: "POST",
			dataType: "json",
			url:"../../includes/detalles.creacion.tarifa.php",
			data: parametros,
			success: function (response){

				$('#Cuota').empty();
				$('#Cuota').append(response.lugar);
				$('#Cuota').attr("title", response.cuota);
				$('#Tarifa').empty();
				$('#Tarifa').append(response.tarifa);

				if(($('#botonGroupViaje button').hasClass("active"))){
					$('#createFlete button').removeClass('disabled');
					$('#createFlete button').attr("disabled",false);	
				}

			},
			error: function(xhr, ajaxOptions, thrownError){
				alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}
		});
	});

	$('#botonGroupViaje button').click( function (e){
		$('#listaContenedor').removeClass("disabled");
		$('#Viaje').empty();
		$('#Viaje').append($(this).text());
		var viaje = $(this).text();

		var parametros = {"trafico" : $('#Trafico').text(),
						  "viaje" : $('#Viaje').text(),
						  "value" : $('#Sucursal').attr("title")
						 };

		$.ajax({
			beforeSend: function (){

			},
			cache: false,
			type: "POST",
			dataType: "json",
			url:"../../includes/detalles.creacion.tarifa.php",
			data: parametros,
			success: function (response){

				$('#Cuota').empty();
				$('#Cuota').append(response.lugar);
				$('#Cuota').attr("title", response.cuota);
				$('#Tarifa').empty();
				$('#Tarifa').append(response.tarifa);

				parametros = {"tipoViaje" : viaje };

				$.ajax({
					beforeSend: function (){
					},
					cache: false,
					type: "POST",
					dataType: "json",
					url:"../../includes/detalles.creacion.formContenedor.php",
					data: parametros,
					success: function (response){
						$('#tablaContenedor').empty();
						$('#tablaContenedor').append(response.contenidoSellos);
						$('#lD').empty();
						$('#lD').append(response.contenido);
						$('#Contenedor').empty();
						$('#Contenedor').append(response.contenidoContenedor);
						$('#WorkOrder').empty();
						$('#WorkOrder').append(response.contenidoWorkOrder);
						$('#Booking').empty();
						$('#Booking').append(response.contenidoBooking);
						$('#Tipo').empty();
						$('#Tipo').append(response.contenidoTipo);

						if(($('#botonGroupTrafico button').hasClass('active'))){
							$('#createFlete button').removeClass('disabled');
							$('#createFlete button').attr("disabled", false);
						}
					},
					error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
					}
				});

			},
			error: function(xhr, ajaxOptions, thrownError){
				alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}
		});
	});

	$('#bloqueError').hide();


	//Esta es el evento que genera el flete. Toma todos los datos, y los inserta en la base de datos.

	$('#createFlete button').click( function (e){

		if(! $('#Socio').attr("title")){
			$('#errorLog').text("Error, por favor selecciones un socio");
			$('#bloqueError').fadeIn();
			return;
		}

		if(! $('#Economico').attr("title")){
			$('#errorLog').text("Error, por favor selecciones un economico");
			$('#bloqueError').fadeIn();
			return;
		}

		if(! $('#Operador').attr("title")){
			$('#errorLog').text("Error, por favor selecciones un operador");
			$('#bloqueError').fadeIn();
			return;
		}

		var arrayContenedor =[];
		var arrayWorkOrder = [];
		var arrayBooking = [];
		var arrayTipoContenedor = [];
		var arraySello = [];

		$( "#Contenedor td" ).each(function(index, value) {
			if(index != 0){
				var contenedor = $(this).text();
				// Si el contenedor se encuentra sin especificar, se coloca a null.
				if(contenedor.indexOf("Sin especificar") !== -1){
					contenedor = null;
				}
				else{
				}
				arrayContenedor[index-1] = contenedor;
			} 
		});

		$( "#WorkOrder td" ).each(function(index, value) {
			if(index != 0){
				arrayWorkOrder[index-1] = $(this).text();
			} 
		});

		$( "#Booking td" ).each(function(index, value) {
			if(index != 0){
				arrayBooking[index-1] = $(this).text();
			} 
		});

		$( "#Tipo td" ).each(function(index, value) {
			if(index != 0){
				arrayTipoContenedor[index-1] = $(this).text();
			} 
		});

		$('#tablaContenedor tr').each(function(index, value){
			var newArraySellos = [];

			$(this).children().each(function(index, value){
				if(index != 0){
					newArraySellos[index-1] = $(this).text();
				}
			});

			arraySello[index] = newArraySellos;
		});

		var arraySelloMejorado = [];
		var newArraySellos = [];

		for (var i = 0; i < arrayContenedor.length ; i++) {	
			for (var e = 0; e < arraySello.length  ; e++) {
				newArraySellos[e] =  arraySello[e][i];
			}
			arraySelloMejorado[i] = newArraySellos;
		}

		var parametros = {
			"agencia" : $('#Agencia').attr("title"),
			"cliente" : $('#Cliente').attr("title"),
			"cuota" : $('#Sucursal').attr("title"),
			"socio" : $('#Socio').attr("title"),
			"operador" : $('#Operador').attr("title"),
			"economico" : $('#Economico').attr("title"),
			"numcuota" : $('#Cuota').attr("title"),
			"comentarios" : $('#comentarios').val(),
			"contenedor" : arrayContenedor,
			"workorder" : arrayWorkOrder,
			"booking" : arrayBooking,
			"tipoContenedor" : arrayTipoContenedor,
			"sello" : arraySelloMejorado,
			"status" : "Activo"
		};

		$.ajax({
			beforeSend: function(){
			},
			cache: false,
			type: "POST",
			dataType:"json",
			url:"../../includes/create.flete.php",
			data: parametros,
			success: function(response){
					window.location = "http://control.timsalzc.com/Timsa/html/TIMSA.php";
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet" + xhr.responseText);
			}

		});

		$('#createFlete button').addClass("disabled");
		$('#createFlete button').attr("disabled",false);

	});

//esconde la busqueda de socios, ya que es una busqueda opcional.

$('#busquedaSocios').hide();

//Accion de Select, que modifica el tipo de seleccion. Oculta las opciones necesarias y muestra otras.

	$('#optionVal').change( function(){
		if($(this).val() == 0){
			// Si es una busqueda via economico, habilita lo necesario
			$('#busquedaSocios').fadeOut();
			$('#busquedaEconomico').fadeIn();
			$('#EconomicoTab').empty();
			$('#OperadorTab').empty();

			// Limpia los valores en la tabla de resultados, para que no se vean afectados
			// al momento de crear el flete.

			$('#Socio').empty();
			$('#Socio').append("Sin especificar");
			$('#Socio').attr("title","");

			$('#Economico').empty();
			$('#Economico').append("Sin especificar");
			$('#Economico').attr("title","");

			$('#Operador').empty();
			$('#Operador').append("Sin especificar");
			$('#Operador').attr("title","");
			
		}
		else{
			// Si es una busqueda via Socio, habilita y deshabilita lo necesario
			$('#busquedaEconomico').fadeOut();
			$('#busquedaSocios').fadeIn();
			$('#EconomicoTab').empty();
			$('#OperadorTab').empty();

			// Limpia los valores en la tabla de resultados, para que no se vean afectados
			// al momento de crear el flete.

			$('#Socio').empty();
			$('#Socio').append("Sin especificar");
			$('#Socio').attr("title","");

			$('#Economico').empty();
			$('#Economico').append("Sin especificar");
			$('#Economico').attr("title","");

			$('#Operador').empty();
			$('#Operador').append("Sin especificar");
			$('#Operador').attr("title","");
		}
	});

	$('#buscar').click(function(){
		var economico = $(this).parent().children('input').val();

		var parametros = { "economico" : economico, "action" : "economico"};

		$('#OperadorTab').empty();
		$('#EconomicoTab').empty();
		$("#Economico").empty();
		$('#Economico').attr("title","");
		$("#Economico").append("Sin asignar");
		$('#Socio').empty();
		$('#Socio').append("Sin asignar");
		$('#Socio').attr("title","");
		$('#Operador').empty();
		$('#Operador').append("Sin asignar");
		$('#Operador').attr("title","");

		$.ajax({
			beforeSend : function(){			
			},
			cache : false,
			type  : 'POST',
			dataType : 'json',
			url   : '../../includes/busqueda.economico.php',
			data  : parametros,
			success : function(response){
				if(response.contenido.length == 74){
		            			$('#EconomicoTab').append("<h1> Este Socio no Posee economicos </h1>");
		            		}
		            		else
		            			{
		            			$('#EconomicoTab').append(response.contenido);
		            		  }
			},
			error : function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet");
			}
		});

	});

	$('#busquedaTecla').keyup(function(){

		var economico = $(this).val();

		var parametros = { 
			"economico" : economico,
			 "action" : "economico"
			};

		$('#OperadorTab').empty();
		$('#EconomicoTab').empty();
		$("#Economico").empty();
		$('#Economico').attr("title","");
		$("#Economico").append("Sin asignar");
		$('#Socio').empty();
		$('#Socio').append("Sin asignar");
		$('#Socio').attr("title","");
		$('#Operador').empty();
		$('#Operador').append("Sin asignar");
		$('#Operador').attr("title","");

		$.ajax({
			beforeSend : function(){			
			},
			cache : false,
			type  : 'POST',
			dataType : 'json',
			url   : '../../includes/busqueda.economico.php',
			data  : parametros,
			success : function(response){
				if(! (response.socio == "correcto")){
		            			$('#EconomicoTab').append("<h4> No se encuentran economicos </h4>");
		            		}
		            		else
		            			{
		            			$('#EconomicoTab').append(response.contenido);
		            				if($('#preparado').is(":checked")){
		            					//$( "." ).each(function() {
										//});
		            				}
		            		  }
			},
			error : function(xhr, ajaxOptions, thrownError){
					alert("error, comprueba tu conexion a internet");
			}
		});
	});

$('#botonGroupEconomicoViaNumeroEconomico button').live("click", function (){
		$('#Economico').empty();
		$('#Economico').append($(this).attr("title"));
		$('#Economico').attr("title", $(this).text());

		$('#OperadorTab').empty();

		var parametros = { "economico" : $(this).text(),
							"Socio"    : $(this).attr("val"),
							"action"   : "buscarEconomico"
						};
		$.ajax({
		        beforeSend: function(){
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../../includes/busqueda.economico.php",
		            data: parametros,
		            success: function(response){
		            			$('#OperadorTab').append(response.contenido);
		            			$('#Socio').empty();
		            			$('#Socio').append(response.socio);
		            			$('#Socio').attr("title", parametros['Socio']);              	           	
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		            	alert("error, comprueba tu conexion a internet");
		                $('#EconomicoTab').append(xhr.responseText);            
		            }
		        });
	});

$('#preparado').click(function(){
	if($('#preparado').is("checked")){
		$('.economicosButtons').removeClass('disabled');
		$('.economicosButtons').attr("disabled", false);
	}
})

	

//termina On document Ready
});
