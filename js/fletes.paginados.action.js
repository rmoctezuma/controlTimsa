$(function(){
	$('#detallesFlete').hide();

	//Boton de detalle en tabla de fletes.
	//Se despliega el detalle de los fletes, y las acciones a realizar sobre este.
	$('.demo').click(function(){

			var value =  $(this).parent().parent().children('td:eq(0)').text();//toma el id de la casilla

			var parametros = { "value" : value}; //segun el id, se realiza la consulta del flete

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
		                	$('#titulo').empty();//Se rellena el acordeon y se agrega un comando de navegacion
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
							        $radios.filter('[value=Full]').prop('checked', true);
							    }
		            	}
		            	else{
		            		$('#nuevosContenedores').hide();
		            	}
		            	
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
	$('input[type=radio]').live("click", function(){
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
			$(this).parent().children('div').append('<label>Sello<input type="text" name="sello' +( i + contenedor )+ '"></label>');
		};

	});

	$('#formaReutilizado').live('click', function(){
		$('#formaReutilizado').validate();
	});
});

