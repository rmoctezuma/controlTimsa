<?php

// Constantes conexión con la base de datos

// Variable que indica el status de la conexión a la base de datos

// Función para extraer el listado de usuarios
function consultaFletes(){
      $salida = '';

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

        $sql = 'select distinct Flete.idFlete idFlete, Operador.Nombre nombre,
         Operador.ApellidoP apellidop, Operador.ApellidoM apellidom, Economico.Economico economico, Economico.Placas placas, 
         Cliente.Nombre cliente, ClienteDireccion.Localidad sucursal,Agencia.nombre agencia, CuotaDetalle.Trafico trafico,
         CuotaDetalle.TipoViaje TipoViaje,Flete.Fecha Fecha,Flete.statusA statusA 
         from 
         Cuota,Socio,Flete, Operador, Economico, Cliente, CuotaDetalle, ClienteDireccion, Agencia,VehiculoDetalle, Cuota_Flete
         where
         Operador.Eco = VehiculoDetalle.Operador and Economico.Economico = VehiculoDetalle.Economico and Socio.idSocio = VehiculoDetalle.Socio
         and Flete.Operador = VehiculoDetalle.Operador and Flete.Economico = VehiculoDetalle.Economico and Flete.Socio = VehiculoDetalle.Socio
         and Flete.Agencia_idAgente = Agencia.idAgente
         and Flete.idFlete = Cuota_Flete.NumFlete and Cuota_Flete.Cliente = Cliente.idCliente and Cuota_Flete.TipoCuota = CuotaDetalle.numero and
          Cuota_Flete.Cuota = CuotaDetalle.Cuota_idCuota and CuotaDetalle.Cuota_idCuota = Cuota.idCuota and Cuota.idCuota = ClienteDireccion.Cuota_idCuota 
          and ClienteDireccion.Cliente_idCliente = Cliente.idCliente 
          ORDER BY idFlete ASC';

          
          $statusTipo = array("Activo" => "label label-info",
                              "Pendiente Facturacion" => "label label-warning",
                              "Completo" => "label label-success",
                              "Fallido" => "label label-important"
                              );


            foreach($mysqli->query($sql) as $fila){
                  $salida.='
                          <tr>
                            <td>'. $fila['idFlete'].' </td>
                            <td>'. $fila['nombre']. $fila['apellidop']. $fila['apellidom'].' </td>
                            <td>'. $fila['economico']. ' </td>
                            <td> '. $fila['placas'].' </td>
                            <td>'. $fila['cliente']  . ' </td>  
                            <td>'. $fila['sucursal'] . '  </td> 
                            <td>'. $fila['agencia']  . '  </td> 
                            <td>'. $fila['trafico']  . '  </td>
                            <td>'. $fila['TipoViaje'].'  </td>
                            <td> <span class="'.$statusTipo[$fila['statusA']].'">'.$fila['statusA'] .' </span>  </td>
                            <td>'. $fila['Fecha']    .'  </td>
                            <td> <button class="demo btn btn-success btn-mini" data-toggle="modal" href="#responsive">Detalles</button> <td>
                          </tr>';
            }       
	return $salida;
}
// Verificar constantes para conexión al servidor

	// Conexión con la base de datos	
?>