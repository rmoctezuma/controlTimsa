<?php

$nombre = $_POST['NombreSocio'] . ' ' . $_POST['ApellidoSocio']    .'  '  . $_POST['ApellidoMSocio'] ;
$telefono = $_POST['telefono'];
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

		      	$mensajeImagen .= "<h2>Imagen de socio subida Correctamente</h2>";
		      	$ruta .= '../img/' . $num .  $_FILES["archivo"]["name"];
		      }

		}
		else{
			$mensajeImagen.= "<h2> La imagen no es del tipo necesario, se reemplazara con la default <h2>";
		}

		if($ruta == "" ){
			$ruta = "../img/user2.png";
		}

        $mysqli = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');
        $mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'insert into Socio(Nombre,Telefono,rutaImagen) values(:nombre, :tel, :ruta)';
        $stmt = $mysqli->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':tel', $telefono);
        $stmt->bindParam(':ruta', $ruta);
        $stmt->execute();

        $mensaje.= "<h1> Socio Creado Correctamente </h1>";

    } catch(PDOException $ex) {
        echo "An Error occured!"; //user friendly message
        echo $ex->getMessage();
        $respuestaOK = false;
        header('Location: http://control.timsalzc.com/Timsa/html/socios.php?resultado=incorrecto');
    }

    header('Location: http://control.timsalzc.com/Timsa/html/socios.php?resultado=correcto');

?>

<html>

<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
	$(function(){
		$('#volver').click(function(){
			window.location = "http://control.timsalzc.com/Timsa/html/socios.php";
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