$(function(){
	$('#detallesFlete').hide();

	//Boton de detalle en tabla de fletes.
	//Se despliega el detalle de los fletes, y las acciones a realizar sobre este.
	$('body').on('click', '.demo',   function(e){

			e.preventDefault();

			dia = $(this).parent().parent().parent().parent().parent().parent().attr('id');
			anio = $(this).parent().parent().parent().parent().parent().parent().attr('anio');

			var value =  $(this).parent().parent().children('td:eq(0)').text();//toma el id de la casilla
			var viaje =  $(this).parent().parent().children('td:eq(6)').text();

			var parametros = { "value" : value,
								"viaje" : viaje}; //segun el id, se realiza la consulta del flete

			$.ajax({
		        beforeSend: function(){
		        	$('#accordion3').empty();
		            $('#accordion3').append("<img class='text-center' src='../img/loading.gif'>");
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../includes/Flete.Detallado.php",
		            data: parametros,
		            success: function(response){

		            	// Validar mensaje de error
		            	if(response.respuesta == false){
		            	}
		            	else{
		            		// si es exitosa la operación
		                	// alert(response.contenido)		                	
		                	// Validad tipo de acción	                	
		                	$('#accordion3').empty();
		                	$('#accordion3').append(response.contenido);
		                	//Se rellena el acordeon y se agrega un comando de navegacion
		                	$('#titulo').empty()
		                				.append('<a href="#" id="back"><img src="http://control.timsalzc.com/Timsa/img/back-arrow.png" class="img-rounded"></a>  Detalles de Flete ' + value)
		                				.val(value)
		                				.data('dia', dia)
		                				.data('anio', anio);

						}

		            },
		            error:function(xhr, ajaxOptions, thrownError){

		            	$('#loader .ajaxLoader').hide();
		                $('#accordion2').append('Error general del sistema, intente mas tarde');	
		                $('#accordion3').empty();
		                $('#accordion3').append( xhr.responseText);               

		            }
		        });

			$('#InfoFletes').hide();
			$('#detallesFlete').show();

	});
	//navegacion. 
	$('#back').live("click",function(){
			$('#InfoFletes').show();
			$('#detallesFlete').hide();
			$('#confirmarReutilizarFletes').hide();
			$('#confirmacionFlete').hide();
	});

//Acciones Finalizar Flete.
$('#confirmacionFlete').hide();

//Accion de finalizar flete. Oculta detalles de flete, y muestra un panel de confirmacion.
	$('#finalizarFlete').live("click",function(){
		$('#confirmar').data('action', 'terminar');
		$('#textoPregunta').text("¿Realmente desea terminar el flete?");
		$('#confirmacionFlete').show("fast");
		$('#panelBotones').hide("fast");
	});
//Boton cancelar. Oculta panel de confirmacion, y muestra panel DetalleFlete.

	$('#cancelar').click(function(){
		$('#textoPregunta').text("¿Realmente desea cancelar el flete?");
		$('#confirmacionFlete').hide("fast");
		$('#panelBotones').show("fast");
	});

//Boton confirmar. Termina el flete.
 
 	$('#confirmar').click(function(){
 		var status = "";

 		if($('#confirmar').data('action') == "cancelar"){
 				status = "Cancelado";
 		}
 		else if($('#confirmar').data('action') == "terminar"){
 			status = "Completo";
 		}

 			parametros = {'flete' 		: $('#titulo').val(),
 						  'tipo'  		: "Status",
 						  'nuevoStatus' :  status };

 			parametros.tipo_cambio = status;

 				$.ajax({
 			        beforeSend: function(){
 			        },
 			            cache: false,
 			            type: "POST",
 			            dataType: "json",
 			            url:"../includes/UpdateCamposFlete.php",
 			            data: parametros,
 			            success: function(response){
 			            	$('#reutilizar').attr('disabled', true);
 			            	$('#finalizarFlete').attr('disabled', true);
 			            	$('#cancelarFlete').attr('disabled', true);
 			            	$('#definicionEstados').empty();
 			            	$('#confirmacionFlete').hide("fast");
 			            	$('#panelBotones').show("fast");


 			            	if($('#confirmar').data('action') == "cancelar"){
 			            		$('#textoEstado').attr('class', 'label label-important');
 			            		$('#textoEstado').empty();
 			            		$('#textoEstado').append('<h4>El Flete fue Cancelado</h4>');
 			            		$('#facturarFlete').attr('disabled', true);

 			            	}
 			            	else if($('#confirmar').data('action') == "terminar"){
 			            		$('#facturarFlete').attr('disabled', false);
 			            		$('#textoEstado').attr('class', 'label label-success');
 			            		$('#textoEstado').empty();
 			            		$('#textoEstado').append('<h4>Flete Completo</h4>');
 			            	}

		            		 $('.botonesUpdate').each(function (index){
		            		 	 	$(this).attr('disabled', true);
		            		 	 	
		            			});
 			            	

 			            	refrescarEstadoFlete();


 			            },
 			            error:function(xhr, ajaxOptions, thrownError){

 			            	$('#loader .ajaxLoader').hide();
 			                $('#accordion2').append('Error general del sistema, intente mas tarde');	
 			                alert(xhr.responseText);               
 			            }
 				});


	});

//Acciones Reutilizar

$('#confirmarReutilizarFletes').hide();

	$('#reutilizar').live("click", function(){
		$('#panelBotones').hide("fast");
		$('#confirmarReutilizarFletes').show("fast");
	});

	
	$('.contenedoresAcceso').click(function(){

		if($(this).val() != "cancelar"){

		parametros = { "flete" 		  : $('#titulo').val(),
					   "contenedores" : $(this).val()
					 };

		$.ajax({
		        beforeSend: function(){
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../includes/create.campos.Reutilizado.php",
		            data: parametros,
		            success: function(response){
		            	$('#detallesFlete').hide();

		            	var reutilizarFlete = 
		            	$('#reutilizarFlete').empty()
		            						.append('')
		            						.append(response.forma)
		            						.show();
		            	if(parametros['contenedores'] == "true"){
		            		
		            		 var $radios = $('#opcionesViaje').children('input:radio[name=tipoViaje]');
							    if($radios.is(':checked') === false) {
							    	if(response.viaje == "Sencillo"){
							    		$radios.filter('[value=Sencillo]').prop('checked', true);
							    		$radios.filter('[value=Sencillo]').click();
							    	}
							    	else if (response.viaje == "Full") {
							        	$radios.filter('[value=Full]').prop('checked', true);
							        }
							        else{
							        	$('#alertas').append("<div class='alert'>\
								                               <button type='button' class='close' data-dismiss='alert'>&times;</button>\
								                               <strong>Observacion.</strong> El flete no llevaba contenedores\
								                              </div>'"
							                              	);
							        }
							    }
		            	}
		            	else{
		            		$('#nuevosContenedores').hide();
		            	}

		            	$('#Cliente').change();
		            	
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		                alert(xhr.responseText);
		                alert("error");
		            }
			});
		}
		else{
				$('#panelBotones').show("fast");
				$('#confirmarReutilizarFletes').hide("fast");
		}
	});

	$('#newBack').live("click",function(){
		$('#reutilizarFlete').hide("fast");
		$('#detallesFlete').show("fast");
	});

	//Se hace cargo del control del formulario de los contenedores,
	//segun la accion del radio desglosa, la informacion necesaria.
	$('input[name=tipoViaje]').live("click", function(){
		$('#nuevosContenedores').show('fade');

		if($(this).val() == "Sencillo" ){
			$('#contenedor1').show('fade');
			$('#contenedor2').hide('fade');
		}
		else if($(this).val() == "Full"){
			$('#contenedor2').show('fade');
			$('#contenedor1').show('fade');
		}

					

	});

	$('.sellos').live("change",function(){
		var contenedor;

		if($(this).attr('numero') == '1'){
			contenedor = 0;
		}
		else{
			contenedor = 3;

		}

		$(this).parent().children('div').empty();
		$(this).parent().children('div').append('<h4>Sellos por contenedor</h4>');

		for (var i = 1; i <= $(this).val(); i++) {
			$(this).parent().children('div').append('<label>Sello<input required type="text" name="sello' +( i + contenedor )+ '"></label>');
		};

	});

	$('#formaReutilizado').live('click', function(){
		$('#formaReutilizado').validate();
	});



	$('#Cliente').live('change', function(){
		var parametros = {"cliente" : $(this).val()}

		$.ajax({
		        beforeSend: function(){
		        	$('#sucursales').empty();
		        	$('#sucursales').append("<img class='center' src='../img/loading.gif'>");
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../includes/consulta.Sucursales.php",
		            data: parametros,
		            success: function(response){
		            	$('#sucursales').empty();
		            	$('#sucursales').append(response.contenido);

		            	$("input:radio[name=sucursal]:first").click();
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		                alert(xhr.responseText);
		                alert("error");
		            }
			});
	});

	$('input[name=sucursal]').live("click", function(){
		var parametros = {"sucursal" : $(this).val() }

		$.ajax({
		        beforeSend: function(){
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../includes/consulta.cuota.php",
		            data: parametros,
		            success: function(response){
		            	$('#numeroCuota').val(response.contenido);
		            	$('#LugarCuota').val(response.nombre);
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		                alert(xhr.responseText);
		                alert("error");
		            }
			});
	})

	$('#cambioOperador').live("click", function(){
		
		var flete = $('#flete').val();

		parametros = { "flete" : flete,
						"tipo" : "Operador"}

		$.ajax({
			beforeSend: function(){
			},
			    cache: false,
			    type: "POST",
			    dataType: "json",
			    url:"../includes/informacion.campos.php",
			    data: parametros,
			    success: function(response){
			    	$('#datosOperador').data( 'tipo', "Operador" );
			    	$('#datosOperador').data( 'contenido', $('#datosOperador').html() );
			    	$('#datosOperador').empty();
			    	$('#datosOperador').append(response.contenido);
			    },
			    error:function(xhr, ajaxOptions, thrownError){
			        alert(xhr.responseText);
			        alert("error");
			    }
		});
	});

	$('#cambioEconomico').live("click", function(){
		var flete = $('#flete').val();

		parametros = { "flete" : flete,
						"tipo" : "Economico"}

		$.ajax({
			beforeSend: function(){
			},
			    cache: false,
			    type: "POST",
			    dataType: "json",
			    url:"../includes/informacion.campos.php",
			    data: parametros,
			    success: function(response){
			    	$('#datosEconomico').data( 'tipo', "Economico" );
			    	$('#datosEconomico').data( 'contenido', $('#datosEconomico').html() );
			    	$('#datosEconomico').empty();
			    	$('#datosEconomico').data( 'cambioEconomico', response.contenido ); 
			    	$('#datosEconomico').append(response.contenido);
			    	$('#selectEconomicos').change();
			    },
			    error:function(xhr, ajaxOptions, thrownError){
			        alert(xhr.responseText);
			        alert("error");
			    }
		});


	});

	$('#cambioCliente').live("click", function(){
		var flete = $('#flete').val();

		parametros = { "flete" : flete,
						"tipo" : "Cliente"}

		$.ajax({
			beforeSend: function(){
			},
			    cache: false,
			    type: "POST",
			    dataType: "json",
			    url:"../includes/informacion.campos.php",
			    data: parametros,
			    success: function(response){
			    	$('#datosCliente').data( 'tipo', "Cliente" );
			    	$('#datosCliente').data( 'contenido', $('#datosCliente').html() );
			    	$('#datosCliente').empty();
			    	$('#datosCliente').data('cliente' , response.contenido);
			    	$('#datosCliente').append(response.contenido);
			    	$('#cambio_cliente').change();
			    },
			    error:function(xhr, ajaxOptions, thrownError){
			        alert(xhr.responseText);
			        alert("error");
			    }
		});
	});

	$('#selectEconomicos').live('change', function(){
		var value = $(this).val();

		parametros = {"economico" : value,
					  "tipo" 	  : "Operador" }

		$.ajax({
			beforeSend: function(){
			},
			    cache: false,
			    type: "POST",
			    dataType: "json",
			    url:"../includes/informacion.campos.php",
			    data: parametros,
			    success: function(response){
			    	$('#datosEconomico').empty();
			    	$('#datosEconomico').append($('#datosEconomico').data('cambioEconomico'));

			    	$('#selectEconomicos option[value="' + parametros.economico + '"]').prop('selected', true)

			    	$('#datosEconomico').append(response.contenido);
			    },
			    error:function(xhr, ajaxOptions, thrownError){
			        alert(xhr.responseText);
			        alert("error");
			    }
		});
		
	});

	$('#cambio_cliente').live("change", function(){
		parametros = { "cliente" : $('#cambio_cliente').val(),
						"tipo"   : "Sucursal"  };

		$.ajax({
			beforeSend: function(){
			},
			    cache: false,
			    type: "POST",
			    dataType: "json",
			    url:"../includes/informacion.campos.php",
			    data: parametros,
			    success: function(response){
			    	$('#datosCliente').empty();
			    	$('#datosCliente').append($('#datosCliente').data('cliente'));
			    	$('#datosCliente').append(response.contenido);
			    	$('#cambio_cliente option[value="' + parametros.cliente + '"]').prop('selected', true)

			    },
			    error:function(xhr, ajaxOptions, thrownError){
			        alert(xhr.responseText);
			        alert("error");
			    }
		});

	});



	$('.cancelar').live("click", function(){
		var div =  $(this).parent().parent().parent().parent().parent().parent();
		div.empty();
		div.append( div.data('contenido')   );
	});

	$('.update').live('click', function(){
		var flete = $('#flete').val();
		var div =  $(this).parent().parent().parent().parent().parent().parent();
		var tipo = div.data( 'tipo' );

		var value = $(this).parent().parent().parent().children().children().children('select').val() ;

		parametros = { "tipo" 		: tipo,
						"value"  	: value,
						"flete"		: flete }



		if(tipo == 'Economico'){
			var economico = $('#selectEconomicos').val();
			parametros.economico = economico;

			var socio = $('#nuevoSocio').val();
			parametros.socio = socio;
		}

		$.ajax({
			beforeSend: function(){
			},
			    cache: false,
			    type: "POST",
			    dataType: "json",
			    url:"../includes/UpdateCamposFlete.php",
			    data: parametros,
			    success: function(response){
			    	alert(response.contenido);
			    },
			    error:function(xhr, ajaxOptions, thrownError){
			        alert(xhr.responseText);
			        alert("error");
			    }
		});

	});

	$('#cancelarFlete').live('click', function(){
		$('#panelBotones').hide("fast");
		$('#confirmacionFlete').show("fast");

		$('#confirmar').data('action', 'cancelar');
	});

	$('#cambiarEstado').live('click', function(){
		var status =  $('input[name=status]:checked').val();

		parametros = {'flete' 		: $('#titulo').val(),
					  'tipo'  		: "Status",
					  'nuevoStatus' :  status};

			$.ajax({
		        beforeSend: function(){
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../includes/UpdateCamposFlete.php",
		            data: parametros,
		            success: function(response){
		            	if(status == 'Activo'){
		            		$('#textoEstado').attr('class', 'label label-info');
		            		$('#textoEstado').empty();
		            		$('#textoEstado').append('<h4>Flete Activo</h4>');
		            		$('#finalizarFlete').attr('disabled', true);
		            	}
		            	else if(status == 'Programado'){
		            		$('#textoEstado').attr('class', 'label label-warning');
		            		$('#textoEstado').empty();
		            		$('#textoEstado').append('<h4>Flete Programado</h4>');
		            		$('#finalizarFlete').attr('disabled', true);
		            	}
		            	else if(status == 'Pendiente Facturacion'){
		            		$('#textoEstado').attr('class', 'label');
		            		$('#textoEstado').empty();
		            		$('#textoEstado').append('<h4>Flete Pendiente</h4>');
		            		$('#finalizarFlete').attr('disabled', false);
		            	}


		            	refrescarEstadoFlete();
		            },
		            error:function(xhr, ajaxOptions, thrownError){

		            	$('#loader .ajaxLoader').hide();
		                $('#accordion2').append('Error general del sistema, intente mas tarde');	
		                alert(xhr.responseText);               
		            }
			});
	});

});

function refrescarEstadoFlete(){

	parametros = { "dia" : $('#titulo').data('dia') ,
				   "anio": $('#titulo').data('anio')
				 }

	$.ajax({
        beforeSend: function(){
        },
            cache: false,
            type: "POST",
            dataType: "json",
            url:"../includes/RefrescarEstadoFletes.php",
            data: parametros,
            success: function(response){

            	var dia = $('#' + parametros.dia);
            	dia.empty();
            	dia.append(response.contenido);

            },
            error:function(xhr, ajaxOptions, thrownError){

            	$('#loader .ajaxLoader').hide();
                $('#accordion2').append('Error general del sistema, intente mas tarde');	
                alert(xhr.responseText);               
            }
	});

}

