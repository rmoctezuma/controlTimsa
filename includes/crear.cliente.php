<?php

include('../includes/generic.connection.php');

$mensaje= "";
$ruta = "";

	$nombre   = $_POST['nombre'];

	if($nombre != null ){

	try {

		if ((($_FILES["archivo"]["type"] == "image/gif") ||
		    ($_FILES["archivo"]["type"] == "image/jpeg") ||
		    ($_FILES["archivo"]["type"] == "image/png") ||
		    ($_FILES["archivo"]["type"] == "image/pjpeg")) &&
		    ($_FILES["archivo"]["size"] < 6000000000)) {

			if ($_FILES["archivo"]["error"] > 0) {
		        echo $_FILES["archivo"]["error"] . "";
		        $mensaje = "Error subiendo la imagen";
		      }
		      else{
		      	$num = rand(1,100) . rand(1,100);

		      	move_uploaded_file($_FILES["archivo"]["tmp_name"],
          							"../img/". $num  . $_FILES["archivo"]["name"]  );

		      	$mensaje = "Imagen de operador subida Correctamente";
		      	$ruta .= '../img/' . $num .  $_FILES["archivo"]["name"];
		      }

		}
		else{
			$mensaje= " La imagen no es del tipo necesario, se reemplazara con la default ";
		}

		if($ruta == "" ){
			$ruta = "../img/descarga.jpg";
		}


		$PDOmysql = consulta();

		$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$PDOmysql->beginTransaction();

		$sql = 'insert into Cliente(Nombre, rutaImagen) values(:nombre, :imagen)';

		$stmt = $PDOmysql->prepare($sql);
		$stmt->bindParam(':nombre',$nombre);
		$stmt->bindParam(':imagen',$ruta);
		$stmt->execute();

		$PDOmysql->commit();

		} catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $PDOmysql->rollBack();
		    $resultados = 'Error en la creacion de el economico';
		    header('Location: http://control.timsalzc.com/Timsa/html/economicos.php?resultado=incorrecto&laimagen=mensaje');
		}
		catch(Exception $e){
			$PDOmysql->rollBack();
		    $resultados = 'Error en la creacion de el economico';
		    header('Location: http://control.timsalzc.com/Timsa/html/cuotas.php?resultado=incorrecto&laimagen=mensaje');
		}

		header('Location: http://control.timsalzc.com/Timsa/html/clientes.php?resultado=correcto&laimagen='. $nombre);


		}
		else{
			header('Location: http://control.timsalzc.com/Timsa/html/clientes.php?resultado=incorrecto&laimagen='. $nombre);
		}	



?>