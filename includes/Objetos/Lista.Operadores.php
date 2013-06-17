<?php

include_once("../includes/generic.connection.php");
require_once("Operador.php");

Class ListaOperadores{
	var $operadores;

	function createListaOperadores(){
		$this->operadores =  array();

		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Operador';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	$operador = new Operador();
            	$operador->createOperador($fila['Eco'],$fila['Nombre'],$fila['ApellidoP'],$fila['ApellidoM'],$fila['R.C.'],$fila['CURP'],$fila['fecha_ingreso'], $fila['statusA'],$fila['fecha_deprecated'], $fila['Telefono'], $fila['rutaImagen']);
            	array_push($this->operadores, $operador);
            }
		} catch(PDOException $e){

		}
	}

	public	function createListaOperadoresWithEconomico($economico){
			$this->operadores =  array();

			try{

				$PDOmysql = consulta();

				$sql = 'SELECT * FROM Operador, VehiculoDetalle
						where Operador.Eco = VehiculoDetalle.Operador
						and   VehiculoDetalle.Economico = :economico';

				$stmt = $PDOmysql->prepare($sql);
				$stmt->bindParam(':economico', $economico);
	            $stmt->execute();
	            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	            foreach ($rows as $fila) {
	            	$operador = new Operador();
	            	$operador->createOperador($fila['Eco'],$fila['Nombre'],$fila['ApellidoP'],$fila['ApellidoM'],$fila['R.C.'],$fila['CURP'],$fila['fecha_ingreso'], $fila['statusA'],$fila['fecha_deprecated'], $fila['Telefono'], $fila['rutaImagen']);
	            	array_push($this->operadores, $operador);
	            }
			} catch(PDOException $e){

			}
		}

	public	function createListaOperadoresWithEconomicoAndFreeStatus($economico){
			$this->operadores =  array();

			try{

				$PDOmysql = consulta();

				$sql = 'SELECT * FROM Operador, VehiculoDetalle
						where Operador.Eco = VehiculoDetalle.Operador
						and   VehiculoDetalle.Economico = :economico
						and Operador.statusA = "Libre"';

				$stmt = $PDOmysql->prepare($sql);
				$stmt->bindParam(':economico', $economico);
	            $stmt->execute();
	            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	            foreach ($rows as $fila) {
	            	$operador = new Operador();
	            	$operador->createOperador($fila['Eco'],$fila['Nombre'],$fila['ApellidoP'],$fila['ApellidoM'],$fila['R.C.'],$fila['CURP'],$fila['fecha_ingreso'], $fila['statusA'],$fila['fecha_deprecated'], $fila['Telefono'], $fila['rutaImagen']);
	            	array_push($this->operadores, $operador);
	            }
			} catch(PDOException $e){

			}
		}

	function getLista(){
		return $this->operadores;
	}

	function getOperador(){
		$operador = array_shift($this->operadores);

		return $operador;
	}

	public function hasNext(){
		if (count($this->operadores) > 0 ){
			return true;
		}
		else{
			return false;
		}
	}

}


?>