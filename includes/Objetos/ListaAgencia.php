<?php

include_once("../includes/generic.connection.php");
require_once("Agencia.php");

class ListaAgencia{
	var $agencias;

	function ListaAgencia(){
		$this->agencias =  array();

		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Agencia';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	$agencia = new Agencia;
            	$agencia->createAgencia($fila['idAgente'],$fila['Nombre'],$fila['fecha_ingreso'],$fila['statusA'],$fila['fecha_deprecated']);
            	array_push($this->agencias, $agencia);
            }
		} catch(PDOException $e){

		}
	}

	function getAgencias(){
		return $this->agencias;
	}

}


?>

