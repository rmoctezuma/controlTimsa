<?php

include("../includes/generic.connection.php");

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> TIMSA LZC </title>

    <link href="../css/bootstrap_map.css" rel="stylesheet" media="screen">
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">

    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0; padding-top: 42px; }
      }
      </style>
      
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBtcuK-xlIB2HQfUw9MGxt2boubzDNgALI&sensor=false">
    </script>

      <script type="text/javascript" src="../js/mapa.clientes.js"></script>
      <script type="text/javascript" src="../js/clientes.action.js"></script>
  </head>

  <body onload="initialize()">
    <header>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
         <div class="container">
          <div class="span2"></div>
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="TIMSA.php">TIMSA </a>

          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="">
                <a href="operadores.php">Operadores <i class="icon-user icon-white"></i> </a>
              </li>
              <li class="">
                <a href="./economicos.php">Economicos <i class="icon-road icon-white"> </i> </a>
              </li>
              <li class="">
                <a href=".#">Clientes <i class="icon-list icon-white"> </i> </a>
              </li>
              <li class="">
                <a href="./socios.php">Socios <i class="icon-bookmark icon-white"> </i> </a>
              </li>
              <li class="active">
                <a href="./cuotas.php">Cuotas <i class="icon-fire icon-white"> </i> </a>
              </li>
                 <li class="">
                <a href="./fletes.php">Fletes <i class="icon-th-large icon-white"> </i> </a>
              </li>
            </ul>
          </div>
        </div>
    </div>
  </div>
  </header>

  <div class="row" style="width:100%; height:80%">
  <div id="Mapa" class="span5" style="width:60%; height:100%">
    
  </div>

  <div class="span4"> 
    <h1>Clientes y Lugares</h1>
    <br>
    <?php
        $PDOmysql = null;
        $salida="";

      try {  

       $PDOmysql = consulta();

       $sql = 'select distinct idCliente,Nombre,rutaImagen from Cliente where statusA!="Deprecated"';

       foreach ($PDOmysql -> query($sql) as $fila) {
           $id= $fila['idCliente'];
           $nombre = $fila['Nombre'];
           $ruta = $fila['rutaImagen'];

           $salida.=   '<ul class="media-list">
                          <li class="media" title="'.$id.'">
                             <a class="pull-left" href="#">
                              <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 64px; height: 64px;"  src='.$fila['rutaImagen'].'>
                            </a>
                            <div class="media-body" id="media">
                              <h4 class="media-heading">'.$nombre.'</h4>
                            </div>
                          </li>
                        </ul>';
       }

       echo $salida;

        } catch(PDOException $ex) {
          echo "An Error occured!"; //user friendly message
          echo $ex->getMessage();
          $salida .= '<tr id="sinDatos">
                        <td >ERROR AL CONECTAR CON LA BASE DE DATOS</td>
                      </tr>';
        }

    ?>
  </div>
  </div>
    
</body>

</html>