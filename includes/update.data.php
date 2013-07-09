<?php
include('../includes/generic.connection.php');
require_once('../includes/Objetos/Operador.php');
require_once('../includes/Objetos/Update.php');

$modificarControl = false;

if(isset($_POST) && !empty($_POST)){
	switch ($_POST['tipo']) {
		case 'operador':

			$idActual = $_POST['controlOperador'];
			$nuevo    = $_POST['control'];

			$nombre =    $_POST['NombreOperador'];
			$apellidop = $_POST['ApellidoOperador'];
			$apellidom = $_POST['ApellidoMOperador'];
			$telefono =  $_POST['telefono'];
			$rc =        $_POST['rc'];
			$curp =      $_POST['curp'];

			echo $nombre;
			echo "<br>";
			echo $apellidop;
			echo "<br>";
			echo $apellidom;
			echo "<br>";
			echo $telefono;
			echo "<br>";
			echo $rc;
			echo "<br>";
			echo $curp;
			echo "<br>";



			$operador = new Operador;
			$operador->getOperadorFromID($idActual);

			if($operador->get_id()){ // Comprueba que exista el operador.

				if($idActual == $nuevo){ // Si se modificara el id del operador.

					$update = new Update();
					$camposUpdate =  array("Nombre" => $nombre,
											"ApellidoP" => $apellidop,
											"ApellidoM" => $apellidom,
											"R.C."  => $rc,
											"CURP"  => $curp,
											"Telefono" => $telefono
											);

					$camposWhereUpdate = array("Eco" => $idActual );

					$update->prepareUpdate("Operador", $camposUpdate, $camposWhereUpdate);
					$update->createUpdate();
				}
				else{
					/*
					$update = new Update();
					$camposUpdate =  array("statusA" => "Deprecated");
					$camposWhereUpdate = array("Eco" => $idActual );

					$update->prepareUpdate("Operador", $camposUpdate, $camposWhereUpdate);
					$update->createUpdate();
					*/
				}
				
			}
			else{
				$result = 'Operador no Encontrado';
			}

			break;
		
		default:
			# code...
			break;
	}
}

?>