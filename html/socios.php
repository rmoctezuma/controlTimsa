<?php
session_start();

if( isset($_SESSION) && !empty($_SESSION)){
  if( $_SESSION['tipo'] == "Administrador" ){
?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title> TIMSA LZC </title>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.validate.js"></script>
    <script src="../js/CrearSocioAction.js"></script>
  <style>
      body {
        padding-top: 40px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
       #SocioList {
        width:300px;
        height:650px;
        overflow:scroll;
      }
      </style>

        <style type="text/css">
    .containerForm {
        width: 500px;
        clear: both;
    }
    .containerForm input {
        width: 98%;
        clear: both;
    }

    .containerForm select {
        width: 100%;
        clear: both;
    }

    #botonCancelar {
        width: 98%;
        clear: both;
    }
  </style>

  </head>

  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
                <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="TIMSA.php"><img height="35" width="35" src="../img/logo.png"></a>

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
              <li class="active">
                <a href="#">Socios <i class="icon-bookmark icon-white"> </i> </a>
              </li>
              <li >
                <a href="./cuotas.php">Cuotas <i class="icon-fire icon-white"> </i> </a>
              </li>
                 <li class="">
                <a href="./fletes.php">Fletes <i class="icon-th-large icon-white"> </i> </a>
              </li>
            </ul>
          </div>
           <button form="form1" class="btn btn-inverse"> <i class="icon-off icon-white"></i> Cerrar Sesion </button>
        </div>
    </div>
  </div>


<div class= "container span2" id="SocioList">
  <form action="../includes/cerrar.sesion.php" id="form1"></form>
  <h1> Socios </h1>
  <button class="btn btn-primary" id="botonCrear"> Crear nuevo Socio</button>
  <br>
  <br>
  <br>

    <?php
        $PDOmysql = null;
        $salida="";

        try {
            $PDOmysql = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');


       $sql = 'select distinct idSocio,Nombre,Telefono,rutaImagen from Socio  where  statusA = "Activo"';

       foreach ($PDOmysql -> query($sql) as $fila) {
           $nombre = $fila['Nombre'];
           $telefono = $fila['Telefono'];

           $salida.=   '<ul class="media-list">
                          <li class="media" title="'.$fila['idSocio'].'">
                             <a class="pull-left" href="#">
                              <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 64px; height: 64px;"  src='.$fila['rutaImagen'].'>
                            </a>
                            <div class="media-body">
                              <h4 class="media-heading">'.$nombre.'</h4>
                              <p> <small> '.$telefono.' </small> </p>
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

  <div class= "container span9" id="result">
    <br>
    <br>
    <br>
    <?php
    if(isset($_GET['resultado']) && !empty($_GET)){
        echo '<h2 id= "mensajeCreacion">';
              if($_GET['resultado'] == "correcto"){
                  echo ' Socio agregado correctamente';
                }
                else{
                  echo ' El socio no se ha podido agregar';
                }
        echo '</h2>';
    }
  ?>
  </div>

  <div class="container containerForm" id="CreacionSocio">
    <br>
    <h1> Nuevo Socio</h1>
    <br>

    <form method="POST" action="../includes/crearSocio.php" enctype="multipart/form-data" id="formSocio">
      <label> Nombre del Nuevo Socio </label>
      <input required type="text" name="NombreSocio" placeholder="Nombre del Socio"> <br>
      <label>Apellido Paterno</label>
      <input required type="text" name="ApellidoSocio" placeholder="Apellido Paterno"> <br>
      <label>Apellido Materno</label>
      <input required type="text" name="ApellidoMSocio" placeholder="Apellido Materno"> <br>
      <label>Telefono</label>
      <input required type="text" name="telefono" placeholder="Telefono"><br>
      <label> Sube una foto del Operador. Este es un campo opcional.</label>
      <input type="file" name="archivo" id="archivo" /><br>
      <input type="submit" class="btn btn-primary" name="boton" value="Subir" id="submit"/>
      <button class="btn" type="reset" id="botonCancelar"> Cancelar</button>
    </form>

  </div>
</html>

<?php
  }
  else{
    header("Location:../../index.php");
  }
  }
  else{
    header("Location:../../index.php");
  }

?>