<?php
header('Location: http://control.timsalzc.com/Timsa/html/TIMSA.php');
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
                <a href="./cuotas.php">Cuotas <i class="icon-fire icon-white"> </i> </a>
              </li>
                 <li class="">
                <a href="#">Fletes <i class="icon-th-large icon-white"> </i> </a>
              </li>
            </ul>
          </div>
        </div>
    </div>
  </div>


    <div class="hero-unit">
      <div class="container">
        <h1>Transportes Integrados de Michoacan </h1>
        <h2> Manejo de Fletes</h2>
      </div>
      <p ><img src="../images/logo2.png" class="img-rounded"></p> 
    </div>
<div class= "container">
    <div class="page-header"><h1>Fletes</h1> 
    </div>

  </div>

  <table class="table table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Operador</th>
        <th>Economico</th>
        <th>Cliente</th>
        <th>Sucursal</th>
        <th>Agencia</th>
        <th>Trafico</th>
        <th>Tipo Viaje</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <td>001</td>
      <td>Raul Moctezuma Pacheco</td>
      <td>001</td>
      <td>Samsung</td>
      <td>Mexico</td>
      <td>Merx</td>
      <td>Reutilizado</td>
      <td>Full</td>
      <td>A</td>
    </tr>
    </tbody>
</table>

</html>