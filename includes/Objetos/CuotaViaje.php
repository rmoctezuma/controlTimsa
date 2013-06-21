<?php

include_once("../includes/generic.connection.php");

Class CuotaViaje{
	private $id_cuota;
	private $valor;
	private $trafico;
	private $tipoViaje;
	private $tarifa;


	function createCuotaViaje($id_cuota,$value,$trafico,$tipoViaje,$tarifa){
		        $this->id_cuota = $id_cuota;
            	$this->valor = $value;
            	$this->trafico = $trafico;
            	$this->tipoViaje = $tipoViaje;
            	$this->tarifa = $tarifa;
	}

	function getCuotaFromid_cuota($id_cuota,$value){
	

			$PDOmysql = consulta();

			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = 'SELECT Trafico,TipoViaje,Tarifa,statusA
					FROM   CuotaDetalle  WHERE Cuota_idCuota = :cuota and numero = :value';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':cuota', $id_cuota);
            $stmt->bindParam(':value', $value);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            foreach ($rows as $fila ) {
            	$this->id_cuota = $id_cuota;
            	$this->valor = $value;
            	$this->trafico = $fila['Trafico'];
            	$this->tipoViaje = $fila['TipoViaje'];
            	$this->tarifa = $fila['Tarifa'];
            }

	}

	public function getDetalleCuota(){
			#try{

				$PDOmysql = consulta();

				$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = 'SELECT Tarifa,statusA, numero
						FROM   CuotaDetalle  
						WHERE 
						Cuota_idCuota = :cuota 
						and 
						Trafico = :trafico
						and
						TipoViaje = :tipo_viaje';

				$stmt = $PDOmysql->prepare($sql);
	            $stmt->bindParam(':cuota', $this->id_cuota);
	            $stmt->bindParam(':trafico', $this->trafico);
	            $stmt->bindParam(':tipo_viaje', $this->tipoViaje);
	            $stmt->execute();
	            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	            $respuesta =  $stmt->rowCount() ? true : false;

	            if($respuesta == false){
	            	throw new Exception("No recibe datos de la consulta", 1);
	            	
	            }

	            foreach ($rows as $fila ) {
	            	$this->valor = $fila['numero'];
	            	$this->tarifa = $fila['Tarifa'];
	            }

			#} catch(PDOException $e){

			#}
	}

	public function __toString(){
        return $this->id_cuota;
    }

	function get_id_cuota(){
		return $this->id_cuota;
	}

	function set_id_cuota($id_cuota){
		$this->id_cuota = $id_cuota;
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