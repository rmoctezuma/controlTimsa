<?php


if(isset($_POST) && !empty($_POST)){

	if (isset($_POST['tipoViaje'])  && !empty($_POST['tipoViaje'])) {

		$flete_raiz = $_POST['fletePadre'];
		$Agencia = $_POST['Agencia'];
		$Cliente = $_POST['Cliente'];
		$sellosContenedores = array();
		$datosContenedor    = array();

		switch ($_POST['tipoViaje']) {
			case 'Sencillo':

				$sellosContenedores[] = validarSellosContenedor($_POST['sellos1'],1);
				$datosContenedor[]    = capturarDatosContenedores(1);
				break;
			case 'Full':

				$sellosContenedores[] = validarSellosContenedor($_POST['sellos1'],1);
				$datosContenedor[]     = capturarDatosContenedores(1);
				$sellosContenedores[] = validarSellosContenedor($_POST['sellos2'],2);
				$datosContenedor[]    = capturarDatosContenedores(2);
				break;		
		}

		



	}
}

function validarSellosContenedor($cantidad, $numero){
	if($numero != 1){
		$var = 3;
	}
	else{
		$var = 0;
	}

	$array = array();

	for ($i=1; $i <= $cantidad; $i++) {
		$array[$i] =  $_POST['sello'.( $i + $var ).''] ;
	}

	return $array;
}

function capturarDatosContenedores($numero){

	$datos = array('contenedor' => $_POST['contenedor'. $numero], 
						'workorder' => $_POST['workorder' . $numero],
						'booking'   => $_POST['booking'. $numero]);

	return $datos;
} 



?>