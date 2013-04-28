<?php

include_once("../includes/generic.connection.php");
require_once("Cliente.php");

Class ListaClientes{
	var $clientes;

	function ListaClientes(){
		$this->clientes =  array();

		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Cliente';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	$cliente = new Cliente($fila['idCliente'],$fila['Nombre'],$fila['fecha_ingreso'],$fila['statusA'],$fila['fecha_deprecated'],$fila['rutaImagen']);
            	array_push($this->clientes, $cliente);
            }
		} catch(PDOException $e){

		}
	}

	function getLista(){
		return $this->clientes;
	}
}


?>