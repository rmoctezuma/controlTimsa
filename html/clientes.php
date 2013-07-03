<?php

session_start();

if( isset($_SESSION) && !empty($_SESSION)){
  if( $_SESSION['tipo'] == "Administrador" ){

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
          #busqueda {width: 360px;}
          }
          </style>
          
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript" src="../js/jquery.validate.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
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
                  <li class="active">
                    <a href="#">Clientes <i class="icon-list icon-white"> </i> </a>
                  </li>
                  <li class="">
                    <a href="./socios.php">Socios <i class="icon-bookmark icon-white"> </i> </a>
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
        <form action="../includes/cerrar.sesion.php" id="form1"></form>
      </div>
      </header>
      
      <div class="row" style="width:100%; height:80%">
      <div id="Mapa" class="span5" style="width:60%; height:100%">
        
      </div>

      <div id="mensajes" class="span4">
        <h1 id= "mensajeSucursal">Mensaje</h1>
      </div>

      <div class="span4" id="ListaClientes">
        <?php
              if(isset($_GET['sucursal']) && !empty($_GET)){
                echo '<h2 id= "mensajeCreacion">';
                      if($_GET['sucursal'] == "agregada"){
                          echo ' Sucursal agregada correctamente';
                        }
                        else{
                          echo ' La Sucursal no se ha podido agregar';
                        }
                echo '</h2>';
                  }
      ?>

          <?php
              if(isset($_GET['resultado']) && !empty($_GET)){
                echo '<h2 id= "mensajeCreacion">';
                      if($_GET['resultado'] == "correcto"){
                          echo ' Cliente agregado correctamente';
                        }
                        else{
                          echo 'El cliente no se ha podido agregar';
                        }
                echo '</h2>';
                  }
        ?>

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
                                  <button class="NuevaSucursal btn btn-primary btn-mini"> Nueva Sucursal</button>
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

        <button class="btn" id="AgregarCliente"> Agregar cliente</button>
      </div>

        <div id="NuevoFlete" class="span4">
          <h3>Crear un nuevo Cliente</h3>

        <form method="POST" action="../includes/crear.cliente.php"  enctype="multipart/form-data" id="nuevaCreacionCliente">
          <label> <b>Nombre</b> </label> <input type="text" class="required" name="nombre" placeholder="Nombre del Cliente"> <br>
          <label> Sube una foto del Cliente. Este es un campo opcional, pero es la imagen que aparecera en el mapa para definir sucursales. </label>
          <input type="file" name="archivo" id="archivo" /><br>
          <button class="btn btn-primary" type="submit"> Crear </button>
          <button class="btn" id="cancelarCreacion"> Cancelar</button>
        </form>
        </div>

        <div id="InfoNueva-Sucursal" class="span4">
          <h1 id="tituloSucursal">Creacion de nueva Sucursal</h1>
          <h5>
            Seleccione en el mapa, el lugar donde quiere colocar la nueva sucursal.
            Especifique sus datos, y seleccione la cuota que la sucursal necesite.
            Si posee la direccion, puede insertarla en el campo siguiente, para localizar 
            el punto exacto en el mapa. 
          </h5>
          <label> Busqueda </label><br>
           <input type="text"  id="busqueda" placeholder="Ejemplo: Morelos, Ciudad Lázaro Cárdenas, Michocan">
           <button class="btn btn-mini btn-primary" id="buscar">Buscar</button> <br><br>
          <button class="btn btn-large" id="cancelarCreacion-Sucursales"> Cancelar creacion. </button>
        </div>

      </div>

      <div class="container" id="Sucursal">
        <div id="EspecificacionesSucursales">
          <h2>Especificaciones de Sucursal</h2>
        </div>

        <div>
          <button class="btn" data-toggle="button" id="DetallesRutas"> Mostar Ruta </button>
        </div>

        <div id="Rutas">
           <h3>Ruta desde </h3>
        </div>
    </div>
        
    </body>

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

