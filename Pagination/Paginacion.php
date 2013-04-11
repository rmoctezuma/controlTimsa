<?php

# Clase controladora, que retornara resultados.

class Paginacion{
	var $anio;
	var $mes;
	var $semana;
	var $dia;
	var $currentPage;
	var $tipoConsulta;
	var $consulta;
	var $numeroPaginas;

	function Paginacion(){
		$this->tipoConsulta  = "SEMANA";
		$this->mes    		 =  date('m');
		$this->anio   		 =  date('Y');
		$this->dia    		 =  date('j');
		$this->semana 		 =  date('W');
		$this->currentPage   =  $this->semana;
		$this->numeroPaginas =  52;
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
					if(isset($_GET['dia'])){
						$consulta->dia      = $_GET['dia'];
						$this->currentPage  = $this->dia;
					}
					else{
						$consulta->dia = $this->dia;
					}

					$consulta->getRequest();
					
					break;
				case 'AÑO':
					break;			
				default:
					# code...
					break;
			}
		}
	}
	
}

?>