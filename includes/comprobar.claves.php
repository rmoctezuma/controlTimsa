<?php

include('../includes/generic.connection.php');
require_once('../includes/Objetos/Operador.php');
require_once('../includes/Objetos/Economico.php');

$result = "";

if(isset($_POST) && !empty($_POST)){
	switch ($_POST['tipo']) {
		case 'Operador':

		if(empty($_POST['value'])){
			$result = '<span id="statusClaveModificada" value="false" class="label label-important">No permitido</span>';
			break;
		}

			$id = $_POST['value'];
			$actual = $_POST['actual'];

			if(strstr($id, ' ')){
				$result = '<span id="statusClaveModificada" value="false" class="label label-important">No permitido</span>';
				break;
			}

			$operador = new Operador;
			$operador->getOperadorFromID($id);

			if($id == $actual){
				$result = '<span id="statusClaveModificada" value="true" class="label label-success">Se mantiene clave</span>';
			}
			else{
				if($operador->get_id()){
					$result = '<span id="statusClaveModificada" value="false" class="label label-important">Activo</span>';
				}
				else{
					$result = '<span id="statusClaveModificada" value="true" class="label label-info">Libre<span>';
				}
			}

			

			break;
		case 'Economico':

			if(empty($_POST['value'])){
				$result = '<span id="statusClaveModificada" value="false" class="label label-important">No permitido</span>';
				break;
			}

				$id = $_POST['value'];

				if(strstr($id, ' ')){
					$result = '<span id="statusClaveModificada" value="false" class="label label-important">No permitido</span>';
					break;
				}

				$operador = new Economico;
				$operador-> createEconomicoFromID($id);

					if($operador->get_id()){
						$result = '<span id="statusClaveModificada" value="false" class="label label-important">Activo</span>';
					}
					else{
						$result = '<span id="statusClaveModificada" value="true" class="label label-info">Libre<span>';
					}
				

			break;
		
		default:
			# code...
			break;
	}
}

$array = array("contenido" => $result);

echo json_encode($array);

?>