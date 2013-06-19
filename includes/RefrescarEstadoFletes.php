<?php

require_once("../Pagination/Dia.php");
include_once('generic.connection.php');

$contenido = "";

if( isset($_POST) && !empty($_POST) ){

	$Dia = new Dia;
	$Dia->anio = $_POST['anio'];
	$Dia->dia  =  $_POST['dia'];

	$Dia->getRequest();

	$contenido .= $Dia->get_contenidoFletes();
	
}

$array = array('contenido' => $contenido);

echo json_encode($array);

?>