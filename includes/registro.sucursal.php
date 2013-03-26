<?php

include('../includes/generic.connection.php');
	$result = "";

	if(isset($_POST) && !empty($_POST)){
		$nombre   = $_POST['nombre'];
		$telefono = $_POST['telefono'];
		$cliente = $_POST['cliente'];
		$cuota = $_POST['cuota'];
		$lat  = $_POST['Lat'];
		$long = $_POST['Long'];

		try {
			$PDOmysql = consulta();
			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$PDOmysql->beginTransaction();

			$sql = 'INSERT INTO ClienteDireccion(NombreSucursal, Telefono, Cliente_idCliente, Cuota_idCuota, Lat, Lon) values(:nombre, :telefono, :cliente, :cuota, :lat, :lon)';

                  $nwestmt = $PDOmysql->prepare($sql);
                  $nwestmt->bindParam(':nombre',$nombre);
                  $nwestmt->bindParam(':telefono',$telefono);
                  $nwestmt->bindParam(':cliente',$cliente);
                  $nwestmt->bindParam(':cuota',$cuota);
                  $nwestmt->bindParam(':lat',$lat);
                  $nwestmt->bindParam(':lon',$long);
                  $nwestmt->execute();

                  $result = "correcto";

            $PDOmysql->commit();

             } catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $PDOmysql->rollBack();
		    echo $ex->getMessage();
		    $respuestaOK = false;
		}
	}

	$array  = array('resultado' => $result );

	echo json_encode($array);

?>