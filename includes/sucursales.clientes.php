<?php

include("../includes/generic.connection.php");

  $array =  array();
  $arrayLatLon = array();

if(isset($_POST) && !empty($_POST)){
	$numero = $_POST['numero'];

 try {  
       $PDOmysql = consulta();

       $sql = 'select distinct Sucursal id, NombreSucursal Nombre, Lat, Lon from ClienteDireccion where Cliente_idCliente = :cliente';

       $stmt = $PDOmysql->prepare($sql);
       $stmt->bindParam(':cliente', $numero);
       $stmt->execute();
       $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

       foreach ($rows as $fila) {
        $array[$fila['id']] = $fila['Nombre'];
        $arrayLatLon[$fila['id']] =  array( $fila['Lat'] , $fila['Lon'] );
       }

       echo $salida;

        } catch(PDOException $ex) {
          echo "An Error occured!"; //user friendly message
          echo $ex->getMessage();
          $salida .= '<tr id="sinDatos">
                        <td >ERROR AL CONECTAR CON LA BASE DE DATOS</td>
                      </tr>';
        }
    }

  $resultados = array("nombres" => $array,
                       "LatLon" => $arrayLatLon);

  echo json_encode($resultados);

?>