$(function(){
	$('#formularioCuota').validate();

	$('#formCuota').hide();

	$('#nuevaCuota').click(function(){
		$('#principalForm').hide("fast");
		$('#formCuota').show('fade');
	});

	$('#botonCancelar').click(function(){
		$('#principalForm').show("fade");
		$('#formCuota').hide('fast');
	});

});