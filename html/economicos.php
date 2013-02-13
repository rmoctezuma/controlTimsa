<?php
include('../includes/generic.connection.php');

$PDOmysql = consulta();

$statusTipo = array("Ocupado" => "label label-warning",
                    "Libre" => "label label-success",
                    "Indispuesto" => "label label-important"
                    );

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
      }

    .inline li {
        display: inline;
      }
  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script type="text/javascript" src="../js/jquery.validate.js"></script>
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
                <a href="#">Economicos <i class="icon-road icon-white"> </i> </a>
              </li>
              <li class="">
                <a href="./clientes.php">Clientes <i class="icon-list icon-white"> </i> </a>
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

<div class= "container">
    <div class="page-header">
      <h1>Economicos</h1> 
    </div>
</div>

  <div id="MuestraEconomicos">
    <?php

      try {
          $PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = 'select Socio.Nombre nombreSocio, Economico.Economico economico, Economico.Placas placas, Economico.statusA status
          from Economico,VehiculoDetalle, Socio
          where
          VehiculoDetalle.Economico = Economico.Economico
           and
          VehiculoDetalle.Socio = Socio.idSocio order by Socio.idSocio';

          $stmt = $PDOmysql->query($sql);
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $nombreSocio = "";

          foreach ($rows as $fila){

            if($nombreSocio != $fila['nombreSocio']){
              if( strlen($fila['nombreSocio']) > 0 ){
                echo '</ul>';
                echo '</div>';
              }

              $nombreSocio = $fila['nombreSocio'];
              echo '<div class="container">';
              echo '<h4> '. $fila['nombreSocio'] .' </h4>
                    <ul class="inline">';
            }

            echo '<li class="span2">
                      <span>
                        <img src="../img/camion.jpg" class="img-rounded">
                         <span class="'. $statusTipo[$fila['status']] .'">'. $fila['economico'] .'</span> <h6>'.$fila['placas'].' </h6> 
                      </span>
                    </li>';        
         }
           }catch(PDOException $ex) {
                //Something went wrong rollback!
                $PDOmysql->rollBack();
                echo $ex->getMessage();
                $respuestaOK = false;
            }        
    ?>
  </div> 

</body>

</html>