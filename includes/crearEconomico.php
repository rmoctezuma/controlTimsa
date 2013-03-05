<?php
include('../includes/generic.connection.php');

if(isset($_POST['submit']) && !empty($_POST)){

	$placas = $_POST['Placas'];
	$socio = $_POST['socio'];
	$operador = $_POST['operador'];
	$serie = $_POST['numeroSerie'];
	$modelo = $_POST['modelo'];
	$marca = $_POST['marca'];
	$tipoVehiculo = $_POST['tipoVehiculo'];
	$numero = $_POST['numero'];

	try {
		$PDOmysql = consulta();

		$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$PDOmysql->beginTransaction();

		$sql = 'insert into Economico(Economico,Placas,NumeroSerie,Modelo,marca,tipoVehiculo) values(:economico,:placas,:serie,:modelo,:marca,:tipoVehiculo)';

		$stmt = $PDOmysql->prepare($sql);
		$stmt->bindParam(':economico',$numero);
		$stmt->bindParam(':placas',$placas);
		$stmt->bindParam(':serie',$serie);
		$stmt->bindParam(':modelo',$modelo);
		$stmt->bindParam(':marca',$marca);
		$stmt->bindParam(':tipoVehiculo',$tipoVehiculo);
		$stmt->execute();

		$insertId = $PDOmysql ->lastInsertId();

		$sql = 'insert into VehiculoDetalle(Operador,Economico,Socio) values(:operador,:economico,:socio)';
		$stmt = $PDOmysql->prepare($sql);
		$stmt->bindParam(':operador',$operador);
		$stmt->bindParam(':economico',$insertId);
		$stmt->bindParam(':socio',$socio);
		$stmt->execute();

		$resultados = 'Se ah creado el economico correctamente ';

		$PDOmysql->commit();

		} catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $PDOmysql->rollBack();
		    $resultados = 'Error en la creacion de el economico';
		}
		catch(Exception $e){
			$PDOmysql->rollBack();
		    $resultados = 'Error en la creacion de el economico';
		}	
}

?>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
	$(function(){
		$('#volver').click(function(){
			window.location = "http://control.timsalzc.com/Timsa/html/economicos.php";
		});
	});
</script>

<body>
	<div class="container">
		<br>
		<br>
		<div class="hero-unit">
		<?php
			echo '<h1>'. $resultados . '</h1>';
		 ?>
		<button id="volver" class="btn btn-primary">Volver</button>
		</div>
	</div>
</body>
</html>