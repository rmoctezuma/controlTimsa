<?php

include("../includes/generic.connection.php");
$PDOmysql = consulta();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> TIMSA LZC </title>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">
  <style>
      body {
        padding-top: 60px;
       /* 60px to make the container go all the way to the bottom of the topbar */
      }
      </style>

      <style >
      .hero-unit {
        background-image: url('../images/hero-wide-opt.jpg');
        color: white;
        height: 200px;
        text-align: center;
        overflow: hidden;
        background-position: 50% top;
        background-repeat: no-repeat;
        background-color: white;
      }

        .text-center{
          text-align: center;
        }

        th {
          text-align: center;
        }
      </style>

  </head>

  </head>

  <body>
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
                <a href="./clientes.php">Clientes <i class="icon-list icon-white"> </i> </a>
              </li>
              <li class="">
                <a href="./socios.php">Socios <i class="icon-bookmark icon-white"> </i> </a>
              </li>
              <li class="active">
                <a href="#">Cuotas <i class="icon-fire icon-white"> </i> </a>
              </li>
                 <li class="">
                <a href="./fletes.php">Fletes <i class="icon-th-large icon-white"> </i> </a>
              </li>
            </ul>
          </div>
        </div>
    </div>
  </div>

  <div class="container text-center">

    <h1 class="text-center">Cuotas de Viajes Foraneos</h1>
    <br>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th rowspan=2> Num. Cuota </th>
        <th rowspan=2> Nombre </th>
        <th colspan=3 > Sencillo </th>
        <th colspan=3> Full</th>
        </tr>
        <tr>
          <th> Importacion </th>
          <th> Exportacion </th>
          <th> Reutilizado </th>

          <th> Importacion </th>
          <th> Exportacion </th>
          <th> Reutilizado </th>
        </tr>      
      
    </thead>
    <tbody>
      <?php
        try {
            $PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = 'SELECT distinct Cuota.idCuota num, Cuota.Lugar lugar
            from Cuota,CuotaDetalle
            where statusA = "Activo"';

            $stmt = $PDOmysql->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $lugar = "";

            foreach ($rows as $fila){            
                echo '<tr>';
                $numero = $fila['num'];
                echo '<td> '. $numero .' </td>';
                echo '<td> '. $fila['lugar'].' </td>';

                  $sql = 'SELECT distinct CuotaDetalle.Tarifa tarifa , CuotaDetalle.Trafico trafico, CuotaDetalle.TipoViaje tipo
                          from CuotaDetalle
                          where statusA = "Activo"
                          and  CuotaDetalle.Cuota_idCuota = :numcuota';

                  $nwestmt = $PDOmysql->prepare($sql);
                  $nwestmt->bindParam(':numcuota',$numero);
                  $nwestmt->execute();
                  $nwerows = $nwestmt->fetchAll(PDO::FETCH_ASSOC);

                    $ImpSen ="";
                    $ReuSen ="";
                    $ExpSen ="";
                    $ImpFull ="";
                    $ReuFull ="";
                    $ExpFull ="";

                  foreach ($nwerows as $nwefila){
                    echo $index;

                    switch ($nwefila['tipo']) {
                      case 'Sencillo':
                          switch ($nwefila['trafico']) {
                            case 'Exportacion':
                               $ExpSen = $nwefila['tarifa'];
                              break;
                            case 'Importacion':
                              $ImpSen = $nwefila['tarifa'];
                              break;
                            case 'Reutilizado':
                              $ReuSen = $nwefila['tarifa'];
                              break;
                          }
                        break;

                      case 'Full':
                        switch ($nwefila['trafico']) {
                              case 'Exportacion':
                                $ExpFull = $nwefila['tarifa'];
                                break;
                              case 'Importacion':
                                $ImpFull = $nwefila['tarifa'];
                                break;
                              case 'Reutilizado':
                                $ReuFull = $nwefila['tarifa'];
                                break;
                            }
                        break;
                    }
                  } 
                      echo '<td>'. $ImpSen.'</td>';
                      echo '<td>'. $ExpSen.'</td>';
                      echo '<td>'.$ReuSen.'</td>';
                      echo '<td>'.$ImpFull.'</td>';
                      echo '<td>'.$ExpFull.'</td>';
                      echo '<td>'.$ReuFull.'</td>';
                      echo '</tr>';                  
            }
          }
          catch(PDOException $e){
          }
      ?>
    </tbody>
  </table>
  <buttton class="btn btn-primary"> Nueva Cuota</button>
  </div>
</html>