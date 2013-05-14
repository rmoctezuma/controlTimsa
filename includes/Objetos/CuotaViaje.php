<?php

include_once("../includes/generic.connection.php");

Class Cuota{
	private $id;
	private $valor;
	private $trafico;
	private $tipoViaje;
	private $tarifa;


	function createCuotaViaje($id,$value,$trafico,$tipoViaje,$tarifa){
		        $this->id = $id;
            	$this->valor = $value;
            	$this->trafico = $trafico;
            	$this->tipoViaje = $tipoViaje;
            	$this->tarifa = $tarifa;
	}

	function getCuotaFromID($id,$value){
		try{

			$PDOmysql = consulta();

			$sql = 'SELECT Trafico,TipoViaje,Tarifa,statusA
					FROM   CuotaDetalle  WHERE Cuota_idCuota = :cuota and numero = :value' ;

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':cuota', $id);
            $stmt->bindParam(':value', $value);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            foreach ($variable as $fila ) {
            	$this->id = $id;
            	$this->valor = $value;
            	$this->trafico = $fila['Trafico'];
            	$this->tipoViaje = $fila['TipoViaje'];
            	$this->tarifa = $fila['Tarifa'];
            }

		} catch(PDOException $e){

		}
	}

	public function __toString(){
        return $this->id;
    }

	function get_id(){
		return $this->id;
	}

	function set_id($id){
		$this->id = $id;
	}

	function get_valor(){
		return $this->valor;
	}
	function set_valor($valor){
		$this->valor = $valor;
	}

	function get_trafico(){
		return $this->trafico;
	}
	function set_trafico($trafico){
		$this->trafico = $trafico;
	}
	function get_tipoViaje(){
		return $this->tipoViaje;
	}
	function set_tipoViaje($tipoViaje){
		$this->tipoViaje = $tipoViaje;
	}
	function get_tarifa(){
		return $this->tarifa;
	}
	function set_tarifa($tarifa){
		$this->tarifa = $tarifa;
	}



}

?>