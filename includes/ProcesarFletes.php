<?php
require("Objetos/Flete.php");
require_once("Objetos/Contenedor.php");
require_once("Objetos/CuotaViaje.php");
require_once("Objetos/ListaContenedorViaje.php");
require_once("Objetos/ListaSellos.php");
require_once("Objetos/Sello.php");



#try{

if(isset($_POST) && !empty($_POST)){
		if (isset($_POST['tipoViaje'])  && !empty($_POST['tipoViaje'])) {

			$flete_raiz = $_POST['fletePadre'];
			$Agencia = $_POST['Agencia'];
			$Sucursal = $_POST['sucursal'];

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
			#echo "El numero es :   " . $numeroFlete;

			$cuota = new CuotaViaje;
			$cuota->set_id_cuota($_POST['cuota']);
			$cuota->set_trafico($_POST['tipoTrafico']);
			$cuota->set_tipoViaje($_POST['tipoViaje']);

			$cuota->getDetalleCuota();

			$flete->set_CuotaViaje($cuota);
			$flete->generar_cuota_viaje();

			$datosContenedor   = new ListaContenedorViaje;

			switch ($_POST['tipoViaje']) {
				case 'Sencillo':

					$listaSellos = validarSellosContenedor($_POST['sellos1'],1);
					$contenedor = capturarDatosContenedores(1, $listaSellos, $numeroFlete);
					$datosContenedor->append($contenedor);

					break;
				case 'Full':
					$listaSellos = validarSellosContenedor($_POST['sellos1'],1);
					$contenedor = capturarDatosContenedores(1, $listaSellos);
					$datosContenedor->append($contenedor); 

					$listaSellos = validarSellosContenedor($_POST['sellos2'],2);
					$contenedor = capturarDatosContenedores(2, $listaSellos, $numeroFlete);
					$datosContenedor->append($contenedor); 

					break;		
			}

			$datosContenedor->insertarContenedores();


		}
	}
#} catch(Exception $e){
	#header("Location:control.timsalzc.com");
#}

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

	function capturarDatosContenedores($numero,$listaSellos, $flete){

		$contenedor = new Contenedor;
		$contenedor->createContenedor(
									   $_POST['contenedor'. $numero],
									   $flete,
									   $_POST['tamaño'. $numero] ,
									   $_POST['workorder' . $numero],
									   $_POST['booking'. $numero],
									   $listaSellos
									 );

		
		/*echo $contenedor->get_id();
		echo $contenedor->get_flete();
		echo $contenedor->get_tipo();
		echo $contenedor->get_workorder();
		echo $contenedor->get_booking();
		*/

		return $contenedor;
} 


?>
