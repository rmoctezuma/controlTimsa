<?php
require_once("../Pagination/Paginacion.php");
include_once('../includes/generic.connection.php');

$pages = new Paginacion;
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> TIMSA LZC </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/jquery.validate.js"></script>
    <script type="text/javascript" src="../js/fletes.paginados.action.js"></script>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">

  <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
  </style>

    <style type="text/css">
    #reutilizarFlete {
        width: 600px;
        clear: both;
    }

    #reutilizarFlete table{
        width: 500px;
        clear: both;
    }
    #reutilizarFlete input[type="text"] {
        width: 98%;
        clear: both;
    }

    #reutilizarFlete select {
        width: 100%;
        clear: both;
    }

    #reutilizarFlete textarea{
        width: 100%;
        clear: both;
    }

    #reutilizarFlete input{
        width: 100%;
        clear: both;
    }

    #reutilizarFlete label{
        width: 100%;
        clear: both;
    }

    #reutilizarFlete input[type="radio"]{
        width: 10%;
        clear: both;
    }

    #botonCancelar {
        width: 98%;
        clear: both;
    }

    .inline li {
        display: inline;
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

  <div id="InfoFletes">

  <div id="Titulo" class="container">
    <h1>Control de Fletes</h1>

    <ul class="inline">
      <li class="span4">
    <label style="display:inline-block"  for="tipoConsulta"> Tipo de Consulta</label>
    <select  id="tipoConsulta" ONCHANGE="location = this.options[this.selectedIndex].value;">
      <option value="fletes.php?tipoConsulta=DIA&anio=<?php echo $pages->anio   ?> " <?php if($pages->tipoConsulta == "DIA") echo "selected" ?>  >Dia</option>
      <option value="fletes.php?tipoConsulta=SEMANA&anio=<?php echo $pages->anio   ?> "<?php if($pages->tipoConsulta == "SEMANA") echo "selected" ?> >Semana</option>
      <option value="fletes.php?tipoConsulta=MES&anio=<?php echo $pages->anio   ?>"<?php if($pages->tipoConsulta == "MES") echo "selected" ?>  >Mes</option>
      <option value="fletes.php?tipoConsulta=ANIO&anio=<?php echo $pages->anio   ?>"<?php if($pages->tipoConsulta == "ANIO") echo "selected" ?> >Año</option>
    </select>
    </li>
    <li  class="span4">
    <label style="display:inline-block"  for="año"> Año</label>
    <select  id="año" ONCHANGE="location = this.options[this.selectedIndex].value;">
      <?php
        for ($i=13; $i <= 25; $i++) { 
          $nuevoAño = '20' . $i;
          if($nuevoAño == $pages->anio) $seleccion = "selected"; else  $seleccion = "";

          echo '<option value='."fletes.php?tipoConsulta=$pages->tipoConsulta&anio=$nuevoAño".' '. $seleccion . '>'.$nuevoAño .' </option>';
        }
      ?>
    </select> 
    </li>
    </ul>
    <br>
  </div>
  <br>
  <br>



  <div id="results" class="container">

<?php
  $pages->paginate();
  echo $pages->display();
?>
</div>

<div id="paginas" class="container">
  <?php
  echo $pages->crearPaginacion();
  ?>
</div>

</div>

<div id="detallesFlete" class="container">
        <h1 id="titulo"> <a href="#" id="back"><img src="http://control.timsalzc.com/Timsa/img/back-arrow.png" class="img-rounded"></a> Detalles de Flete </h1>
        <br>
          <div class="row-fluid span10">
            <div class="container span9">
               <div class="accordion" id="accordion3">
               </div>
            </div>
        </div>
        <div id="confirmacionFlete">
          <h4>¿Realmente desea finalizar este flete?</h4>
          <button id="cancelar" class="btn">Cancelar</button>
          <button id="confirmar" class="btn btn-primary">Aceptar</button>
        </div>
        <div id="confirmarReutilizarFletes">
          <h4>¿Desea utilizar los mismos contenedores?</h4>
          <button class="contenedoresAcceso btn btn-warning" value="false" >No</button>
          <button class="contenedoresAcceso btn btn-primary" value="true">Si</button>
          <button class="contenedoresAcceso btn btn" value="cancelar">Cancelar</button>
        </div>

</div>
<div id="reutilizarFlete" class="container">
</div>

</body>

</html>