<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> TIMSA LZC </title>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">
  <style>
      body {
        padding-top: 30px; /* 60px to make the container go all the way to the bottom of the topbar */
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


    <div class="hero-unit">
      <div class="container">
        <h1>Transportes Integrados de Michoacan </h1>
        <h2> Manejo de Cuotas</h2>
      </div>
      <p ><img src="../images/logo2.png" class="img-rounded"></p> 
    </div>
<div class= "container">
    <div class="page-header"><h1>Movimientos Actuales</h1> 
      <p>
        <button class="btn btn-primary" type="button">Nueva Cuota</button>
    </p>
    </div>

    <div class ="container">
      <?php
        $PDOmysql = null;
        $salida="";
        $statusTipo = array("Libre" => "label label-info",
                              "Ocupado" => "label label-warning",
                              "Indispuesto" => "label label-important",
                              );

        try {
            $PDOmysql = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');


       $sql = 'SELECT *
                FROM Flete
                WHERE DATE(Fecha) > "2013-01-25";';

       foreach ($PDOmysql -> query($sql) as $fila) {
           $nombre = $fila['Nombre'] .' '. $fila['ApellidoP'] .' '. $fila['ApellidoM'];
           $telefono = $fila['Telefono'];
           $status = $fila['statusA'];
           $ruta = $fila['rutaImagen'];
         }
       }
      ?>
    </div>


</html>