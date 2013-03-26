$(function(){

	$('#detalleFlete').hide();

	$('#tabla table button').click(function(){
			$value =  $(this).parent().parent().children('td:eq(0)').text();

			var parametros = { "value" : $value};

			$.ajax({
		        beforeSend: function(){
		           $('#loader .ajaxLoader').show("fade");
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../includes/detalles.flete.php",
		            data: parametros,
		            success: function(response){
		            	$('#loader .ajaxLoader').hide();

		            	// Validar mensaje de error
		            	if(response.respuesta == false){
		            	}
		            	else{

		            		// si es exitosa la operación
		                	// alert(response.contenido)		                	
		                	// Validad tipo de acción	                	
		                	$('#accordion2').empty();
		                	$('#accordion2').append(response.contenido); 

						}
		            	$('#formUsers .ajaxLoader').hide();

		            },
		            error:function(xhr, ajaxOptions, thrownError){

		            	$('#loader .ajaxLoader').hide();
		                $('#accordion2').append('Error general del sistema, intente mas tarde');	
		                alert(xhr.responseText);               
		            }
		        });

			$('#detalleFlete').show("slow");
			$('#tabla').slideUp();
		});


	$('#detalleFlete ul li a').click(function(){
			$('#detalleFlete').hide();
			$('#accordion2 ').empty();
			$('#tabla').show("fade");
		});

	$('body').on('click','#listaUsuariosOK a',function (e){
			

			// Valor de la acción
		$('#accion').val('editUser');

			// Id Usuario
		$('#id_user').val($(this).attr('href'));

			// Llenar el formulario con los datos del registro seleccionado
		$('#usr_nombre').val($(this).parent().parent().children('td:eq(0)').text());
		$('#usr_puesto').val($(this).parent().parent().children('td:eq(1)').text());
		$('#usr_nick').val($(this).parent().parent().children('td:eq(2)').text());

			// Seleccionar status
		$('#usr_status option[value='+ $(this).parent().parent().children('td:eq(3)').text() +']').attr('selected',true);

			// Abrimos el Formulario

		});	

	$('#finalizarFlete').live('click', function(){
		var parametros = { "value" : $value};

			$.ajax({
		        beforeSend: function(){
		        },
		            cache: false,
		            type: "POST",
		            dataType: "json",
		            url:"../includes/finalizar.flete.php",
		            data: parametros,
		            success: function(response){
		            	alert("Flete Finalizado");
		            },
		            error:function(xhr, ajaxOptions, thrownError){	
		                alert("Error");               
		            }
		        });

	});

});

