<?php

# Clase controladora, que retornara resultados.

require_once("Dia.php");

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
					# code...
					break;
				case 'MES':
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