<?php

include('../includes/generic.connection.php');

$PDOmysql = consulta();
$result = "<br><br><label>Cuota</label>";

try {
		$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = 'select distinct idCuota, Lugar
		from Cuota';

	 $stmt = $PDOmysql->prepare($sql);
	 $stmt->execute();
	 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	 $result .= "<select id='cuotas'>";

	 foreach ($rows as $fila) {
	 	$result .= "<option value= '". $fila['idCuota'] ."'> ".  $fila['Lugar'] ."</option>";
	 }

	 $result .= "</select>";
	 $result .= "<div id='detallesPrecios'>";
	 $result .= "</div>";

	 } catch(PDOException $ex) {
	    //Something went wrong rollback!
	    $PDOmysql->rollBack();
	    echo $ex->getMessage();
	    $respuestaOK = false;
	}

$salidaJson = array("respuesta" => $result );

echo json_encode($salidaJson);

?>