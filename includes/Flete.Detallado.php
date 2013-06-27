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

        $contenido .= '<div class="span8">';

        $contenido .= '<input id="flete" class="hidden" value="'.$value.'">';

        $estado = $flete->get_status();

        if ( $estado !== 'Pendiente Facturacion') {
          $deshabilitado = "disabled= 'disabled'";
        }

        if( $estado !== 'Completo' ){
          $deshabilitadoFacturacion = "disabled= 'disabled'";
        }

        if( $estado == 'Cancelado' || $estado == 'Completo'){
          $disabledCancelado = "disabled= 'disabled'";
        }

        if (strpos($viaje,'Importacion') !== false) {
          $newDisabled = "";

            if($flete->get_FleteHijo()){
              $contenido .=    '<div class="alert span12">
                                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 <strong>Este Flete ya fue Reutilizado</strong> .
                                </div>';
              $newDisabled = "disabled= 'disabled'";
            }
        }
        else{
           $newDisabled = "disabled= 'disabled'";
        }

              $contenido.= '<div id="panelBotones">  
                                <button class="btn btn-success" id="reutilizar" '. $newDisabled .' '.$disabledCancelado.' > Reutilizar Flete </button>
                                <button class="btn btn-inverse" id="finalizarFlete" '.$deshabilitado.'> Terminar Flete </button> 
                                <button class="btn btn-primary" id="facturarFlete" '.$deshabilitadoFacturacion.'> Facturar </button> 
                                <button class="btn btn-danger" id="cancelarFlete" '.$disabledCancelado.'> Cancelar Flete </button>
                                <h4></h4>
                              </div>';

       	$operador = $flete->get_Operador();

       	#Contenido de Operador
       	$contenido .= '<div class="accordion-group" >
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
                              <button '. $disabledCancelado .' id="cambioOperador" class="btn btn-info btn-mini text-center botonesUpdate">Cambiar Operador</button>
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
                                        <button '. $disabledCancelado .' id="cambioEconomico" class="btn btn-info btn-mini text-center botonesUpdate">Cambiar Economico</button>
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
                                                <button '. $disabledCancelado .' id="cambioCliente" class="btn btn-info btn-mini text-center botonesUpdate">Cambiar Cliente</button>
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

                              $contenidoContenedores = "<button id='editarViaje' class='btn btn-large btn-info'> Editar Viaje </button>";

                              for ($i=0; $i < count($contenedores); $i++) {
                                    $contenidoContenedores .= '<div class="contenedor">
                                                                <dl class="dl-horizontal">
                                                                  <dt>Contenedor</dt>
                                                                  <dd> <input type="text" value="'.$contenedores[$i]->get_id().'" class="contenedorDeViaje" readonly></dd>
                                                                  <dt>Tipo</dt>
                                                                  <dd>
                                                                    <select class="tipoContenedorDeViaje" readonly disabled>';

                                    $valores        = array("40HC", "40DC", "20HC", "20DC");                               
                                    $tipoContenedor =   $contenedores[$i]->get_tipo();

                                    for ($e=0; $e < count($valores); $e++) {
                                          if($tipoContenedor == $valores[$e]){ 
                                                $contenidoContenedores.= '<option value="'.$valores[$e].'" selected> '.$valores[$e].'</option>';
                                          }
                                          else{
                                                $contenidoContenedores.= '<option value="'.$valores[$e].'"> '.$valores[$e].'</option>';  
                                          }
                                    }
                                                                    
                                    $contenidoContenedores .=       '</select>
                                                                  </dd>
                                                                  <dt>WorkOrder</dt>
                                                                  <dd> <input type="text" value="'.$contenedores[$i]->get_workorder().' " class="workorderDeViaje" readonly></dd>
                                                                  <dt>Booking</dt>
                                                                  <dd><input type="text" value="'.$contenedores[$i]->get_booking().' " class="bookingDeViaje" readonly></dd>
                                                                  <dt> Modificar </dt>
                                                                  <dd> <td><button value="'.$contenedores[$i]->get_id().'" class="btn btn-mini btn-inverse modificarContenedor">Modificar</button></td> </dd>
                                                                </dl>';

                                                                $sellos = $contenedores[$i]->get_sellos();

                                                                $contenidoDeSellos = '<div>
                                                                                      <table class="table">
                                                                                        <thead>
                                                                                          <th>#</th>
                                                                                          <th>Sello</th>
                                                                                          <th>Fecha</th>
                                                                                          <th>Accion</th>
                                                                                        </thead>
                                                                                        <tbody>';

                                                                while($sellos->hasNext()){
                                                                  $sello = $sellos->shift();

                                                                $contenidoDeSellos .= '<tr>
                                                                                           <td>'.$sello->get_numero_sello().'</td>
                                                                                           <td> <input type="text" class="muestraSello" value="'.$sello->get_sello() .'" readonly  ></td>
                                                                                           <td><input type="datetime" readonly value="'. $sello->get_fecha_sellado() .'"</td>
                                                                                           <td> <button class="btn btn-mini editarSello" value="'.$sello->get_numero_sello().'" > Modificar Sello </button> </td>
                                                                                        </tr>';
                                                                }

                                                                $contenidoDeSellos .= '   <tr>
                                                                                            <td></td> 
                                                                                            <td><label>Nombre del Sello</label><input type="text"> <button value="'.$contenedores[$i]->get_id().'" class="btn agregarSello">Agregar Sello</button> </td>
                                                                                            <td> <button value="'.$contenedores[$i]->get_id().'" class="btn btn-danger eliminarSello"> Elimnar Ultimo Sello </button> </td>
                                                                                          </tr>
                                                                                        </tbody>
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

                            $contenido .='<div class="span4">';
                            $contenido .='<h2>Estado</h2>';

                            switch ($estado) {
                              case 'Programado':
                                $contenido .='
                                              <span class="label label-warning" id="textoEstado"> <h4>Flete Programado</h4> </span>
                                              <div id="definicionEstados">
                                              <p><input type="radio" name="status" value="Programado" checked> Programado</p>
                                              <p><input type="radio" name="status" value="Activo"> Activo</p>
                                              <p><input type="radio" name="status" value="Pendiente Facturacion"> Pendiente de Facturacion</p>
                                              <button class="btn" id="cambiarEstado">Cambiar Status</button>
                                              </div>';

                                break;
                              
                              case 'Activo':
                                $contenido .='
                                              <span class="label label-info" id="textoEstado"> <h4>Flete Activo</h4> </span>
                                              <div id="definicionEstados">
                                              <p><input type="radio" name="status" value="Programado"> Programado</p>
                                              <p><input type="radio" name="status" value="Activo" checked> Activo</p>
                                              <p><input type="radio" name="status" value="Pendiente Facturacion"> Pendiente de Facturacion</p>
                                              <button class="btn" id="cambiarEstado">Cambiar Status</button>
                                              </div>';                                
                                  break;
                              case 'Pendiente Facturacion':
                                $contenido .='
                                              <span class="label" id="textoEstado"> <h4>Flete Pendiente</h4> </span>
                                              <div id="definicionEstados">
                                              <p><input type="radio" name="status" value="Programado"> Programado</p>
                                              <p><input type="radio" name="status" value="Activo"> Activo</p>
                                              <p><input type="radio" name="status" value="Pendiente Facturacion" checked> Pendiente de Facturacion</p>
                                              <button class="btn" id="cambiarEstado">Cambiar Status</button>
                                              </div>';                                
                                  break;
                              case 'Completo':
                                 $contenido .= '<span id="textoEstado" class="label label-success"><h4> Flete Completo </h4></span>';
                                break;

                              case 'Cancelado':
                                $contenido .='<span id="textoEstado" class="label label-important"><h4>El flete fue cancelado</h4></span>';
                                break;
                            }

                            $contenido .='</div>';

                            

                            $contenido .='<div class="span4" id="comentarios">
                                          <h3>Documentacion</h3>
                                          <h4> Comentarios </h4>
                                          <textarea style="width: 316px; heighh:91px" readonly>
                                            '. $flete->get_comentarios() .'
                                          </textarea>
                                          </div>';

                            $cuota = $flete->get_CuotaViaje();

                            $contenido .='<div class="span4" id="datosViaje">
                                            <dl>
                                              <dt>Tipo de Viaje </dt>
                                              <dd id="tipoViaje">'. $cuota->get_tipoViaje() .'</dd>
                                              <dt>Trafico</dt>
                                              <dd id="trafico">'. $cuota->get_trafico() .'</dd>
                                              <dt> Tarifa </dt>
                                              <dd> '. $cuota->get_tarifa() .' </dd>
                                            </dl>
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