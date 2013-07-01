<?php

include("Timsa/includes/generic.connection.php");

if(isset($_POST) && !empty($_POST) ){

	if( isset($_POST['username']) && !empty($_POST['username'])){
		$user = $_POST['username'];
	}
	else{
		header("Location:index.php");
	}

	if( isset($_POST['pass']) && !empty($_POST['pass'])){
		$pass = $_POST['pass'];
	}
	else{
		header("Location:index.php");
	}

	$PDOmysql = consulta();
	$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = 'SELECT id,TipoUSuario from Usuarios 
			where
			Nombre = :nombre 
			and
			Contrasenia = :contrasenia';

	$stmt = $PDOmysql->prepare($sql);
	$stmt->bindParam(":nombre", $user);
	$stmt->bindParam(":contrasenia", $pass);
	$stmt->execute();
	$respuesta =  $stmt->rowCount() ? true : false;

	if($respuesta){
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as $fila) {
			$tipo = $fila['TipoUSuario'];
			$id   = $fila['id'];
		}

		session_start();
		$_SESSION['username'] = $user;
		$_SESSION['tipo']     = $tipo;
		$_SESSION['id']		  = $id;

		if( $tipo = 'Administrador' ){
			header("Location:Timsa/html/TIMSA.php");
		}
	}
	else{
		header("Location:index.php?resultado=incorrecto");
	}
	
	
}
else{
	header("Location:index.php?resultado=incorrecto");
}

?>