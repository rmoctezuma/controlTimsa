<?php
include_once("../includes/generic.connection.php");
require_once("Agencia.php");
require_once("Economico.php");
require_once("Socio.php");
require_once("Operador.php");
require_once("ListaContenedorViaje.php");
require_once("CuotaViaje.php");
require_once("Sucursal.php");


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
	private $FleteHijo;

	#Cuota para el Flete

	private $Sucursal;
	private $CuotaViaje;

	#Contenedores

	private $listaContenedores;


	function createFlete($comentarios, $agencia, $operador,$economico,$socio,
					     $Sucursal,$cuotaViaje,$contenedores){
		#inicializar variables;
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
		$this->CuotaViaje = $cuotaViaje; 
		#Contenedores
		$this->listaContenedores = $contenedores;
	}

	function getFleteFromID($id){
		#try{

			$PDOmysql = consulta();

			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

				$this->Agencia  = new Agencia;
				$this->Agencia->inicializarAgenciaConIdenttificador($fila['Agencia_idAgente']);
				$this->Operador  = new Operador;
				$this->Operador->getOperadorFromID($fila['Operador']);
				$this->Economico  = new Economico;
				$this->Economico->createEconomicoFromID($fila['Economico']);
				$this->Socio  = new Socio;
				$this->Socio->createSocioFromID( $fila['Socio']);

				$this->FletePadre = $fila['FletePadre'];

				$this->FleteHijo = $fila['FleteHijo'];
			}

			#Cuota para el Flete
			$sql = 'SELECT * FROM Cuota_Flete  WHERE NumFlete = :flete';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':flete', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->Sucursal  = new Sucursal;

			foreach ($rows as $fila) {
				$this->Sucursal->getSucursalFromID($fila['Sucursal']);
				$this->CuotaViaje  = new CuotaViaje;
				$this->CuotaViaje->getCuotaFromid_cuota($fila['Cuota'] , $fila['TipoCuota']); 
			}

			#Contenedores

			$this->listaContenedores = new ListaContenedorViaje;
			$this->listaContenedores->getContenedoresDeViaje($id);
			
            
		#} catch(PDOException $e){

		#}
	}

	public function insertar_flete(){
		try{

			$PDOmysql = consulta();
			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = 'INSERT INTO Flete(Agencia_idAgente,comentarios,Operador,Economico,Socio,FletePadre)
				               VALUES(:agencia, :comentarios, :operador, :economico, :socio, :fletePadre)';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':agencia', $this->Agencia);
            $stmt->bindParam(':comentarios', $this->comentarios);
            $stmt->bindParam(':operador', $this->Operador);
            $stmt->bindParam(':economico', $this->Economico);
            $stmt->bindParam(':socio', $this->Socio);
            $stmt->bindParam(':fletePadre', $this->FletePadre);
            $stmt->execute();

            $this->idFlete = $PDOmysql->lastInsertId();

        } catch(PDOException $e){

        }
	}

	public function generar_cuota_viaje(){
			#try{

				$PDOmysql = consulta();

				$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = 'INSERT INTO Cuota_Flete(NumFlete, tipoCuota,Cuota,Sucursal)
					                     VALUES(:flete, :tipo_cuota, :cuota, :sucursal)';

				$stmt = $PDOmysql->prepare($sql);
	            $stmt->bindParam(':flete', $this->idFlete);
	            $stmt->bindParam(':tipo_cuota', $this->CuotaViaje->get_valor());
	            $stmt->bindParam(':cuota', $this->CuotaViaje->get_id_cuota());
	            $stmt->bindParam(':sucursal', $this->Sucursal);
	            $stmt->execute();

	        #} catch(PDOException $e){

	       # }
	}

	public function update($campo,$nuevoValor){
		$PDOmysql = consulta();
		$sql = 'update Flete set $campo = :value where idFlete = :flete';
		$stmt = $PDOmysql->prepare($sql);
        $stmt->bindParam(':value', $nuevoValor);
        $stmt->bindParam(':flete', $this->idFlete);
        $stmt->execute();
	}

	public function updateMany($diccionario){
		$PDOmysql = consulta();
		$sql = 'update Flete set';

		foreach ($diccionario as $key => $value) {
			$sql = ' :value where idFlete = :flete';
		}

		$sql = 'where idFlete = :flete';
		

		$stmt = $PDOmysql->prepare($sql);
        $stmt->bindParam(':value', $nuevoValor);
        $stmt->bindParam(':flete', $this->idFlete);
        $stmt->execute();
	}

	public function __toString(){
        return $this->idFlete;
    }
	#Metodos de variables principales.
	function set_idFlete($ID){
		$this->idFlete = $ID;
	}
	function get_idFlete(){
		return $this->idFlete;
	}
	function set_fecha($fecha){
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
		return $this->Sucursal;
	}
	function set_CuotaViaje($Cuota){
		$this->CuotaViaje = $Cuota;
	}
	function get_CuotaViaje(){
		return $this->CuotaViaje;
	}
	
	function set_listaContenedores($listaContenedores){
		$this->listaContenedores = $listaContenedores;
	}
	function get_listaContenedores(){
		return $this->listaContenedores;
	}

	function set_FleteHijo($hijo){
		$this->FleteHijo = $hijo;
	}
	function get_FleteHijo(){
		return $this->FleteHijo;
	}
}
?>