<?php

include('../includes/generic.connection.php');

if(isset($_POST['submit']) && !empty($_POST)){

	$lugar   = $_POST['lugar'];
	$reuSen  = $_POST['reuSen'];
	$reuFull = $_POST['reuFull'];
	$impSen  = $_POST['impSen'];
	$impFull = $_POST['impFull'];
	$expSen  = $_POST['expSen'];
	$expFull = $_POST['expFull'];

	try {
		$PDOmysql = consulta();

		$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$PDOmysql->beginTransaction();

		$sql = 'insert into Cuota(Lugar) values(:lugar)';

		$stmt = $PDOmysql->prepare($sql);
		$stmt->bindParam(':lugar',$lugar);
		$stmt->execute();

		$insertId = $PDOmysql ->lastInsertId();

		$sql = 'insert into CuotaDetalle(Cuota_idCuota, Trafico, TipoViaje, Tarifa) values(:id, "Reutilizado","Sencillo", :reuSen)';
		$stmt = $PDOmysql->prepare($sql);
		$stmt->bindParam(':id',$insertId);
		$stmt->bindParam(':reuSen',$reuSen);
		$stmt->execute();

		$sql = 'insert into CuotaDetalle(Cuota_idCuota, Trafico, TipoViaje, Tarifa) values(:id, "Reutilizado","Full", :reuFull)';
		$stmt = $PDOmysql->prepare($sql);
		$stmt->bindParam(':id',$insertId);
		$stmt->bindParam(':reuFull',$reuFull);
		$stmt->execute();

		$sql = 'insert into CuotaDetalle(Cuota_idCuota, Trafico, TipoViaje, Tarifa) values(:id, "Importacion","Sencillo", :impSen)';
		$stmt = $PDOmysql->prepare($sql);
		$stmt->bindParam(':id',$insertId);
		$stmt->bindParam(':impSen',$impSen);
		$stmt->execute();

		$sql = 'insert into CuotaDetalle(Cuota_idCuota, Trafico, TipoViaje, Tarifa) values(:id, "Importacion","Full", :impFull)';
		$stmt = $PDOmysql->prepare($sql);
		$stmt->bindParam(':id',$insertId);
		$stmt->bindParam(':impFull',$impFull);
		$stmt->execute();

		$sql = 'insert into CuotaDetalle(Cuota_idCuota, Trafico, TipoViaje, Tarifa) values(:id, "Exportacion","Sencillo", :expSen)';
		$stmt = $PDOmysql->prepare($sql);
		$stmt->bindParam(':id',$insertId);
		$stmt->bindParam(':expSen',$expSen);
		$stmt->execute();

		$sql = 'insert into CuotaDetalle(Cuota_idCuota, Trafico, TipoViaje, Tarifa) values(:id, "Exportacion","Full", :expFull)';
		$stmt = $PDOmysql->prepare($sql);
		$stmt->bindParam(':id',$insertId);
		$stmt->bindParam(':expFull',$expFull);
		$stmt->execute();

		$resultados = 'Se ah creado el economico correctamente ';

		$PDOmysql->commit();

		} catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $PDOmysql->rollBack();
		    $resultados = 'Error en la creacion de el economico';
		    header('Location: http://control.timsalzc.com/Timsa/html/economicos.php?resultado=incorrecto');
		}
		catch(Exception $e){
			$PDOmysql->rollBack();
		    $resultados = 'Error en la creacion de el economico';
		    header('Location: http://control.timsalzc.com/Timsa/html/cuotas.php?resultado=incorrecto');
		}	
}

header('Location: http://control.timsalzc.com/Timsa/html/cuotas.php?resultado=correcto');


?>