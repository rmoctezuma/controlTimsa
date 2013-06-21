<?php

require_once("Objetos/Operador.php");
require_once("Objetos/Economico.php");
require_once("Objetos/Cliente.php");
require_once("Objetos/Flete.php");
require_once("Objetos/Update.php");
require_once("Objetos/Sucursal.php");

$contenido = "";

if(isset($_POST) && !empty($_POST)){
 
	$flete = new Flete;
	$flete->getFleteFromID($_POST['flete']);
	$numeroFlete = $_POST['flete'];

	switch ($_POST['tipo']) {
		case 'Operador':
			$operadorActual = $flete->get_Operador();

			$update = new Update();
			$camposUpdate =  array("statusA" => "Libre");
			$camposWhereUpdate = array("Eco" => $operadorActual->get_id() );

			$update->prepareUpdate("Operador", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();

			$operadorNuevo = $_POST['value'];

			$update = new Update();
			$camposUpdate =  array("statusA" => "Ocupado");
			$camposWhereUpdate = array("Eco" => $operadorNuevo );

			$update->prepareUpdate("Operador", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();

//********************************** Actualizar Flete Padre e HIjo ******************
			if ( $flete->get_FleteHijo() ) {

				$FleteHijo = $flete->get_FleteHijo();

				$update = new Update();
				$camposUpdate =  array("Operador" => $_POST['value'] );
				$camposWhereUpdate = array("idFlete" => $FleteHijo);

				$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();

			}


			if ( $flete->get_FletePadre() ) {

				$padre = $flete->get_FletePadre();

				$update = new Update();
				$camposUpdate =  array("Operador" => $_POST['value'] );
				$camposWhereUpdate = array("idFlete" => $padre);

				$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();

			}

//*************************************************************************************************

			$update = new Update();
			$camposUpdate =  array("Operador" => $_POST['value'] );
			$camposWhereUpdate = array("idFlete" => $numeroFlete);

			$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();

			$contenido .= "Flete Actualizado";

			break;
		
		case 'Economico':
//*****************************Operador*************************************
			$operadorActual = $flete->get_Operador();

			$update = new Update();
			$camposUpdate =  array("statusA" => "Libre");
			$camposWhereUpdate = array("Eco" => $operadorActual->get_id() );

			$update->prepareUpdate("Operador", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();

			$operadorNuevo = $_POST['value'];

			$update = new Update();
			$camposUpdate =  array("statusA" => "Ocupado");
			$camposWhereUpdate = array("Eco" => $operadorNuevo );

			$update->prepareUpdate("Operador", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();
//***************************Termina Operador**********************************
//***************************Inicia Update Economico***************************

			$economicoActual = $flete->get_Economico();

			$update = new Update();
			$camposUpdate =  array("statusA" => "Libre");
			$camposWhereUpdate = array("Economico" => $economicoActual->get_id() );

			$update->prepareUpdate("Economico", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();

			$economicoNuevo = $_POST['economico'];

			$update = new Update();
			$camposUpdate =  array("statusA" => "Ocupado");
			$camposWhereUpdate = array("Economico" => $economicoNuevo );

			$update->prepareUpdate("Economico", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();


//********************************** Actualizar Flete Padre o HIjo **************
			if ( $flete->get_FleteHijo() ) {

				$FleteHijo = $flete->get_FleteHijo();

				$update = new Update();
				$camposUpdate =  array("Operador" => $_POST['value'],
									   "Economico" => $_POST['economico'],
								  	   "Socio" 	  =>  $_POST['socio'] 
								  	   );
				$camposWhereUpdate = array("idFlete" => $FleteHijo);

				$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();

			}


			if ( $flete->get_FletePadre() ) {

				$padre = $flete->get_FletePadre();

				$update = new Update();
				$camposUpdate =  array("Operador" => $_POST['value'],
									   "Economico" => $_POST['economico'],
								  	   "Socio" 	  =>  $_POST['socio'] 
								  	   );
				$camposWhereUpdate = array("idFlete" => $padre);

				$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();

			}

//*************************************************************************************************

			$update = new Update();
			$camposUpdate =  array("Operador" => $_POST['value'],
								   "Economico" => $_POST['economico'],
								   "Socio" 	  =>  $_POST['socio'] 
								   );

			$camposWhereUpdate = array("idFlete" => $numeroFlete);

			$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();

			$contenido .= "Flete Actualizado";

			break;

		case 'Cliente':
			// Obtiene la cuota anterior del flete
			$cuota = $flete->get_CuotaViaje();

			//Coloca el trafico a como el usuario desee, sino lo pone como estaba en el flete.
			$trafico = "";

			if (isset($_POST['trafico']) && !empty($_POST['trafico'])) {
				$trafico = $_POST['trafico'];
			}
			else{
				$trafico = $cuota->get_trafico();
			}
			//Obtiene el tipo de viaje
			$tipoViaje = $cuota->get_tipoViaje();
			//Crea un objeto sucursal con los datos obtenidos, para obtener su cuota.
			$sucursal = new Sucursal;
			$sucursal->getSucursalFromID( $_POST['sucursal'] );
			//Obtiene la cuota que ira en el flete.
			$nuevaCuota = $sucursal->get_Cuota();
			$viaje = $nuevaCuota->get_trafico( $trafico );

			//Estos son los numeros que iran en la cuota del flete.
			$numero = $viaje[$tipoViaje];
			$cuotaNueva .=  $nuevaCuota->get_id() ;

			$camposUpdate = array('TipoCuota' => $numero,
			 					  'Cuota'     => $cuotaNueva,
			 					  'Sucursal'  => $_POST['sucursal'] 
			 					  );
			cambiarCuota($camposUpdate, $flete);

			$contenido .= "Flete Actualizado";

			break;

		case 'Status':
			$statusNuevo = $_POST['nuevoStatus'];
			$numeroFlete = $_POST['flete'];

			//Cambiar el status del flete

			$flete = new Flete;
			$flete->getFleteFromID($numeroFlete);

			cambiarStatusFlete( $flete, $statusNuevo );

			if($_POST['tipo_cambio'] == "Cancelado" || $_POST['tipo_cambio'] == "Completo"){

				if( $flete->get_FleteHijo() ){
					if($_POST['tipo_cambio'] == "Cancelado"){

						$hijo = new Flete;
						$hijo->getFleteFromID( $flete->get_FleteHijo() );

						cambiarStatusFlete( $hijo, $statusNuevo );

						releaseEconomicoAndOperador($flete);
					}
					
					else if( $_POST['tipo_cambio'] == "Completo" ){
						// Si el flete posee un hijo, comprobar si esta completo.
						// Si esta completo liberar economico y Operador.
						$hijo = new Flete;
						$hijo->getFleteFromID( $flete->get_FleteHijo() );
						if($hijo->get_status() == 'Completo' || $hijo->get_status() == 'Cancelado'){
							releaseEconomicoAndOperador($flete);
						}
					}
					
				}

				else if( $flete->get_FletePadre() ){
					if($_POST['tipo_cambio'] == "Cancelado" || $_POST['tipo_cambio'] == "Completo" ){
						$padre = new Flete;
						$padre->getFleteFromID( $flete->get_FletePadre() );
						// Comprobar si el flete padre esta completo, para
						// proceder al liberar economico y operador.
						if($padre->get_status() == 'Completo' || $padre->get_status() == 'Cancelado' ){
							releaseEconomicoAndOperador($flete);
						}

						if($_POST['tipo_cambio'] == "Cancelado"){
							removerHijo($padre);
						}
					}
				}

				else{
					releaseEconomicoAndOperador($flete);
				}
				
			}

			$contenido .= "Flete Actualizado";

			break;
	}
}

$resultados  = array('contenido' => $contenido);

echo json_encode($resultados);


	function releaseEconomicoAndOperador($flete){
		// Liberar Economico

		$economicoActual = $flete->get_Economico();

		$update = new Update();
		$camposUpdate =  array("statusA" => "Libre");
		$camposWhereUpdate = array("Economico" => $economicoActual->get_id() );

		$update->prepareUpdate("Economico", $camposUpdate, $camposWhereUpdate);
		$update->createUpdate();

		//Liberar Operador

		$operadorActual = $flete->get_Operador();

		$update = new Update();
		$camposUpdate =  array("statusA" => "Libre");
		$camposWhereUpdate = array("Eco" => $operadorActual->get_id() );

		$update->prepareUpdate("Operador", $camposUpdate, $camposWhereUpdate);
		$update->createUpdate();
	}

	function cambiarStatusFlete($flete, $status){

		$update = new Update();
		$camposUpdate =  array( "statusA" => $status );

		$camposWhereUpdate = array("idFlete" => $flete->get_idFlete() );

		$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
		$update->createUpdate();
	}

	function removerHijo($flete){
		$update = new Update();
		$camposUpdate =  array( "FleteHijo" => null );

		$camposWhereUpdate = array("idFlete" => $flete->get_idFlete() );

		$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
		$update->createUpdate();
	}

	function cambiarCuota($camposUpdate, $flete){
		$update = new Update;
		
		$camposWhereUpdate = array("NumFlete" => $flete->get_idFlete() );

		$update->prepareUpdate("Cuota_Flete", $camposUpdate, $camposWhereUpdate);
		$update->createUpdate();
	}

?>