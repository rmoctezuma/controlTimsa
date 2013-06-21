<?php
	//comprueba que se reciban datos con POST
if(isset($_POST) && !empty($_POST)){

	//obtiene todos los datos del formulario de flete.

$agencia = $_POST['agencia']; //obligatorio
$cliente = $_POST['cliente']; //obligatorio
$cuota = $_POST['cuota'] ; //obligatorio
$socio = $_POST['socio'] ; //obligatorio
$operador = $_POST['operador'] ; //obligatorio
$economico = $_POST['economico'] ; //obligatorio
$numcuota = $_POST['numcuota'] ; //obligatorio
$comentarios = $_POST['comentarios']; //opcional
$contenedor = $_POST['contenedor']; //opcional, hasta 2 (array)
$workOrder = $_POST['workorder']; //opcional, hasta 2 (array)
$booking = $_POST['booking']; //opcional, hasta 2  (array)
$tipoContenedor = $_POST['tipoContenedor']; //opcional, hasta 2 (array)
$sello = $_POST['sello']; //opcional, hasta 3 (array)
$status = $_POST['status'];

 
$mysqli = consulta(); //recibe la conexion a la base de datos.

	
		$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // pone el conector a producir errores.
																		  // de esta manera se puede colocar el rollback en 
																		 //  la transaccion.	

		//$mysqli->beginTransaction(); // comienza transaccion.

		// Coloca el estatus del operador a ocupado. (se encuentra en un flete)

			$sql = 'update Operador set statusA = "Ocupado" where Eco = :operador';
			$stmt = $mysqli->prepare($sql);
			$stmt->bindParam(':operador',$operador);
			$stmt->execute();

		// Coloca el estatus del economico a ocupado. (se encuentra en un flete)
			$sql = 'update Economico set statusA = "Ocupado" where Economico = :economico';
			$stmt = $mysqli->prepare($sql);
			$stmt->bindParam(':economico',$economico);
			$stmt->execute();

		// Inserta el Flelte, con los datos principales.
			$sql = 'insert into Flete(Agencia_idAgente, Operador, Economico, Socio, comentarios, statusA) values(:agencia,:operador,:economico,:socio, :comentarios, :status)';
			$stmt = $mysqli->prepare($sql);
			$stmt->bindParam(':agencia',$agencia);
			$stmt->bindParam(':operador',$operador);
			$stmt->bindParam(':economico',$economico);
			$stmt->bindParam(':socio',$socio);
			$stmt->bindParam(':comentarios',$comentarios);
			$stmt->bindParam(':status',$status);
			$stmt->execute();
		//Obtiene la llave primaria del flete recien creado.
			$insertId = $mysqli ->lastInsertId();

		// Inserta la cuota del flete. (es la ultima insercion obligatoria relativa al flete)
			$sql = 'insert into Cuota_Flete(NumFlete,Sucursal,TipoCuota,Cuota) values(:id,:cliente,:tipocuota,:cuota)';
			$stmt = $mysqli->prepare($sql);
			$stmt->bindParam(':id', $insertId);
			$stmt->bindParam(':cliente', $cliente);
			$stmt->bindParam(':tipocuota', $numcuota);
			$stmt->bindParam(':cuota', $cuota);
			$stmt->execute();

			// Insercion de datos relativos a contenedores.

			// Recorre el array de contenedores. Full = 2 contenedores. Sencillo = 1
			for($contador = 0; $contador < count($contenedor); $contador++){
				// Comprueba que exista el contenedor, o que no sea una cadena de texto en blanco.
				// De ser asi, salta todas las acciones y sigue con el siguiente ciclo.
				if($contenedor[$contador] == null || $contenedor[$contador] == "" ){
					continue;
				}
					
						$referencia = $contenedor[$contador];

						// Busca en la base de datos, para saber si el contenedor a manejar, ya esta registrado.
						$sql = 'select idContenedor from Contenedor where idContenedor = :contenedor';
						$stmt = $mysqli->prepare($sql);
						$stmt->bindParam(':contenedor', $referencia);
						$stmt->execute();
						$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

						//Comprueba los resultados obtenidos en la consulta. Al ser diferente de null,
						//el contenedor existe y no se hace nada, de otra manera se inserta.
						$respuesta =  $stmt->rowCount() ? true : false;
						if($respuesta){

						}
						else{
							
								$sql = 'insert into Contenedor(idContenedor,Tipo) values(:contenedor, :tipo);';
								$stmt = $mysqli->prepare($sql);
								$stmt->bindParam(':contenedor', $contenedor[$contador]);
								$stmt->bindParam(':tipo', $tipoContenedor[$contador]);
								$stmt->execute();
						}

						//Inserta los datos de este contenedor. Cabe decir que de existir un contenedor,
						//la insercion de estos datos es obligatoria.
											
				$sql = 'insert into Contenedor_Viaje(WorkOrder,Booking,Flete_idFlete, Contenedor) values(:workorder, :booking, :flete, :contenedor);';
				$stmt = $mysqli->prepare($sql);
				$stmt->bindParam(':workorder', $workOrder[$contador]);
				$stmt->bindParam(':booking', $booking[$contador]);
				$stmt->bindParam(':flete', $insertId);
				$stmt->bindParam(':contenedor', $contenedor[$contador] );
				$stmt->execute();
						//Itera para saber el numero de sellos.
					for($nuevoContador = 0; $nuevoContador < count($sello[$contador]); $nuevoContador++){
						//insercion de sello.
						$sql = 'insert into ContenedorSellos(Sello,NumeroSello, NumFlete, Contenedor) values(:sello, :numeroSello, :numeroFlete, :contenedor);';

						$stmt = $mysqli->prepare($sql);
						$numeroSelloParam = $nuevoContador+1; // Aumenta el numero de sello.

						$stmt->bindParam(':sello', $sello[$contador][$nuevoContador]);
						$stmt->bindParam(':numeroSello', $numeroSelloParam);
						$stmt->bindParam(':numeroFlete', $insertId);
						$stmt->bindParam(':contenedor', $contenedor[$contador]);
						$stmt->execute();
					}
			}
			//Creacion de flete Correcta, se inserta todo lo establecido.
			//$mysqli->commit();

	/*} catch(PDOException $ex) {
	    //Something went wrong rollback!
	    $mysqli->rollBack();
	    $ex->getMessage();
	    $respuestaOK = $ex;
	}*/

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
                    $ex->getMessage();
                    $respuestaOK = $ex;
          }
          return $mysqli;
      }

?>