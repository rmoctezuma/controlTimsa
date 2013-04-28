$(function(){
	$('#detallesFlete').hide();

	$('.demo').click(function(){

			var value =  $(this).parent().parent().children('td:eq(0)').text();

			var parametros = { "value" : value};

			$.ajax({
		        beforeSend: function(){
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../includes/detalles.flete.php",
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
		                	$('#titulo').empty();
		                	$('#titulo').append('<a href="#" id="back"><img src="http://control.timsalzc.com/Timsa/img/back-arrow.png" class="img-rounded"></a>  Detalles de Flete ' + value);
		                	$('#titulo').val(value);

						}

		            },
		            error:function(xhr, ajaxOptions, thrownError){

		            	$('#loader .ajaxLoader').hide();
		                $('#accordion2').append('Error general del sistema, intente mas tarde');	
		                alert(xhr.responseText);               
		            }
		        });

			$('#InfoFletes').hide();
			$('#detallesFlete').show();

	});

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
		if($('#status').text() == "Activo"){
			$('#panelBotones').hide("fast");
			$('#confirmacionFlete').show("fast");
		}
		else{
			$('#panelBotones h4').text('Solo se pueden finalizar Fletes Activos');
		}
	});
//Boton cancelar. Oculta panel de confirmacion, y muestra panel DetalleFlete.

	$('#cancelar').click(function(){
		$('#confirmacionFlete').hide("fast");
		$('#panelBotones').show("fast");
	});

//Boton confirmar. Termina el flete.
 
 	$('#confirmar').click(function(){
 		
 		var value =  $('#titulo').val(); //obtiene el id del Flete
 		var status =  $('#status').val();
 		var economico =  $(this).parent().parent().children('td:eq(2)').text();

			var parametros = { "value" : value, "status": status, "economico": economico};

			$.ajax({
		        beforeSend: function(){
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../includes/terminar.flete.php",
		            data: parametros,
		            success: function(response){

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
		            	$('#reutilizarFlete').empty();
		            	$('#reutilizarFlete').append('<h1><a id="newBack"><img src="http://control.timsalzc.com/Timsa/img/back-arrow.png"></a>  Reutilizar Flete</h1>');
		            	$('#reutilizarFlete').append(response.forma);
		            	$('#reutilizarFlete').show();
		            },
		            error:function(xhr, ajaxOptions, thrownError){
		                alert(xhr.responseText);
		                alert("error");               
		            }
			});
	});

	$('#newBack').live("click",function(){
		$('#reutilizarFlete').hide("fast");
		$('#detallesFlete').show("fast");
	});
});
