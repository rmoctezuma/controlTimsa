<?php

include_once("../includes/generic.connection.php");

Class Cuota{
	private $id;
	private $lugar;
	private $importacion = array('Sencillo' => "", 'Full' => "");
	private $exportacion = array('Sencillo' => "", 'Full' => "");
	private $reutilizado = array('Sencillo' => "", 'Full' => "");


	function createCuota($id,$lugar,$importacionSencillo,$exportacionSencillo,$reutilizadoSencillo, $importacionFull,$exportacionFull,$reutilizadoFull){
		$this->id = $id;
		$this->lugar = $lugar;

		$this->importacion['Sencillo'] = $importacionSencillo;
		$this->importacion['Full'] = $importacionFull;

		$this->exportacion['Sencillo'] = $exportacionSencillo;
		$this->exportacion['Full'] = $exportacionFull;

		$this->reutilizado['Sencillo'] = $reutilizadoSencillo;
		$this->reutilizado['Full'] = $reutilizadoFull;
	}

	function getCuotaFromID($id){
		try{

			$PDOmysql = consulta();

			$sql = 'SELECT Cuota.Lugar,CuotaDetalle.Trafico,CuotaDetalle.TipoViaje, CuotaDetalle.Viaje, CuotaDetalle.Tarifa
					FROM   Cuota,CuotaDetalle  WHERE Cuota.idCuota = :cuota';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':cuota', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	$this->lugar = $fila['Lugar'];

            	switch ($fila['Trafico']) {
            		case 'Reutilizado':
            			if($fila['TipoViaje'] == 'Sencillo'){
            				$this->reutilizado['Sencillo'] = $fila['Tarifa'];
            			}
            			else if($fila['TipoViaje'] == 'Full'){
            				$this->reutilizado['Full'] = $fila['Tarifa'];
            			}
            			break;
            		case 'Importacion':
            			if($fila['TipoViaje'] == 'Sencillo'){
            				$this->importacion['Sencillo'] = $fila['Tarifa'];
            			}
            			else if($fila['TipoViaje'] == 'Full'){
            				$this->importacion['Full'] = $fila['Tarifa'];
            			}
            			break;
            		case 'Exportacion':
            			if($fila['TipoViaje'] == 'Sencillo'){
            				$this->exportacion['Sencillo'] = $fila['Tarifa'];
            			}
            			else if($fila['TipoViaje'] == 'Full'){
            				$this->exportacion['Full'] = $fila['Tarifa'];	
            			}
            			break;		
            	}
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

	function get_lugar(){
		return $this->lugar;
	}

	function set_lugar($lugar){
		$this->lugar = $lugar;
	}

	function get_importacionSencillo(){
		return $this->importacion['Sencillo'];
	}

	function set_importacionSencillo($importacion){
		$this->importacion['Sencillo'];
	}

	function get_importacionFull(){
		return $this->importacion['Full'];
	}

	function set_importacionFull($importacion){
		$this->importacion['Full'];
	}

	function get_exportacionSencillo(){
		return $this->exportacion['Sencillo'];
	}

	function set_exportacionSencillo($exportacion){
		$this->exportacion['Sencillo'];
	}

	function get_exportacionFull(){
		return $this->exportacion['Full'];
	}

	function set_exportacionFull($exportacion){
		$this->exportacion['Full'];
	}

	function get_reutilizadoSencillo(){
		return $this->reutilizado['Sencillo'];
	}

	function set_reutilizadoSencillo($reutilizado){
		$this->reutilizado['Sencillo'];
	}

	function get_reutilizadoFull(){
		return $this->reutilizado['Full'];
	}

	function set_exportacionFull($reutilizado){
		$this->reutilizado['Full'];
	}
}

?>