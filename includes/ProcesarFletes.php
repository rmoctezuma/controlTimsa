<?php
if(isset($_POST) && !empty($_POST)){
		if (isset($_POST['tipoViaje'])  && !empty($_POST['tipoViaje'])) {

			$flete_raiz = $_POST['fletePadre'];
			$Agencia = $_POST['Agencia'];
			$Sucursal = $_POST['sucursal'];
			$datosContenedor   = new ListaContenedorViaje;

			$flete = new Flete;
			$flete->set_Agencia($Agencia);
			$flete->set_Sucursal($Cliente);

			$flete->set_Operador($_POST['Operador']);
			$flete->set_Economico($_POST['Economico']);
			$flete->set_Socio($_POST['Socio']);
			$flete->set_FletePadre($_POST['fletePadre']);

			$flete->set_comentarios($_POST['comentarios']);

			$flete->set_Sucursal($Sucursal);

			$flete->insertar_flete();

			$numeroFlete =  $flete->get_idFlete();


			switch ($_POST['tipoViaje']) {
				case 'Sencillo':

					$listaSellos = validarSellosContenedor($_POST['sellos1'],1);
					$contenedor = capturarDatosContenedores(1, $listaSellos);
					$datosContenedor->append($contenedor); 

					break;
				case 'Full':
					$listaSellos = validarSellosContenedor($_POST['sellos1'],1);
					$contenedor = capturarDatosContenedores(1, $listaSellos);
					$datosContenedor->append($contenedor); 

					$listaSellos = validarSellosContenedor($_POST['sellos2'],2);
					$contenedor = capturarDatosContenedores(2, $listaSellos);
					$datosContenedor->append($contenedor); 

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

		$listaSellos = new listaSellos;

		for ($i=1; $i <= $cantidad; $i++) {
			$nombreSello =  $_POST['sello'.( $i + $var ).''];
			$sello = new Sello;
			$sello->createSello($nombreSello,$i);

			$listaSellos->append($sello);
		}

		return $listaSellos;
	}

	function capturarDatosContenedores($numero,$listaSellos){

		$contenedor = new Conenedor;
		$contenedor->createContenedor(
									   $_POST['contenedor'. $numero],
									   $numeroFlete,
									   $_POST['tamaño'. $numero] ,
									   $_POST['workorder' . $numero],
									   $_POST['booking'. $numero],
									   $listaSellos
									 );

		return $contenedor;
	} 

}

?>