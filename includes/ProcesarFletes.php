<?php
require("Objetos/Flete.php");
require_once("Objetos/Contenedor.php");
require_once("Objetos/CuotaViaje.php");
require_once("Objetos/ListaContenedorViaje.php");
require_once("Objetos/ListaSellos.php");
require_once("Objetos/Sello.php");
require_once("Objetos/Update.php");

#try{

if(isset($_POST) && !empty($_POST)){
		if (isset($_POST['tipoViaje'])  && !empty($_POST['tipoViaje'])) {
			//Se preparan las variables que se utilizaran a lo largo de este tipo de proceso.
			$flete_raiz = $_POST['fletePadre'];
			$Agencia = $_POST['Agencia'];
			$Sucursal = $_POST['sucursal'];
			//Se crea el objeto flete.
			$flete = new Flete;
			/*
				A partir de este momento se colocaran las llaves primarias de cada objeto dentro
				del Flete. El objeto Flete se encargara de incializar y operar conforme estos datos.
			*/

			//Se coloca El numero de agencia y el cliente dentro del flete.
			$flete->set_Agencia($Agencia);
			$flete->set_Sucursal($Cliente);
			// Se incializan los campos dentro del flete.
			$flete->set_Operador($_POST['Operador']);
			$flete->set_Economico($_POST['Economico']);
			$flete->set_Socio($_POST['Socio']);
			$flete->set_FletePadre($_POST['fletePadre']);
			//Se añaden los comentarios.
			$flete->set_comentarios($_POST['comentarios']);
			//Se añade la sucursal, para operaciones posteriores.
			$flete->set_Sucursal($Sucursal);


			//Este es el metodo, que se encarga de insertar toda la base del flete.
			//Conforme a los datos antes propuestos.
			$flete->insertar_flete();

			//Obtiene el ID del flete recientemente Insertado.
			$numeroFlete =  $flete->get_idFlete();

			//Si se envio un flete padre, es decir, se trata de un flete reutilizado
			// Entonces se cambia el estado del flete a Programado.
			// Y se coloca en el flete padre, una referencia a este flete reutilizado(hijo).

//****************************   OPERACIONES REUTILIZADO   *********************************
			if($flete_raiz){
				$update = new Update();
				$camposUpdate =  array("statusA" => "Programado");
				$camposWhereUpdate = array("idFlete" => $numeroFlete);

				$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();

				$update = new Update();
				$camposUpdate = array('FleteHijo' => $numeroFlete );
				$camposWhereUpdate = array("idFlete" => $flete_raiz);

				$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();
			}
//*************************************************************************************
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
					$contenedor = capturarDatosContenedores(1, $listaSellos, $numeroFlete);
					$datosContenedor->append($contenedor); 

					$listaSellos = validarSellosContenedor($_POST['sellos2'],2);
					$contenedor = capturarDatosContenedores(2, $listaSellos, $numeroFlete);
					$datosContenedor->append($contenedor); 

					break;		
			}

			$datosContenedor->insertarContenedores();

			header("Location:../html/fletes.php");
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
		return $contenedor;
} 


?>
