<?php

include_once("../includes/generic.connection.php");

Class Cliente{
	private  $idCliente;
	private  $nombre;
	private  $fecha;
	private  $status;
	private  $fechaSalida;
	private  $imagen;


	function createCliente($id,$nombre,$fecha,$status,$fechaSalida,$img){
			$this->idCliente = $id;
			$this->nombre = $nombre;
			$this->fecha = $fecha;
			$this->status = $status;
			$this->fechaSalida = $fechaSalida;
			$this->imagen = $img;
	}

	function incializarClienteConIdentificador($idCliente){
		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Cliente  WHERE Cliente.idCliente = :cliente';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':cliente', $idCliente);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	$this->idCliente = $fila['idCliente'];
            	$this->nombre = $fila['Nombre'];
            	$this->fecha = $fila['fecha_ingreso'];
            	$this->status = $fila['statusA'];
            	$this->fechaSalida = $fila['fecha_deprecated'];
            	$this->imagen = $fila['rutaImagen'];
            }
		} catch(PDOException $e){

		}
	}

	public function __toString(){
        return $this->idCliente;
    }

	function getID(){
		return $this->idCliente;
	}

	function setID($id){
		$this->idCliente = $id;
	}

	function getNombre(){
		return $this->nombre;
	}

	function setNombre($nombre){
		$this->nombre = $nombre;
	}

	function getFecha(){
		return $this->$fecha;
	}

	function setFecha($fecha){
		$this->fecha = $fecha;
	}

	function getStatus(){
		return $this->fecha;
	}

	function setStatus($status){
		$this->status = $status;
	}

	function getFechaSalida(){
		return $this->fechaSalida;
	}

	function setFechaSalida($fecha){
		$this->fechaSalida = $fecha;
	}

	function getImagen(){
		return $this->imagen;
	}

	function setImagen($img){
		$this->imagen = $img;
	}

}

?>