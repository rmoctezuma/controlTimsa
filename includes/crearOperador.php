<?php

$nombre = $_POST['NombreSocio'] ;
$apellidoP = $_POST['ApellidoSocio'];
$apellidoM = $_POST['ApellidoMSocio'];
$telefono = $_POST['telefono'];
$rc = $_POST['rc'];
$curp = $_POST['curp'];
$ruta = "";
$mensaje = "";
$mensajeImagen = "";

try {

		if ((($_FILES["archivo"]["type"] == "image/gif") ||
		    ($_FILES["archivo"]["type"] == "image/jpeg") ||
		    ($_FILES["archivo"]["type"] == "image/pjpeg")) &&
		    ($_FILES["archivo"]["size"] < 60000)) {

			if ($_FILES["archivo"]["error"] > 0) {
		        echo $_FILES["archivo"]["error"] . "";
		        $mensajeImagen.= "Error subiendo la imagen";
		      }
		      else{
		      	$num = rand(1,100) . rand(1,100);

		      	move_uploaded_file($_FILES["archivo"]["tmp_name"],
          							"../img/". $num  . $_FILES["archivo"]["name"]  );

		      	$mensajeImagen .= "<h2>Imagen de operador subida Correctamente</h2>";
		      	$ruta .= '../img/' . $num .  $_FILES["archivo"]["name"];
		      }

		}
		else{
			$mensajeImagen.= "<h2> La imagen no es del tipo necesario, se reemplazara con la default <h2>";
		}

		if($ruta == "" ){
			$ruta = "../img/descarga.jpg";
		}

        $mysqli = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');
        $mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'insert into Operador(Nombre, ApellidoP, ApellidoM,rutaImagen,Telefono, CURP) values(:nombre, :apellido, :apellidoM,:ruta,:tel,:curp);';
        $stmt = $mysqli->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellidoP);
        $stmt->bindParam(':apellidoM', $apellidoM);
        $stmt->bindParam(':ruta', $ruta);
        $stmt->bindParam(':tel', $telefono);
        $stmt->bindParam(':curp', $curp);
        $stmt->execute();

        $mensaje.= "<h1> Operador Creado Correctamente </h1>";


    } catch(PDOException $ex) {
        echo "An Error occured!"; //user friendly message
        echo $ex->getMessage();
        $respuestaOK = false;
        header('Location: http://control.timsalzc.com/Timsa/html/operadores.php?resultado=incorrecto');
    }

    header('Location: http://control.timsalzc.com/Timsa/html/operadores.php?resultado=correcto');
?>

<html>

<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
	$(function(){
		$('#volver').click(function(){
			window.location = "http://control.timsalzc.com/Timsa/html/operadores.php";
		});
	});
</script>

<body>
	<div class="container">
		<br>
		<br>
		<div class="hero-unit">
		<?php
			echo $mensaje;
			echo $mensajeImagen;
		 ?>
		<button id="volver" class="btn btn-primary">Volver</button>
		</div>
	</div>
</body>
</html>

?>