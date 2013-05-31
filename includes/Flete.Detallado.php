<?php

require_once("../includes/generic.connection.php");
require_once("Objetos/Flete.php");

$contenido = "";

      if(isset($_POST['value']) && !empty($_POST['value'])){

        $PDOmysql = consulta();
       	$value = $_POST['value'];

       	$flete = new Flete;
       	$flete->getFleteFromID($value);

              $contenido.= '<div id="panelBotones">
                                <button class="btn btn-success" id="reutilizar" '. $newDisabled .'> Reutilizar Flete </button>
                                <button class="btn btn-danger" id="finalizarFlete" '. $newDisabled .'> Terminar Flete </button> 
                                <button class="btn btn-primary" id="facturarFlete" '.$disabled.'> Facturar </button> 
                                <h4></h4>
                              </div>';

       	$operador = $flete->get_Operador();

       	#Contenido de Operador
       	$contenido .= '<div class="accordion-group">
       						<div class="accordion-heading">
			                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
			                    Operador
			                  </a>
			                </div>
			                  <div id="collapseOne" class="accordion-body collapse in">
			                    <div class="accordion-inner">
				                    <div class="span4">
				                    	<img src="'.$operador->get_imagen().'">
				                    </div>
				                    <div class="span6">
				                      <h3> '. $operador->get_nombre() . ' ' . $operador->get_apellidop() .' ' . $operador->get_apellidom() .'</h3> <hr>
				                      <dl class="dl-horizontal">
				                      		<dt>Numero de Operador</dt>
				                      		<dd>'. $operador->get_id() . '</dd>
				                      		<dt>Telefono</dt>
				                      		<dd>'. $operador->get_telefono() . '</dd>
				                      </dl>
				                      </div>
				                    </div>


			                  </div>
			                </div>
       				   </div>';

       			$economico = $flete->get_Economico();
       			$socio = $flete->get_Socio();

       			#Contenido de Economico y Socio
       	       	$contenido .= '<div class="accordion-group">
       	       						<div class="accordion-heading">
       				                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseEconomico">
       				                    Economico
       				                  </a>
       				                </div>
       				                  <div id="collapseEconomico" class="accordion-body collapse in">
       				                    <div class="accordion-inner">
       					                    <div class="span4">
       					                    	<img src="'.$socio->get_imagen().'">
       					                    </div>
       					                    <div class="span6">
       					                      <h3> '. $economico->get_id()  .'</h3> <hr>
       					                      <dl class="dl-horizontal">
       					                      		<dt>Socio Propietario</dt>
       					                      		<dd>'. $socio->get_Nombre() . '</dd>
       					                      		<dt>Contacto</dt>
       					                      		<dd>'. $socio->get_telefono() . '</dd>
       					                      		<dt>Placas</dt>
       					                      		<dd>'. $economico->get_placas() . '</dd>
       					                      		<dt>Numero de Serie</dt>
       					                      		<dd>'. $economico->get_serie() . '</dd>
       					                      		<dt>Modelo</dt>
       					                      		<dd>'. $economico->get_modelo() . '</dd>
       					                      		<dt>Marca</dt>
       					                      		<dd>'. $economico->get_marca() . '</dd>
       					                      		<dt>Tipo de Vehiculo</dt>
       					                      		<dd>'. $economico->get_tipoVehiculo() . '</dd>
       					                      		<dt>Transponder</dt>
       					                      		<dd>'. $economico->get_transponder() . '</dd>
       					                      </dl>
       					                      </div>
       					                    </div>

       				                    
       				                  </div>
       				                </div>
       	       				   </div>';

       	       	$sucursal = $flete->get_Sucursal();
       	       	$cliente = $sucursal->get_Cliente();
       	       	#Contenido de Cliente y sucursal.			   
       	       	$contenido .= '<div class="accordion-group">
       	       						<div class="accordion-heading">
       				                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseCliente">
       				                    Cliente
       				                  </a>
       				                </div>
       				                  <div id="collapseCliente" class="accordion-body collapse in">
       				                    <div class="accordion-inner">
       					                    <div class="span4">
       					                    	<img src="'.$cliente->get_imagen().'">
       					                    </div>
       					                    <div class="span6">
       					                      <h3> '. $cliente->get_nombre()  .'</h3> <hr>
       					                      <dl class="dl-horizontal">
       					                      		<dt>Sucursal de Viaje</dt>
       					                      		<dd>'. $sucursal->get_nombreSucursal() . '</dd>
       					                      </dl>
       					                      <address>
       					                      		'.$sucursal->get_calle() .' '.$sucursal->get_numero() .'
       					                      		'.$sucursal->get_colonia() .'
       					                      		'.$sucursal->get_localidad() .'
       					                      		'.$sucursal->get_estado() .'
       					                      		'.$sucursal->get_telefono() .'
       					                      </address>
       					                      </div>
       					                    </div>

       				                    
       				                  </div>
       				                </div>
       	       				   </div>';




       }
       else{
       	$contenido = "No se puede mostrar el detalle de este Flete";
       }

$salidaJson = array("respuesta" => $respuestaOK,
          			"mensaje" => $mensajeError,
          			"contenido" => $contenido);

echo json_encode($salidaJson);

?>