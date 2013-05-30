<?php

include_once("../includes/generic.connection.php");
require_once("Sucursal.php");

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

	public function obtenerSucursalesDeCliente($ID){
		try {  
		      $PDOmysql = consulta();

		      $sql = 'select distinct Sucursal id from ClienteDireccion where Cliente_idCliente = :cliente';

		      $stmt = $PDOmysql->prepare($sql);
		      $stmt->bindParam(':cliente', $ID);
		      $stmt->execute();
		      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		      $sucursales = array();

		      foreach ($rows as $fila) {

		      	$sucursal = new Sucursal;
		        $sucursal->getSucursalFromID($fila['id']);
		        $sucursales[] = $sucursal;

		      }

		     } catch(PDOException $ex) {
		         echo "An Error occured!"; //user friendly message
		         echo $ex->getMessage();
		    }

		    return $sucursales;
	}

	public function __toString(){
        return $this->idCliente;
    }

	function get_id(){
		return $this->idCliente;
	}

	function set_id($id){
		$this->idCliente = $id;
	}

	function get_nombre(){
		return $this->nombre;
	}

	function set_nombre($nombre){
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

	function get_imagen(){
		return $this->imagen;
	}

	function setImagen($img){
		$this->imagen = $img;
	}

}

?>