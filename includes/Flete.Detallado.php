<?php

require_once("../includes/generic.connection.php");
require_once("Objetos/Flete.php");

$contenido = "";

      if(isset($_POST['value']) && !empty($_POST['value'])){

        $PDOmysql = consulta();
       	$value = $_POST['value'];
        $viaje = $_POST['viaje'];

        $flete = new Flete;
        $flete->getFleteFromID($value);

        $contenido .= '<div class="span9">';

        $contenido .= '<input id="flete" class="hidden" value="'.$value.'">';

        if (strpos($viaje,'Importacion') !== false) {
          $newDisabled = "";

            if($flete->get_FleteHijo()){
              $contenido .=    '<div class="alert span15">
                                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 <strong>Este Flete ya fue Reutilizado</strong> .
                                </div>';
              $newDisabled = "disabled= 'disabled'";
            }
        }
        else{
           $newDisabled = "disabled= 'disabled'"; 
        }

              $contenido.= '<div id="panelBotones span13">
                                <button class="btn btn-success" id="reutilizar" '. $newDisabled .'> Reutilizar Flete </button>
                                <button class="btn btn-inverse" id="finalizarFlete" > Terminar Flete </button> 
                                <button class="btn btn-primary" id="facturarFlete" '.$disabled.'> Facturar </button> 
                                <button class="btn btn-danger" id="cancelarFlete"> Cancelar Flete </button>
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
                           <div id="datosOperador">
				                    <div class="span4">
				                    	<img src="'.$operador->get_imagen().'">
                              <button id="cambioOperador" class="btn btn-info btn-mini text-center">Cambiar Operador</button>
				                    </div>
				                    <div class="span8">
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
                                  <div id="datosEconomico">
       					                    <div class="span4">
       					                    	<img src="'.$socio->get_imagen().'">
                                        <button id="cambioEconomico" class="btn btn-info btn-mini text-center">Cambiar Economico</button>
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
                                        <div id="datosCliente">
               					                    <div class="span4">
               					                    	<img src="'.$cliente->get_imagen().'">
                                                <button id="cambioCliente" class="btn btn-info btn-mini text-center">Cambiar Cliente</button>
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

                              $contenedores =    $flete->get_listaContenedores()->get_contenedores();

                              $contenidoContenedores = "";

                              for ($i=0; $i < count($contenedores); $i++) {
                                    $contenidoContenedores .= '<div>
                                                                <dl class="dl-horizontal">
                                                                  <dt>Contenedor</dt>
                                                                  <dd>'.$contenedores[$i]->get_id().'</dd>
                                                                  <dt>Tipo</dt>
                                                                  <dd>'.$contenedores[$i]->get_tipo().'</dd>
                                                                  <dt>WorkOrder</dt>
                                                                  <dd>'.$contenedores[$i]->get_workorder().'</dd>
                                                                  <dt>Booking</dt>
                                                                  <dd>'.$contenedores[$i]->get_booking().'</dd>
                                                                </dl>';

                                                                $sellos = $contenedores[$i]->get_sellos();

                                                                $contenidoDeSellos = '<div>
                                                                                      <table class="table">
                                                                                        <thead>
                                                                                          <th>#</th>
                                                                                          <th>Sello</th>
                                                                                          <th>Fecha</th>
                                                                                        </thead>
                                                                                        <tbody>';

                                                                while($sellos->hasNext()){
                                                                  $sello = $sellos->shift();

                                                                  $contenidoDeSellos .= '<tr>
                                                                                           <td>'.$sello->get_numero_sello().'</td>
                                                                                           <td>'.$sello->get_sello() .'</td>
                                                                                           <td><input type="datetime" readonly value="'. $sello->get_fecha_sellado() .'"</td>
                                                                                        </tr>';
                                                                }

                                                                $contenidoDeSellos .= ' </tbody>
                                                                                      </table>
                                                                                      </div>';

                                                                $contenidoContenedores .= $contenidoDeSellos;

                                                                
                                                                      
                                      $contenidoContenedores .= '</div>';
                              }

                              $contenido .= '<div class="accordion-group">
                                                    <div class="accordion-heading">
                                                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseContenedor">
                                                        Contenedores
                                                      </a>
                                                    </div>
                                                      <div id="collapseContenedor" class="accordion-body collapse in">
                                                        <div class="accordion-inner">
                                                              '.$contenidoContenedores.'
                                                      </div>

                                                        
                                                    </div>
                                                   </div>';

                            $contenido .='</div><br>';

                            $contenido .='<div class="span3">';

                            $estado = $flete->get_status();

                             $contenido .='<h2>Estado</h2>';

                            switch ($estado) {
                              case 'Programado':
                                $contenido .='
                                              <p><input type="radio" name="status" value="Programado" checked> Programado</p>
                                              <p><input type="radio" name="status" value="Activo"> Activo</p>
                                              <p><input type="radio" name="status" value="Pendiente"> Pendiente de Facturacion</p>';
                                break;
                              
                              case 'Activo':
                                $contenido .='
                                              <p><input type="radio" name="status" value="Programado"> Programado</p>
                                              <p><input type="radio" name="status" value="Activo" checked> Activo</p>
                                              <p><input type="radio" name="status" value="Pendiente"> Pendiente de Facturacion</p>';                                break;

                              case 'Pendiente Facturacion':
                                $contenido .='
                                              <p><input type="radio" name="status" value="Programado"> Programado</p>
                                              <p><input type="radio" name="status" value="Activo"> Activo</p>
                                              <p><input type="radio" name="status" value="Pendiente" checked> Pendiente de Facturacion</p>';                                break;

                              case 'Completo':
                                 $contenido .= '<h4> Flete Completo </h4>';
                                break;

                              case 'Cancelado':
                                $contenido .='<h4>El flete fue cancelado</h4>';
                                break;
                            }

                            $contenido .='<h3>Documentacion</h3>';

                            $contenido .='</div>';


       }
       else{
       	$contenido = "No se puede mostrar el detalle de este Flete";
       }

$salidaJson = array("respuesta" => $respuestaOK,
          			"mensaje" => $mensajeError,
          			"contenido" => $contenido);

echo json_encode($salidaJson);

?>