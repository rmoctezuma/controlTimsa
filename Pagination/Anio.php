<?php

require_once("../includes/generic.connection.php");

class Anio{
	var $anio;

	var $contenido;

	function Dia(){
	}

	function getRequest(){
		$PDOmysql = consulta();
		$rows = "";

		 return $this->formattedRequest(12);
	}

	function formattedRequest($meses){

		$this->contenido .='<div class="accordion-heading">
						      <a class="accordion-toggle" data-toggle="collapse" href="#'.$this->anio.'">
						        '.$this->anio .'
						      </a>
						    </div>';

		$this->contenido .=	 '<div id="'. $this->anio .'" class="accordion-body collapse in">
						    		<div class="accordion-inner">';
		$this->contenido .= '<div class="accordion-group">';

		for ($i=1; $i <= $meses ; $i++) { 
				$mes = new Mes;
				$mes->anio   = $this->anio;
				$mes->mes = $i;

				$this->contenido .= $mes->getRequest();
		}

			$this->contenido .=  '</div> </div>';	 
			$this->contenido .= '</div>';
		return $this->contenido;
	}
}

?>