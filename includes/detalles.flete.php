<?php

require_once("../includes/generic.connection.php");

$respuestaOK = true;
$mensajeError = "No se puede ejecutar la aplicación";
$contenidoOK = "";

       if(isset($_POST) && !empty($_POST)){

        $PDOmysql = consulta();
       	$value = $_POST['value'];
        
        try{


          $sql = 'SELECT distinct Operador.Nombre nombre,
           Operador.ApellidoP apellidop, Operador.ApellidoM apellidom, Operador.fecha_ingreso ingreso,
            Economico.Economico economico, Economico.Placas placas,

           Agencia.nombre agencia, CuotaDetalle.Trafico trafico, Socio.Nombre socio,

           CuotaDetalle.Tarifa tarifa, CuotaDetalle.TipoViaje TipoViaje,Flete.Fecha Fecha,Flete.statusA statusA, Flete.comentarios comentarios, Flete.fecha_llegada llegada, 
           Flete.fecha_facturacion fact, 

           ClienteDireccion.NombreSucursal

           from 

           Cuota,Socio,Flete, Operador, Economico, Cliente, CuotaDetalle, ClienteDireccion, 
           Agencia,VehiculoDetalle, Cuota_Flete

           where

           Operador.Eco = VehiculoDetalle.Operador and Economico.Economico = VehiculoDetalle.Economico and 
           Socio.idSocio = VehiculoDetalle.Socio
           and Flete.Operador = VehiculoDetalle.Operador and Flete.Economico = VehiculoDetalle.Economico and 
           Flete.Socio = VehiculoDetalle.Socio
           and Flete.Agencia_idAgente = Agencia.idAgente
           and Flete.idFlete = Cuota_Flete.NumFlete and Cuota_Flete.Sucursal = ClienteDireccion.Sucursal and 
           Cuota_Flete.TipoCuota = CuotaDetalle.numero and
            Cuota_Flete.Cuota = CuotaDetalle.Cuota_idCuota and CuotaDetalle.Cuota_idCuota = Cuota.idCuota and 
            Cuota.idCuota = ClienteDireccion.Cuota_idCuota 
            and ClienteDireccion.Cliente_idCliente = Cliente.idCliente and ClienteDireccion.Cuota_idCuota = Cuota.idCuota
            and ClienteDireccion.Sucursal = Cuota_Flete.Sucursal and ClienteDireccion.Cuota_idCuota = Cuota_Flete.Cuota
            and Flete.idFlete = :flete';


            //$fila =  $mysqli->query($sql);

                 $stmt = $PDOmysql->prepare($sql);
                 $stmt->bindParam(':flete', $value);
                 $stmt->execute();
                 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach($rows as $fila){

            $valorViaje = $fila['sucursal'].'-Lazaro';


           if( $fila['trafico'] != 'Reutilizado'){
              $valorViaje = 'Lazaro-'. $fila['sucursal'];
           }

            $contenidoOK .= '<div class="accordion-group">
                <div class="accordion-heading">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                    Operador
                  </a>
                </div>
                <div id="collapseOne" class="accordion-body collapse">
                  <div class="accordion-inner">
                    <h3> '. $fila['nombre'] .$fila['apellidop']. $fila['apellidom'] .'</h3> <hr>
                    <dl>
                      <dt>
                        Licencia  
                      </dt>
                      <dd>
                        <pre>' .$fila['licencia'].'</pre>
                      </dd>
                      <dt>
                        Vigencia
                      </dt>
                      <dd>
                        <pre>' .$fila['fechalicencia'].'</pre>
                      </dd>
                       <dt>
                        Telefono
                      </dt>
                      <dd>
                        <pre>' .$fila['tel'].'</pre>
                      </dd>
                       <dt>
                        En TIMSA desde
                      </dt>
                      <dd>
                        <pre>' .$fila['ingreso'].'</pre>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
              <div class="accordion-group">
                <div class="accordion-heading">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                    Economico
                  </a>
                </div>
                <div id="collapseTwo" class="accordion-body collapse">
                  <div class="accordion-inner">
                    <dl>
                       <dt>
                        Numero 
                      </dt>
                      <dd>
                        <pre>' .$fila['economico'].'</pre>
                      </dd>
                       <dt>
                        Placas
                      </dt>
                      <dd>
                        <pre>' .$fila['placas'].'</pre>
                      </dd>
                      <dt>
                        GPS
                      </dt>
                      <dd>
                        <pre>' .$fila['GPS'].'</pre>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
              <div class="accordion-group">
                <div class="accordion-heading">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseCliente">
                    Cliente
                  </a>
                </div>
                <div id="collapseCliente" class="accordion-body collapse">
                  <div class="accordion-inner">
                    <h3>' .$fila['cliente'].'</h3> <hr>
                    <dl>
                       <dt>
                        Sucursal
                      </dt>
                      <dd>
                      <br>
                        <pre> '.$fila['sucursal'].' </pre>
                      </dd>
                       <dt>
                        <big>Direccion</big>
                      </dt>
                      <dd>
                      <hr>
                         <address> <strong> ' .$fila['localidad'].'
                          </strong> <br> Calle ' .$fila['calle'].' <br> Numero ' .$fila['numero'].'
                          <br> Col. ' .$fila['colonia'].'
                          <br>  ' .$fila['estado'].', Mexico </address>
                      </dd>
                       <dt>
                        <big>Telefono</big>
                      </dt>
                      <dd>
                        '. $fila['telf'].'
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
              <div class="accordion-group">
                <div class="accordion-heading">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFlete">
                    Detalle Flete
                  </a>
                </div>
                <div id="collapseFlete" class="accordion-body collapse">
                  <div class="accordion-inner">
                    <h3> Flete '. $fila['agencia'].'  ' . $fila['cliente'] .'  '. $valorViaje.' </h3> <hr>
                    <dl>
                       <dt>
                        Viaje
                      </dt>
                      <dd>
                        <pre> '. $fila['trafico']. ' '. $fila['TipoViaje']  .'</pre>
                      </dd>
                       <dt>
                        Fecha de Inicio de Viaje
                      </dt>
                      <dd>
                         <pre> '. $fila['Fecha']. ' </pre>
                      </dd>
                      <dt>
                        Fecha de Termino de Viaje
                      </dt>
                      <dd>
                         <pre> '. $fila['llegada']. ' </pre>
                      </dd>
                      <dt>
                        Fecha de Facturacion
                      </dt>
                      <dd>
                         <pre>'. $fila['fact']. '</pre>
                      </dd>
                      <dt>
                        Comentarios
                      </dt>
                      <dd>
                         <pre>'. $fila['comentarios']. '</pre>
                      </dd>
                      <dt>
                        Status
                      </dt>
                      <dd>
                         <pre id="status" value="'.$fila['statusA'].'">'. $fila['statusA']. '</pre>
                      </dd>
                      <dt>
                        Tarifa 
                      </dt>
                      <dd>
                         <pre> '. $fila['tarifa']. '  </pre>
                      </dd>
                          <dt>
                        Socio 
                      </dt>
                      <dd>
                         <pre>'. $fila['socio']. '</pre>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>';

              if($fila['statusA'] == "Completo"){

               $newDisabled =  'disabled="disabled"';
               }
               else{
                 $disabled    = 'disabled= "disabled" ';
               }

              $contenidoOK.= '<div id="panelBotones">
                                <button class="btn btn-success" id="reutilizar" '. $newDisabled .'> Reutilizar Flete </button>
                                <button class="btn btn-danger" id="finalizarFlete" '. $newDisabled .'> Terminar Flete </button> 
                                <button class="btn btn-primary" id="facturarFlete" '.$disabled.'> Facturar </button> 
                                <h4></h4>
                              </div>';
          }

        }catch(PDOException $e){
          
        }               
}


$salidaJson = array("respuesta" => $respuestaOK,
          					"mensaje" => $mensajeError,
          					"contenido" => $contenidoOK);

echo json_encode($salidaJson);

?>