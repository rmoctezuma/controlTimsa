<?php

require_once("Objetos/Operador.php");
require_once("Objetos/Economico.php");
require_once("Objetos/Cliente.php");
require_once("Objetos/Flete.php");
require_once("Objetos/Update.php");

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
			if ($flete->get_FleteHijo) {

				$FleteHijo = $flete->get_FleteHijo();

				$update = new Update();
				$camposUpdate =  array("Operador" => $_POST['value'] );
				$camposWhereUpdate = array("idFlete" => $FleteHijo);

				$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();

			}


			if ($flete->get_FletePadre) {

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
			if ($flete->get_FleteHijo) {

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


			if ($flete->get_FletePadre) {

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

			$clienteActual = $flete->get_Sucursal();

			
			$contenido .= "Flete Actualizado";
			break;
	}
}

$resultados  = array('contenido' => $contenido);

echo json_encode($resultados);

?>