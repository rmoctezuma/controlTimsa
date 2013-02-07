<?php

$respuestaOK = true;
$mensajeError = "No se puede ejecutar la aplicación";
$contenido = "";

if(isset($_POST) && !empty($_POST)){	

       	$value = $_POST['value'];


        if($_POST['action'] == "Cliente"){
          $mysqli = consulta();

          $sql= 'select Ciudad,Localidad,Cuota_idCuota from ClienteDireccion where Cliente_idCliente = '.$value.' and StatusA = "Activo"';

          $contenido .= '<div id="botonGroup" class="btn-group" data-toggle="buttons-radio">';

          foreach ($mysqli -> query($sql) as $fila) {
          	$contenido .= '<button type="button" title="'.$fila['Cuota_idCuota'].'" class="btn span3" data-toggle="button">'.$fila['Localidad'].' , '.  $fila['Ciudad']. '</button>';
          }

          $contenido .= '</div>';

        }

        else if($_POST['action'] == "Socio"){
          $mysqli = consulta();
          $Contador = 0;
          

          $sql= 'select distinct VehiculoDetalle.Economico num, Economico.Placas plac, Economico.statusA  status
          from 
          VehiculoDetalle,Economico 
          where 
          VehiculoDetalle.Socio = '.$value.' 
          and 
          VehiculoDetalle.Economico = Economico.Economico 
          and
          VehiculoDetalle.statusA = "Activo"
          and
          Economico.statusA <> "Deprecated" ';

          $contenido .= '<div id="botonGroupEconomico" class="btn-group" data-toggle="buttons-radio">';

          foreach ($mysqli -> query($sql) as $fila) {
              if($fila['status'] == 'Libre'){
                if($Contador == 3) {$contenido .= '<br>';}
                $Contador += 1;
                  $contenido .= '<button type="button" title="'.$fila['num'].'" class="btn btn-large " data-toggle="button">'.$fila['plac']. '</button>';
              }
              else{
                if($Contador == 3) {$contenido .= '<br>';}
                $Contador += 1;
                 $contenido .= '<button type="button" title="'.$fila['num'].'" class="btn btn-large disabled " disabled = "disabled" data-toggle="button">'.$fila['plac']. '</button>';
              }
          }

          $contenido .= '<div>';
        }

        else if($_POST['action'] == "Operador"){
          $mysqli = consulta();

          $sql = 'select Operador.Eco operador,Operador.Nombre nombre, Operador.ApellidoP apellidop, Operador.ApellidoM apellidom, Operador.statusA status
          from 
          Operador,VehiculoDetalle
          where
          Operador.Eco = VehiculoDetalle.Operador
          and
          VehiculoDetalle.Socio = '.$_POST['Socio'] .'
          and
          Operador.statusA <> "Deprecated"
          and
          VehiculoDetalle.Economico = '.$_POST['Economico'];

          $contenido .= ' <h4> Operadores que han conducido este economico </h4>';
          $contenido .= ' <div id= "RadioOperadores">';

          foreach ($mysqli -> query($sql) as $fila) {
            if( $fila['status'] == 'Libre'){

              $contenido .= '<label class="radio">
                                <input type="radio" name="optionsRadios" value="'.$fila['operador'].'">
                                '.$fila['nombre']  .  $fila['apellidop'] .  $fila['apellidom'] .'
                              </label>';
                            }

                            else{
                                $contenido .= '<label class="radio">
                                                <input type="radio" disabled="disabled" name="optionsRadios" value="'.$fila['operador'].'">
                                                '.$fila['nombre']  .  $fila['apellidop'] .  $fila['apellidom'] .'
                                              </label>';
                            }
          }

          $contenido .= '</div>';

        }
        else if($_POST['action'] == "Tarifa"){
          $mysqli = consulta();

          $sql = 'select CuotaDetalle.numero num, CuotaDetalle.Trafico trafico, CuotaDetalle.TipoViaje tipoviaje, CuotaDetalle.Tarifa tarifa
                  from
                  CuotaDetalle,Cuota
                  where
                  CuotaDetalle.Cuota_idCuota ='. $_POST['value'].'
                  and
                  Cuota.idCuota = '. $_POST['value'] ;

                  $contenido .= '<div id="botonGroupTarifa" class="btn-group" data-toggle="buttons-radio">';

                  foreach ($mysqli -> query($sql) as $fila) {
                    $contenido .= '<button type="button" title="'.$fila['num'].'" class="btn btn-large " data-toggle="button">'.$fila['trafico']. $fila['tipoviaje']. $fila['tarifa'] .'</button>';
                  }

                  $contenido .= '</div>';
        }
      else{
        $contenido.= " Ninguna Accion";
      }
    }

$salidaJson = array("respuesta" => $respuestaOK,
					"mensaje" => $mensajeError,
					"contenido" => $contenido);

echo json_encode($salidaJson);

      function consulta(){
        try {
              $mysqli = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');
              $errorDbConexion = false;
                } catch(PDOException $ex) {
                    echo "An Error occured!"; //user friendly message
                    echo $ex->getMessage();

                    $contenido .= '
                        <tr id="sinDatos">
                          <td >ERROR AL CONECTAR CON LA BASE DE DATOS</td>
                          </tr>';
                          $respuestaOK = false;
          }
          return $mysqli;
      }

?>