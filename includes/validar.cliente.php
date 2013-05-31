<?php

require_once("Objetos/Sucursal.php");
require_once("Objetos/Cuota.php");
require_once("Objetos/Cliente.php");

if(isset($_POST) && !empty($_POST)){

	$sucursal = new Sucursal;

	$sucursal->set_nombreSucursal($_POST['nombre']);
	$sucursal->set_telefono($_POST['telefono'] );
	$sucursal->set_calle($_POST['calle'] );
	$sucursal->set_numero($_POST['numero']);
	$sucursal->set_colonia($_POST['colonia']);
	$sucursal->set_localidad($_POST['localidad']);
	$sucursal->set_ciudad($_POST['ciudad']);
	$sucursal->set_estado($_POST['estado']);
	
	 
	$sucursal->set_lat($_POST['lat'] );
	$sucursal->set_long($_POST['long']);
	
	 
	 $cuota = new Cuota;
	 $cuota-> getCuotaFromID($_POST['cuota']);
	 $sucursal->set_Cuota($cuota);
	 

	 $cliente = new Cliente;
	 $cliente->incializarClienteConIdentificador($_POST['cliente'] );
	 $sucursal->set_Cliente($cliente);

	 $sucursal->insert();

 	 header("Location:../html/clientes.php?sucursal=agregada");
	
}

?>