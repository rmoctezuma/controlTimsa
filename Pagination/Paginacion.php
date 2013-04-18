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
		
		$this->mes    		 =  date('m');
		
		$this->dia    		 =  date('z') + 1;
		$this->semana 		 =  date('W') - 1;
		$this->currentPage   =  $this->semana;
		$this->numeroPaginas =  52;
		$this->contenido     =  "Sin resultados";

		if(isset($_GET['anio'])){ $this->anio = $_GET['anio']; } else { $this->anio =  date('Y');}
		if(isset($_GET['tipoConsulta']))  $this->tipoConsulta = $_GET['tipoConsulta'];  else $this->tipoConsulta  = "SEMANA";
	}

	function paginate(){
			switch ($this->tipoConsulta) {
				case 'SEMANA':
					$consulta = new Semana;
					if(isset($_GET['semana'])){
						$consulta->semana = $this->semana    = $_GET['semana'];
						$this->currentPage= $consulta->semana;
					}
					else{
						$consulta->semana = $this->semana;
					}
					$consulta->anio       = $this->anio;
					$this->contenido = $consulta->getRequest();

					$this->numeroPaginas = 52;
					
					break;
				case 'MES':
					$this->tipoConsulta = "MES";
					$consulta = new Mes;
					if(isset($_GET['mes'])){
						$consulta->mes        = $this->mes         = $_GET['mes'];
						$this->currentPage    = $consulta->mes;
					}
					else{
						$consulta->mes        = $this->mes;
					}

					$consulta->anio       = $this->anio;

					$this->contenido = $consulta->getRequest();
					$this->numeroPaginas = 12;
					break;
				case 'DIA':
					$this->tipoConsulta = "DIA";
					$consulta = new Dia;
					if(isset($_GET['dia']) ){
						$consulta->dia  = $this->dia       = $_GET['dia'];
						$this->currentPage  = $consulta->dia;
					}
					else{
						$consulta->dia = $this->dia;
					}
					 $consulta->anio       = $this->anio;
					 $this->contenido = $consulta->getRequest();
					 $this->numeroPaginas = 365;
					
					break;
				case 'ANIO':
					$this->tipoConsulta = "ANIO";
					$consulta = new Anio;
					if(isset($_GET['anio'])){
						$consulta->anio     = $this->anio      = $_GET['anio'];
						$this->currentPage  = $consulta->anio;
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

	function display(){
		return '<div id="accordion2" class="accordion"><div class="accordion-group">  '. $this->contenido . '</div></div>';
	}

	function crearPaginacion(){
		$paginas = '<div class="pagination pagination-large"><ul>';

		$tipo = strtolower($this->tipoConsulta);

		for ($i=1; $i <= $this->numeroPaginas; $i++) { 
			$paginas.= '<li><a href='."$_SERVER[PHP_SELF]?tipoConsulta=$this->tipoConsulta&$tipo=$i&anio=$this->anio".'>'.$i.'</a></li>';
		}

		$paginas .= '</ul></div>';

		return $paginas;
	}
	
}

?>