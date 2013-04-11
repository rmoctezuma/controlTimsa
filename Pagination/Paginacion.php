<?php

# Clase controladora, que retornara resultados.

require_once("Dia.php");
require_once("Semana.php");
require_once("Mes.php");
require_once("Año.php");

class Paginacion{
	var $anio;
	var $mes;
	var $semana;
	var $dia;
	var $currentPage;
	var $tipoConsulta;
	var $consulta;
	var $numeroPaginas;
	var $contenido;

	function Paginacion(){
		$this->tipoConsulta  = "SEMANA";
		$this->mes    		 =  date('m');
		$this->anio   		 =  date('Y');
		$this->dia    		 =  date('z') + 1;
		$this->semana 		 =  date('W');
		$this->currentPage   =  $this->semana;
		$this->numeroPaginas =  52;
		$this->contenido     =  "Sin resultados";
	}

	function paginate(){
		if(isset($_GET['tipoConsulta'])){
			switch ($_GET['tipoConsulta']) {
				case 'SEMANA':
					$consulta = new Semana;
					if(isset($_GET['semana']) && isset($_GET['anio'])){
						$consulta->semana     = $_GET['semana'];
						$consulta->anio       = $_GET['anio'];
						$this->currentPage    = $this->semana;
					}
					break;
				case 'MES':
					$consulta = new Mes;
					if(isset($_GET['semana']) && isset($_GET['anio'])){
						$consulta->semana     = $_GET['mes'];
						$consulta->anio       = $_GET['anio'];
						$this->currentPage    = $this->mes;
					}
					break;
				case 'DIA':

					$consulta = new Dia;
					if(isset($_GET['dia']) && isset($_GET['anio'])){
						$consulta->dia      = $_GET['dia'];
						$consulta->anio     = $_GET['anio'];
						$this->currentPage  = $this->dia;
					}
					else{
						$consulta->dia = $this->dia;
						$consulta->anio = $this->anio;
					}

					 $this->contenido = $consulta->getRequest();
					
					break;
				case 'AÑO':
					$consulta = new Año;
					if(isset($_GET['semana']) && isset($_GET['anio'])){
						$consulta->anio       = $_GET['anio'];
						$this->currentPage    = $this->año;
					}
					break;			
				default:
					break;
			}
		}
		else{
			$consulta = new Dia;
			$consulta->dia = $this->dia;
			$consulta->anio = $this->anio;
			$this->contenido = $consulta->getRequest();
		}
	}

	function display(){
		return $this->contenido;
	}
	
}

?>