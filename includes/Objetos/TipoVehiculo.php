<?php
include_once("../includes/generic.connection.php");

class TipoVehiculo{
	private $id;
	private $nombre;


	public function createnombre($id,$nombre){
		$this->id = $id;
		$this->nombre = $nombre;
	}

	public function getFromID($id){
			$PDOmysql = consulta();

			$sql = 'SELECT Nombre FROM TipoVehiculo WHERE idTipoVehiculo = :nombre';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':nombre', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->id = $id;

            foreach ($rows as $fila) {
            	$this->nombre = $fila['Nombre'];
            }
	}

	public function __toString(){
	        return $this->nombre . "";
	}

	public function get_id(){
		return $this->id;
	}

	public function set_id($parametro){
		$this->id = $parametro;
	}

	public function get_nombre(){
		return $this->nombre;
	}

	public function set_nombre($parametro){
		$this->nombre = $parametro;
	}
	
}
?>