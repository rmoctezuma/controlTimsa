<?php

include('../includes/generic.connection.php');

$direccion = "";

if(isset($_POST) && !empty($_POST)){
	$numero = $_POST['key'];

	$PDOmysql = consulta();

	try {
		$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = 'select distinct Calle,Numero, Colonia, Localidad, Ciudad, Estado, Telefono 
		from ClienteDireccion
		where Sucursal = :sucursal';

	 $stmt = $PDOmysql->prepare($sql);
	 $stmt->bindParam(':sucursal', $numero);
	 $stmt->execute();
	 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	 foreach ($rows as $fila) {
	 	$direccion .= 'Calle '. $fila['Calle']. ' Numero ' . $fila['Numero']. ' Colonia ' . $fila['Colonia'] . ', '. $fila['Localidad']. ' '. $fila['Ciudad']. ', '. $fila['Estado']. ' Telefono '. $fila['Telefono'];
	 }

	 } catch(PDOException $ex) {
	    //Something went wrong rollback!
	    $PDOmysql->rollBack();
	    echo $ex->getMessage();
	    $respuestaOK = false;
	}
}

$resultados = array("results" => $direccion);

echo json_encode($resultados);

?>