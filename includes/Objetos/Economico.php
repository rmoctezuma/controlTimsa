<?php
include_once("../includes/generic.connection.php");

Class Economico{
	private $id;
	private $placas;
	private $status;
	private $fecha_ingreso;
	private $fecha_deprecated;
	private $serie;
	private $modelo;
	private $marca;
	private $tipoVehiculo;
	private $transponder;

	function Economico(){
		
	}

	function Economico($id,$placas,$status,$fecha_ingreso,$fecha_deprecated,$serie,$modelo,$marca,$tipoVehiculo,$transponder){
		$this->id = $id;
		$this->placas = $placas;
		$this->status = $status;
		$this->fecha_ingreso = $fecha_ingreso;
		$this->fecha_deprecated = $fecha_deprecated;
		$this->serie = $serie;
		$this->modelo = $modelo;
		$this->marca = $marca;
		$this->tipoVehiculo = $tipoVehiculo;
		$this->transponder = $transponder;
	}
}
?>