<?php

include_once("../includes/generic.connection.php");

class Agencia{
	var $idAgencia;
	var $Nombre;
	var $fechaIngreso;
	var $statusA;
	var $fechaDeprecated;

	function Agencia($id,$nombre,$fecha,$status,$fechaDeprecated){
		$this->idAgencia = $id;
		$this->Nombre = $nombre;
		$this->fechaIngreso = $fecha;
		$this->statusA = $status;
		$this->fechaDeprecated = $fechaDeprecated;
	}

	function inicializarAgenciaConIdenttificador($id){
		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Agencia  WHERE Agencia.idAgente = :agencia';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':agencia', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	$this->idCliente = $fila['idAgente'];
            	$this->Nombre = $fila['Nombre'];
            	$this->fechaIngreso = $fila['fecha_ingreso'];
            	$this->statusA = $fila['statusA'];
            	$this->fechaDeprecated = $fila['fecha_deprecated'];
            }
		} catch(PDOException $e){

		}
	}

	function getAgencia(){
		return $this->idAgencia;
	}

	function setAgencia($parametro){
		$this->idAgencia  = $parametro ;
	}

	function getNombre(){
		return $this->Nombre;
	}

	function setNombre($parametro){
		$this->Nombre  = $parametro ;
	}

	function getFechaIn(){
		return $this->fechaIngreso;
	}

	function setFechaIn($parametro){
		$this->fechaIngreso  = $parametro ;
	}

	function getStatus(){
		return $this->statusA;
	}

	function setStatus($parametro){
		$this->statusA  =  $parametro;
	}

	function getFechaDeprecated(){
		return $this->fechaDeprecated;
	}	

	function setFechaDeprecated($parametro){
		$this->fechaDeprecated = $parametro ;
	}

}

?>