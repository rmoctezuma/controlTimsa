<?php
include_once("../includes/generic.connection.php");
require_once("Agencia.php");
require_once("Economico.php");
require_once("Socio.php");
require_once("Operador.php");


Class Flete{
	#Variables Principales;
	private $idFlete;
	private $fecha;
	private $status;
	private $comentarios;
	private $fecha_llegada;
	private $fecha_facturacion;

	#Objetos Foraneos;

	private $Agencia;
	private $Operador;
	private $Economico;
	private $Socio;
	private $FletePadre;

	#Cuota para el Flete

	private $Sucursal;
	private $Cuota;
	private $trafico;
	private $tipoCuota;

	#Contenedores

	private $listaContenedores;


	function Flete($id,$fecha,$status,$comentarios,$fecha_llegada,$fecha_facturacion, $agencia, $operador,$economico,$socio,
					$Sucursal,$cuota,$trafico,$tipoCuota,$contenedores){
		#inicializar variables;
		$this->idFlete = $id;
		$this->fecha = $fecha;
		$this->status = $status;
		$this->comentarios = $comentarios;
		$this->fecha_llegada = $fecha_llegada;
		$this->fecha_facturacion = $fecha_facturacion;
		#inicializar objetos;
		$this->Agencia = $agencia;
		$this->Operador =$operador ;
		$this->Economico = $economico;
		$this->Socio =$socio;
		#Cuotas
		$this->Sucursal = $Sucursal;
		$this->Cuota  = $cuota;
		$this->trafico = $trafico;
		$this->tipoCuota = $tipoCuota;
		#Contenedores
		$this->listaContenedores = $contenedores;
	}

	function getFleteFromID($id){
		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Flete  WHERE Flete.idFlete = :flete';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':flete', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	#Objetos que forman parte directa del Flete
            	$this->idFlete = $id;
            	$this->fecha   = $fila['Fecha'];
				$this->status  = $fila['statusA'];
				$this->comentarios  = $fila['comentarios'];
				$this->fecha_llegada  = $fila['fecha_llegada'];
				$this->fecha_facturacion  = $fila['fecha_facturacion'];

				#Objetos Foraneos;

				$this->Agencia  = $fila['Agencia_idAgente'];
				$this->Operador  = $fila['Operador'];
				$this->Economico  = $fila['Economico'];
				$this->Socio  = $fila['Socio'];
			}

			#Cuota para el Flete
			$sql = 'SELECT * FROM Flete  WHERE Flete.idFlete = :flete';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':flete', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

				

				$this->Sucursal  = $fila[''];
				$this->Cuota  = $fila[''];
				$this->trafico  = $fila[''];
				$this->tipoCuota  = $fila[''];

					#Contenedores

				$this->listaContenedores = $fila[''];

            
		} catch(PDOException $e){

		}
	}
	#Metodos de variables principales.
	function set_idFlete($ID){
		$this->idFlete = $ID;
	}
	function get_idFlete(){
		return $this->idFlete;
	}
	function set_fecha($fecha)){
		$this->$fecha = $fecha;
	}
	function get_fecha(){
		return $this->fecha;
	}
	function set_status($status){
		$this->status = $status;
	}
	function get_status(){
		return $this->status;
	}
	function set_comentarios($comen){
		$this->comentarios = $comen;
	}
	function get_comentarios(){
		return $this->comentarios;
	}
	function set_fecha_llegada($fecha){
		$this->fecha_llegada = $fecha;
	}
	function get_fecha_llegada(){
		return $this->fecha_llegada;
	}
	function set_fecha_facturacion($fecha){
		$this->fecha_facturacion = $fecha;
	}
	function get_fecha_facturacion(){
		return $this->fecha_facturacion;
	}
	#metodos de variables foraneas.

	function set_Agencia($Agencia){
		$this->Agencia = $Agencia;
	}
	function get_Agencia(){
		return $this->Agencia;
	}
	function set_Operador($Operador){
		$this->Operador = $Operador;
	}
	function get_Operador(){
		return $this->Operador;
	}
	function set_Economico($Economico){
		$this->Economico = $Economico;
	}
	function get_Economico(){
		return $this->Economico;
	}
	function set_Socio($Socio){
		$this->Socio = $Socio;
	}
	function get_Socio(){
		return $this->Socio;
	}
	function set_FletePadre($FletePadre){
		$this->FletePadre = $FletePadre;
	}
	function get_FletePadre(){
		return $this->FletePadre;
	}
	function set_Sucursal($Sucursal){
		$this->Sucursal = $Sucursal;
	}
	function get_Sucursal(){
		return $this->FletePadre;
	}
	function set_Cuota($Cuota){
		$this->Cuota = $Cuota;
	}
	function get_Cuota(){
		return $this->Cuota;
	}
	function set_trafico($trafico){
		$this->trafico = $trafico;
	}
	function get_trafico(){
		return $this->trafico;
	}
	function set_tipoCuota($tipoCuota){
		$this->tipoCuota = $tipoCuota;
	}
	function get_tipoCuota(){
		return $this->tipoCuota;
	}
	function set_listaContenedores($listaContenedores){
		$this->listaContenedores = $listaContenedores;
	}
	function get_listaContenedores(){
		return $this->listaContenedores;
	}
}
?>