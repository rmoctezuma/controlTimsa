<?php

if(isset($_POST) && !empty($_POST)){

$agencia = $_POST['agencia'];
$cliente = $_POST['cliente']; 
$cuota = $_POST['cuota'] ;
$socio = $_POST['socio'] ;
$operador = $_POST['operador'] ;
$economico = $_POST['economico'] ;
$numcuota = $_POST['numcuota'] ;
$comentarios = $_POST['comentarios'];
$contenedor = $_POST['contenedor'];
$workOrder = $_POST['workorder'];
$booking = $_POST['booking'];
$tipoContenedor = $_POST['tipoContenedor'];
$sello = $_POST['sello'];


$respuestaOK = false;

$mysqli = consulta();

	try {
		$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$mysqli->beginTransaction();

			$sql = 'update Operador set statusA = "Ocupado" where Eco = :operador';
			$stmt = $mysqli->prepare($sql);
			$stmt->bindParam(':operador',$operador);
			$stmt->execute();

			$sql = 'update Economico set statusA = "Ocupado" where Economico = :economico';
			$stmt = $mysqli->prepare($sql);
			$stmt->bindParam(':economico',$economico);
			$stmt->execute();


			$sql = 'insert into Flete(Agencia_idAgente, Operador, Economico, Socio, comentarios) values(:agencia,:operador,:economico,:socio, :comentarios)';
			$stmt = $mysqli->prepare($sql);
			$stmt->bindParam(':agencia',$agencia);
			$stmt->bindParam(':operador',$operador);
			$stmt->bindParam(':economico',$economico);
			$stmt->bindParam(':socio',$socio);
			$stmt->bindParam(':comentarios',$comentarios);
			$stmt->execute();
			
			$insertId = $mysqli ->lastInsertId();


			$sql = 'insert into Cuota_Flete(NumFlete,Sucursal,TipoCuota,Cuota) values(:id,:cliente,:tipocuota,:cuota)';
			$stmt = $mysqli->prepare($sql);
			$stmt->bindParam(':id', $insertId);
			$stmt->bindParam(':cliente', $cliente);
			$stmt->bindParam(':tipocuota', $numcuota);
			$stmt->bindParam(':cuota', $cuota);
			$stmt->execute();

			for($contador = 0; $contador < count($contenedor); $contador++){

						$sql = 'select idContenedor from Contenedor where idContenedor = :contenedor';
						$stmt = $mysqli->prepare($sql);
						$stmt->bindParam(':contenedor', $contenedor[$contador]);
						$stmt->execute();
						$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

						if($rows != null){

						}
						else{
								$sql = 'insert into Contenedor(idContenedor,Tipo) values(:contenedor, :tipo);';
								$stmt = $mysqli->prepare($sql);
								$stmt->bindParam(':contenedor', $contenedor[$contador]);
								$stmt->bindParam(':tipo', $tipoContenedor[$contador]);
								$stmt->execute();
						}
											
				$sql = 'insert into Contenedor_Viaje(WorkOrder,Booking,Flete_idFlete, Contenedor) values(:workorder, :booking, :flete, :contenedor);';
				$stmt = $mysqli->prepare($sql);
				$stmt->bindParam(':workorder', $workOrder[$contador]);
				$stmt->bindParam(':booking', $booking[$contador]);
				$stmt->bindParam(':flete', $insertId);
				$stmt->bindParam(':contenedor', $contenedor[$contador]);
				$stmt->execute();
						
					for($nuevoContador = 0; $nuevoContador < count($sello[$contador]); $nuevoContador++){
						$respuestaOK = true;

						$sql = 'insert into ContenedorSellos(Sello,NumeroSello, NumFlete, Contenedor) values(:sello, :numeroSello, :numeroFlete, :contenedor);';

						$stmt = $mysqli->prepare($sql);
						$numeroSelloParam = $nuevoContador+1;

						$stmt->bindParam(':sello', $sello[$contador][$nuevoContador]);
						$stmt->bindParam(':numeroSello', $numeroSelloParam);
						$stmt->bindParam(':numeroFlete', $insertId);
						$stmt->bindParam(':contenedor', $contenedor[$contador]);
						$stmt->execute();
					}
			}

			$mysqli->commit();

	} catch(PDOException $ex) {
	    //Something went wrong rollback!
	    $mysqli->rollBack();
	    echo $ex->getMessage();
	    $respuestaOK = false;
	}

}
$salidaJson = array("agencia" => $agencia,
					"cliente" => $cliente,
					"cuota" => $cuota,
					"socio" => $socio,
					"operador" => $operador,
					"economico" => $economico,
					"numcuota" => $numcuota,
					"respuesta" => $respuestaOK,
					"comentarios" => $comentarios,
					"contenedor" => $contenedor,					
					"workorder" => $workOrder,
					"booking" =>$booking,
					"tipoContenedor" =>$tipoContenedor,
					"sello" => $sello
                    );

echo json_encode($salidaJson);

      function consulta(){
        try {
              $mysqli = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');
              $respuestaOK = false;
                } catch(PDOException $ex) {
                    echo "An Error occured!"; //user friendly message
                    echo $ex->getMessage();
                    $respuestaOK = false;
          }
          return $mysqli;
      }

?>