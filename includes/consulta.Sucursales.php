<?php

require_once("generic.connection.php");
require_once("Objetos/Cliente.php");

$contenido = "";

if(isset($_POST) && !empty($_POST)){
	if(! empty($_POST['cliente'])){
		try{
			$cliente = new Cliente;
			$sucursales = $cliente->obtenerSucursalesDeCliente($_POST['cliente']);
			$contenido .= "<div> <h4> Sucursales </h4>";
			$contenido .= "<table>";
			for ($i=0; $i < count($sucursales); $i++) {
				$contenido .= '<tr><td>
								<input name="sucursal" type="radio" value="'.$sucursales[$i]->getID().'">
								<label style="display:inline">'.  $sucursales[$i]->get_nombreSucursal() . '</label>
								
								</td></tr>';

			}
			$contenido .= "</table>";
			$contenido .= "</div>";
		} catch(Exception $e){
			$contenido = $e;
		}
	}
}

$resultados =  array('contenido' => $contenido );

echo json_encode($resultados);

?>