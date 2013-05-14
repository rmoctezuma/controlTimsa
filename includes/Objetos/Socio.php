<?php
include_once("../includes/generic.connection.php");

Class Socio{
	private $idSocio;
	private $Nombre;
	private $telefono;
	private $status;
	private $fecha_ingreso;
	private $fecha_deprecated;
	private $imagen;


	function createSocio($idSocio,$Nombre,$telefono,$status,$fecha_ingreso,$fecha_deprecated,$imagen){
		$this->idSocio = $idSocio;
		$this->Nombre = $Nombre;
		$this->telefono = $telefono;
		$this->status = $status;
		$this->fecha_ingreso = $fecha_ingreso;
		$this->fecha_deprecated = $fecha_deprecated;
		$this->imagen = $imagen;
	}

	function createSocioFromID($id){
		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Socio WHERE Socio.idSocio = :socio';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':socio', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	$this->idSocio = $fila['idSocio'];
				$this->Nombre = $fila['Nombre'];
				$this->telefono = $fila['Telefono'];
				$this->status = $fila['statusA'];
				$this->fecha_ingreso = $fila['fecha_ingreso'];
				$this->fecha_deprecated = $fila['fecha_deprecated'];
				$this->imagen = $fila['rutaImagen'];
            }
		} catch(PDOException $e){

		}
	}

	public function __toString(){
        return $this->idSocio;
    }

	function get_idSocio(){
		return $this->idSocio;
	}
	function set_idSocio($idSocio){
		$this->idSocio = $idSocio;
	}
	function get_Nombre(){
		return $this->Nombre;
	}
	function set_Nombre($Nombre){
		$this->Nombre = $Nombre;
	}
	function get_telefono(){
		return $this->telefono;
	}
	function set_telefono($telefono){
		$this->telefono = $telefono;
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
	function get_imagen(){
		return $this->imagen;
	}
	function set_imagen($imagen){
		$this->imagen = $imagen;
	}

}
?>