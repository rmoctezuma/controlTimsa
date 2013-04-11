<?php 
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