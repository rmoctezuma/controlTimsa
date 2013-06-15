<?php

require_once("Objetos/Operador.php");
require_once("Objetos/Economico.php");
require_once("Objetos/Cliente.php");
require_once("Objetos/Flete.php");

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

			$operadorNuevo = $_POST['operador'];

			$update = new Update();
			$camposUpdate =  array("statusA" => "Ocupado");
			$camposWhereUpdate = array("Eco" => $operadorNuevo );

			$update->prepareUpdate("Operador", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();

//********************************** Actualizar Flete Padre e HIjo ********************************
			if ($flete->get_FleteHijo) {

				$FleteHijo = $flete->get_FleteHijo();

				$update = new Update();
				$camposUpdate =  array("Operador" => $_POST['operador'] );
				$camposWhereUpdate = array("idFlete" => $FleteHijo);

				$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();

			}


			if ($flete->get_FletePadre) {

				$padre = $flete->get_FletePadre();

				$update = new Update();
				$camposUpdate =  array("Operador" => $_POST['operador'] );
				$camposWhereUpdate = array("idFlete" => $padre);

				$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();

			}

//*************************************************************************************************

			$update = new Update();
			$camposUpdate =  array("Operador" => $_POST['operador'] );
			$camposWhereUpdate = array("idFlete" => $numeroFlete);

			$update->prepareUpdate("Flete", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();


			break;
		
		case 'Economico':		
			break;

		case 'Cliente':
			break;
	}
}

$resultados  = array('contenido' => $contenido);

echo json_encode($resultados);

?>