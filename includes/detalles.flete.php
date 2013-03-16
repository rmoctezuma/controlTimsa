<?php

$respuestaOK = true;
$mensajeError = "No se puede ejecutar la aplicación";
$contenidoOK = "";

      /*try {
            $mysqli = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387', array(
            PDO::ATTR_PERSISTENT => true
        ));
            $respuestaOK = true;
              } catch(PDOException $ex) {
              	  $respuestaOK = false;
                  echo "An Error occured!"; //user friendly message
                  echo $ex->getMessage();
                  $contenidoOK .= '
                      <tr id="sinDatos">
                        <td >ERROR AL CONECTAR CON LA BASE DE DATOS</td>
                        </tr>';
        }

        */

       if(isset($_POST) && !empty($_POST)){


       	$value = $_POST['value'];

        try {
            $mysqli = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');
            $errorDbConexion = false;
              } catch(PDOException $ex) {
                  echo "An Error occured!"; //user friendly message
                  echo $ex->getMessage();
                  $salida .= '
                      <tr id="sinDatos">
                        <td >ERROR AL CONECTAR CON LA BASE DE DATOS</td>
                        </tr>';

                  return $salida;
        }
        
        // FALTA AJUSTAR LA QUERY, PARA SELECCIONAR LA ULTIMA FECHA DE CADA LICENCIA.

        $sql = 'select distinct Operador.Nombre nombre,
         Operador.ApellidoP apellidop, Operador.ApellidoM apellidom, 
         Licencia_detalle.Licencia licencia, Licencia_detalle.FechaTerminoVigencia fechalicencia,
         Operador.Telefono tel, Operador.fecha_ingreso ingreso,
          Economico.Economico economico, Economico.Placas placas, GPS_Detalle.NumeroGPS GPS,

         Cliente.Nombre cliente,Cliente.fecha_ingreso ingreso_cliente, ClienteDireccion.Calle calle,  ClienteDireccion.Numero numero,
          ClienteDireccion.Colonia colonia,  ClienteDireccion.Localidad localidad ,  ClienteDireccion.Ciudad sucursal,
           ClienteDireccion.Estado estado,  ClienteDireccion.Telefono telf,

         Agencia.nombre agencia, CuotaDetalle.Trafico trafico, Socio.Nombre socio,


         CuotaDetalle.Tarifa tarifa, CuotaDetalle.TipoViaje TipoViaje,Flete.Fecha Fecha,Flete.statusA statusA, Flete.comentarios comentarios, Flete.fecha_llegada llegada, 
         Flete.fecha_facturacion fact

         from 

         Cuota,Socio,Flete, Operador, Economico, Cliente, CuotaDetalle, ClienteDireccion, 
         Agencia,VehiculoDetalle, Cuota_Flete, Licencia_detalle, GPS_Detalle

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
          and ClienteDireccion.Cliente_idCliente = Cuota_Flete.Cliente and ClienteDireccion.Cuota_idCuota = Cuota_Flete.Cuota
          and ClienteDireccion.Cliente_idCliente = Cliente.idCliente and GPS_Detalle.Economico = Economico.Economico and
           Licencia_detalle.Operador_Eco = Operador.Eco and Flete.idFlete = '.$value.';';


          //$fila =  $mysqli->query($sql);
          foreach($mysqli->query($sql) as $fila){

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
                         <pre>'. $fila['statusA']. '</pre>
                      </dd>
                      <dt>
                        Tarifa 
                      </dt>
                      <dd>
                         <pre> '. $fila['tarifa']. '  </pre>
                      </dd>
                          <dt>
                        Sucio 
                      </dt>
                      <dd>
                         <pre>'. $fila['socio']. '</pre>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>';
          }        
           
}


$salidaJson = array("respuesta" => $respuestaOK,
					"mensaje" => $mensajeError,
					"contenido" => $contenidoOK);

echo json_encode($salidaJson);

?>