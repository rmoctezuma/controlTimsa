<?php

// Constantes conexión con la base de datos

// Variable que indica el status de la conexión a la base de datos

// Función para extraer el listado de usuarios

include('../includes/generic.connection.php');

function consultaFletes(){
      $salida = '';


      $statusTipo = array("Activo" => "label label-info",
                              "Pendiente Facturacion" => "label label-warning",
                              "Completo" => "label label-success",
                              "Fallido" => "label label-important"
                              );

        date_default_timezone_set('UTC');
        //$fechaActual = mktime(0,0,0,date('m') , date('d') -1 , date('Y'));
        #$hoy = strtotime($fechaActual);
        $hoy = date('Y-m-d');

        try{
              $mysqli = consulta();
              $mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = 'select distinct Flete.idFlete idFlete, Operador.Nombre nombre,
           Operador.ApellidoP apellidop, Operador.ApellidoM apellidom, Economico.Economico economico, Economico.Placas placas, 
           Cliente.Nombre cliente, ClienteDireccion.NombreSucursal sucursal,Agencia.nombre agencia, CuotaDetalle.Trafico trafico,
           CuotaDetalle.TipoViaje TipoViaje,Flete.Fecha Fecha,Flete.statusA statusA 
           from 
           Cuota,Socio,Flete, Operador, Economico, Cliente, CuotaDetalle, ClienteDireccion, Agencia,VehiculoDetalle, Cuota_Flete
           where
           Operador.Eco = VehiculoDetalle.Operador and Economico.Economico = VehiculoDetalle.Economico and Socio.idSocio = VehiculoDetalle.Socio
           and Flete.Operador = VehiculoDetalle.Operador and Flete.Economico = VehiculoDetalle.Economico and Flete.Socio = VehiculoDetalle.Socio
           and Flete.Agencia_idAgente = Agencia.idAgente
           and Flete.idFlete = Cuota_Flete.NumFlete and

            Cuota_Flete.Sucursal = ClienteDireccion.Sucursal and Cuota_Flete.TipoCuota = CuotaDetalle.numero and
            Cuota_Flete.Cuota = CuotaDetalle.Cuota_idCuota and CuotaDetalle.Cuota_idCuota = Cuota.idCuota and Cuota.idCuota = ClienteDireccion.Cuota_idCuota 
            and ClienteDireccion.Cliente_idCliente = Cliente.idCliente
            and Flete.Fecha > :fecha
            ORDER BY idFlete ASC';

               $stmt = $mysqli->prepare($sql);
               $stmt->bindParam(':fecha', $hoy);
               $stmt->execute();
               $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

              foreach($rows as $fila){
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
            }
            catch(PDOException $e){
              $salida = $e;
            }     
	return $salida;
}
// Verificar constantes para conexión al servidor

	// Conexión con la base de datos	
?>