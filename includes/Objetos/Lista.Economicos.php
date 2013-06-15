<?php

include_once("../includes/generic.connection.php");
require_once("Economico.php");

Class ListaEconomicos{
	var $economicos;

	function ListaEconomicos(){
		$this->economicos =  array();

		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Economico';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	$economico = new Economico();
            	$economico->createeconomico($fila['Economico'], $fila['Placas'],$fila['statusA'],$fila['fecha_ingreso'],$fila['fecha_deprecated'],$fila['NumeroSerie'],
            		$fila['Modelo']);
            	array_push($this->economicos, $economico);
            }
		} catch(PDOException $e){

		}
	}

	function getLista(){
		return $this->economicos;
	}

	function getElement(){
		$economico = array_shift($this->economicos);

		return $economico;
	}

	public function hasNext(){
		if (count($this->economicos) > 0 ){
			return true;
		}
		else{
			return false;
		}
	}
}


?>