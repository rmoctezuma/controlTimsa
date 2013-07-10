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


			$operador = new Operador;
			$operador->getOperadorFromID($idActual);

			if($_FILES['archivo'] && !empty($_FILES['archivo'])){

				if ((($_FILES["archivo"]["type"] == "image/gif") ||
				    ($_FILES["archivo"]["type"] == "image/jpeg") ||
				    ($_FILES["archivo"]["type"] == "image/pjpeg")) &&
				    ($_FILES["archivo"]["size"] < 60000)) {

						if (! ($_FILES["archivo"]["error"] > 0) ) {
	        		      	$num = rand(1,100) . rand(1,100);

	        		      	move_uploaded_file($_FILES["archivo"]["tmp_name"],
	                  							"../img/". $num  . $_FILES["archivo"]["name"]  );

	        		      	$mensajeImagen .= "<h2>Imagen de operador subida Correctamente</h2>";
	        		      	$ruta = '../img/' . $num .  $_FILES["archivo"]["name"];
					      }

					      if($ruta == "" ){
					      	//$ruta = "../img/descarga.jpg";
					      }
				}
			}

			if($operador->get_id()){ // Comprueba que exista el operador.


					$update = new Update();
					$camposUpdate =  array("Nombre"     => $nombre,
											"ApellidoP" => $apellidop,
											"ApellidoM" => $apellidom,
											"Telefono"  => $telefono,
											"CURP"      => $curp,
											"RC"    	=> $rc
											);

					if($ruta){
						$camposUpdate["rutaImagen"] = $ruta;
					}


					$camposWhereUpdate = array("Eco" => $idActual );

					$update->prepareUpdate("Operador", $camposUpdate, $camposWhereUpdate);
					$update->createUpdate();

				
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