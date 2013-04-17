<?php

# Clase controladora, que retornara resultados.

require_once("Dia.php");
require_once("Semana.php");
require_once("Mes.php");
require_once("Anio.php");

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
		$this->semana 		 =  date('W') - 1;
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
						$this->currentPage    = $consulta->semana;
					}
					else{
						$consulta->semana = $this->semana;
						$consulta->anio = $this->anio;
					}
					$this->contenido = $consulta->getRequest();

					$this->numeroPaginas = 52;
					
					break;
				case 'MES':
					$consulta = new Mes;
					if(isset($_GET['mes']) && isset($_GET['anio'])){
						$consulta->mes        = $_GET['mes'];
						$consulta->anio       = $_GET['anio'];
						$this->currentPage    = $consulta->mes;
					}
					else{
						$consulta->mes        = $this->mes;
						$consulta->anio       = $this->anio;
					}

					$this->contenido = $consulta->getRequest();
					$this->numeroPaginas = 12;
					break;
				case 'DIA':

					$consulta = new Dia;
					if(isset($_GET['dia']) && isset($_GET['anio'])){
						$consulta->dia      = $_GET['dia'];
						$consulta->anio     = $_GET['anio'];
						$this->currentPage  = $consulta->dia;
					}
					else{
						$consulta->dia = $this->dia;
						$consulta->anio = $this->anio;
					}

					 $this->contenido = $consulta->getRequest();
					 $this->numeroPaginas = 7;
					
					break;
				case 'ANIO':
					$consulta = new Anio;
					if(isset($_GET['anio'])){
						$consulta->anio       = $_GET['anio'];
						$this->currentPage    = $consulta->anio;
					}
					else{
						$consulta->anio       = $this->anio;
						$this->currentPage    = $this->anio;
					}

					$this->contenido = $consulta->getRequest();
					$this->numeroPaginas = 25;

					break;			
				default:
					break;
			}
		}
		else{
			$consulta = new Semana;
			$consulta->semana = $this->semana;
			$consulta->anio = $this->anio;
			$this->contenido = $consulta->getRequest();
		}
	}

	function display(){
		return '<div id="accordion2" class="accordion"><div class="accordion-group">  '. $this->contenido . '</div></div>';
	}

	function paginate(){
		for ($i=1; $i <= $this->numeroPaginas; $i++) { 
			# code...
		}
	}
	
}

?>