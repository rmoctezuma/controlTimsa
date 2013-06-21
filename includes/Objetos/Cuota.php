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

			$PDOmysql = consulta();

			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = 'SELECT Cuota.Lugar,CuotaDetalle.Trafico,CuotaDetalle.TipoViaje, CuotaDetalle.Tarifa,CuotaDetalle.numero
					FROM   Cuota,CuotaDetalle  
					WHERE 
					Cuota.idCuota = :cuota
					AND 
					CuotaDetalle.Cuota_idCuota = :cuota';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':cuota', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->id = $id;

            foreach ($rows as $fila) {
            	$this->lugar = $fila['Lugar'];

            	switch ($fila['Trafico']) {
            		case 'Reutilizado':
            			if($fila['TipoViaje'] == 'Sencillo'){
            				$this->reutilizado['Sencillo'] = $fila['numero'];
            			}
            			else if($fila['TipoViaje'] == 'Full'){
            				$this->reutilizado['Full'] = $fila['numero'];
            			}
            			break;
            		case 'Importacion':
            			if($fila['TipoViaje'] == 'Sencillo'){
            				$this->importacion['Sencillo'] = $fila['numero'];
            			}
            			else if($fila['TipoViaje'] == 'Full'){
            				$this->importacion['Full'] = $fila['numero'];
            			}
            			break;
            		case 'Exportacion':
            			if($fila['TipoViaje'] == 'Sencillo'){
            				$this->exportacion['Sencillo'] = $fila['numero'];
            			}
            			else if($fila['TipoViaje'] == 'Full'){
            				$this->exportacion['Full'] = $fila['numero'];	
            			}
            			break;		
            	}
            }

		
	}

	function get_trafico($string){

		if($string == 'Importacion'){
			return $this->importacion;
		}
		else if($string == 'Exportacion'){
			return $this->exportacion;
		}
		else if($string == 'Reutilizado'){
			return $this->reutilizado;
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
		$this->importacion['Sencillo'] = $importacion;
	}

	function get_importacionFull(){
		return $this->importacion['Full'];
	}

	function set_importacionFull($importacion){
		$this->importacion['Full'] = $importacion;
	}

	function get_exportacionSencillo(){
		return $this->exportacion['Sencillo'];
	}

	function set_exportacionSencillo($exportacion){
		$this->exportacion['Sencillo'] = $exportacion;
	}

	function get_exportacionFull(){
		return $this->exportacion['Full'];
	}

	function set_exportacionFull($exportacion){
		$this->exportacion['Full'] = $exportacion;
	}

	function get_reutilizadoSencillo(){
		return $this->reutilizado['Sencillo'];
	}

	function set_reutilizadoSencillo($reutilizado){
		$this->reutilizado['Sencillo'] = $reutilizado;
	}

	function get_reutilizadoFull(){
		return $this->reutilizado['Full'];
	}

	function set_reutilizadoFull($reutilizado){
		$this->reutilizado['Full'] = $reutilizado;
	}
}

?>