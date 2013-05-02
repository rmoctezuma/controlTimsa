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


	function createEconomico($id,$placas,$status,$fecha_ingreso,$fecha_deprecated,$serie,$modelo,$marca,$tipoVehiculo,$transponder){
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

	function createEconomicoFromID($id){
		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Economico WHERE Economico.Economico = :economico';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':economico', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	$this->id = $fila['Economico'];
				$this->placas = $fila['Placas'];
				$this->status = $fila['statusA'];
				$this->fecha_ingreso = $fila['fecha_ingreso'];
				$this->fecha_deprecated = $fila['fecha_deprecated'];
				$this->serie = $fila['NumeroSerie'];
				$this->modelo = $fila['Modelo'];
				$this->marca = $fila['marca'];
				$this->tipoVehiculo = $fila['tipoVehiculo'];
				$this->transponder = $fila['Transponder'];
            }
		} catch(PDOException $e){

		}
	}

	function get_id(){
		return $this->id;
	}

	function set_id($id){
		$this->id = $id;
	}

	function get_placas(){
		return $this->placas;
	}

	function set_placas($placas){
		$this->placas = $placas;
	}

	function get_status(){
		return $this->status;
	}

	function set_status($status){
		$this->status = $status;
	}

	function get_fecha_ingreso(){
		return $this->fecha_ingreso;
	}

	function set_fecha_ingreso($fecha_ingreso){
		$this->fecha_ingreso = $fecha_ingreso;
	}

	function get_fecha_deprecated(){
		return $this->fecha_deprecated;
	}

	function set_fecha_deprecated($fecha_deprecated){
		$this->fecha_deprecated = $fecha_deprecated;
	}

	function get_serie(){
		return $this->serie;
	}

	function set_serie($serie){
		$this->serie = $serie;
	}

	function get_modelo(){
		return $this->modelo;
	}

	function set_modelo($modelo){
		$this->modelo = $modelo;
	}

	function get_marca(){
		return $this->marca;
	}

	function set_marca($marca){
		$this->marca = $marca;
	}

	function get_tipoVehiculo(){
		return $this->tipoVehiculo;
	}

	function set_tipoVehiculo($tipoVehiculo){
		$this->tipoVehiculo = $tipoVehiculo;
	}

	function get_transponder(){
		return $this->transponder;
	}

	function set_transponder($transponder){
		$this->transponder = $transponder;
	}

}
?>