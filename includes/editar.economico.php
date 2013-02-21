<?php

$resultado = "";

include('../includes/generic.connection.php');

if(isset($_POST) && !empty($_POST)){
	$economico = $_POST['economico'];
	$operador = $_POST['operador'];
	$socio = $_POST['socio'];
	$action = $_POST['action'];

	if($action == 'agregarOperador'){

        $sql = 'insert into VehiculoDetalle(Operador,Economico,Socio) values(:operador,:economico, :socio)';


    }  
}

?>