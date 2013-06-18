<?php

include_once("../includes/generic.connection.php");
require_once("Cliente.php");
require_once("Cuota.php");

Class ListaSucursales{
	private $sucursales;

	public function getSucursalesFromCliente($id){
			$this->sucursales  = array();

			$PDOmysql = consulta();
			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = 'SELECT * FROM ClienteDireccion  
					WHERE ClienteDireccion.Cliente_idCliente = :cliente';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':cliente', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	#Objetos Foraneos de la sucursal.	
				$cliente = new Cliente;
				$cliente->incializarClienteConIdentificador($fila['Cliente_idCliente']);
				$cuota = new Cuota;
				$cuota->getCuotaFromID( $fila['Cuota_idCuota']);

            	$sucursal = new Sucursal;
            	$sucursal->createSucursal($fila['Sucursal'],$fila['NombreSucursal'],$fila['Calle'],
            							$fila['Numero'],$fila['Colonia'], $fila['Localidad'],
            							$fila['Ciudad'],$fila['Estado'],$fila['Telefono'],
            							$fila['StatusA'], $fila['fecha_ingreso'], $fila['fecha_deprecated'],
            							 $fila['Lat'], $fila['Lon'],
            							 $cliente, $cuota);

            	array_push($this->sucursales, $sucursal);
            }
	}

	function getLista(){
		return $this->sucursales;
	}

	function getElement(){
		$elemento = array_shift($this->sucursales);
		return $elemento;
	}

	public function hasNext(){
		if (count($this->sucursales) > 0 ){
			return true;
		}
		else{
			return false;
		}
	}


}

?>