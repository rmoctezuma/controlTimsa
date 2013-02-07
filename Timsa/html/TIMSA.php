<?php
  include('../includes/consulta.timsa.php');
                    // MAnda a llamar la función para mostrar la lista de usuarios
                    $consultaUsuarios = consultaFletes();                   
?>
<!DOCTYPE html>


<html>
	<head>
		<meta charset="utf-8">
		<title> TIMSA LZC </title>

    <link rel="stylesheet" type="text/css" href="../css/bootstrap-modal.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-modalmanager.js"></script>
    <script src="../js/bootstrap-modal.js"></script>
    <script src="../js/bootstrap-collapse.js"></script>

    <script type="text/javascript" src="../js/MainAction.js"></script>
    

  <style>
      body {
        padding-top: 70px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
  </style>

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
          <a class="brand" href="#">TIMSA </a>

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
                <a href="./fletes.php">Fletes <i class="icon-th-large icon-white"> </i> </a>
              </li>
            </ul>
          </div>
    </div>
    </div>
  </div>

       <div class= "container">
        <div class="span6  offset3"><h1>Movimientos Actuales</h1>    
        </div> 
      </div>
      <hr>


    <div id= "loader">
      <div class="container">
      <fieldset id="ajaxLoader" class="ajaxLoader hide">
          <div class="progress progress-striped active">
            <div class="bar" style="width: 40%;"></div>
          </div>
          <p>Espere un momento...</p>
      </fieldset>
    </div>
    </div>


<div class="row-fluid" id="detalleFlete">
  <div class="span1"></div>
    <div class="span1">
 
          <ul class="nav nav-list">
                  <li class="active"><a href="#tabla"><i class="icon-home icon-white"></i> Home</a></li>
                  <br>
              </ul>
 
    </div>

        <div class="row-fluid span10">
            <div class="container span9">
               <div class="accordion" id="accordion2">
               </div>
            </div>
        </div>
     

  </div>


<div class= "container" id="tabla">
  <table class='table table-hover'>
    <thead>
      <tr>
        <th>#</th>
        <th>Operador</th>
        <th>Economico</th>
        <th>Placas </th>
        <th>Cliente</th>
        <th>Sucursal</th>
        <th>Agencia</th>
        <th>Trafico</th>
        <th>Tipo Viaje</th>
        <th>Status</th>
        <th>Hora</th>
        <th> </th>
        </tr></thead>
        <tbody>
            <?php
               echo $consultaUsuarios;
            ?> 
        </tbody>
  </table>

  <div id="botonFlete">
  <p class="span5"></p>
    <a href= "fletes/creacion.flete.php"><button class="btn btn-primary" type="button" onClick ="fletes/creacionFlete.html"> Crear Flete</button></a>
  </p>
</div>

</div>



</body>
</html>