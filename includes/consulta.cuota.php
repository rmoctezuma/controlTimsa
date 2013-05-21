<?php

require_once("generic.connection.php");
require_once("Objetos/Sucursal.php");

$contenido = "";
$lugar     = "";

$contenidoSucursal="";

if(isset($_POST) && !empty($_POST)){
	if(! empty($_POST['sucursal'])){
		try{
			$sucursal = new Sucursal;
			$sucursal->getSucursalFromID($_POST['sucursal']);
			$contenidoSucursal = $sucursal->getID();
			$cuota = $sucursal->get_Cuota();
			$contenido = $cuota->get_id();
			$lugar  = $cuota->get_lugar();

		} catch(Exception $e){
			$contenido = $e;
		}
	}
}

$resultados =  array('contenido' => $contenido,
					 'nombre' => $lugar,
					 'contenidoSucursal' => $contenidoSucursal );

echo json_encode($resultados);

?>