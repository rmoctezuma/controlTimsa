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

	$('#back').click(function(){
			$('#InfoFletes').show();
			$('#detallesFlete').hide();
	});

});