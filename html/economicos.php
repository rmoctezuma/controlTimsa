<?php

session_start();

if( isset($_SESSION) && !empty($_SESSION)){
  if( $_SESSION['tipo'] == "Administrador" ){


include('../includes/generic.connection.php');
$PDOmysql = consulta();

$statusTipo = array("Ocupado" => "label label-warning",
                    "Libre" => "label label-success",
                    "Indispuesto" => "label label-important"
                    );

function consultaAnio(){
  $fecha = "";
   for($i=date('o') + 1; $i>=1910; $i--){
            if ($i == date('o') + 1)
                $fecha.= '<option value="'.$i.'" selected>'.$i.'</option>';
            else
               $fecha.='<option value="'.$i.'">'.$i.'</option>';
        }
        return $fecha;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> TIMSA LZC </title>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">

  <style type="text/css">

    #editarEconomicoForm{
        width: 500px;
        clear: both;
    }

    #editarEconomicoForm input {
        width: 98%;
        clear: both;
    }

    #editarEconomicoForm select {
        width: 100%;
        clear: both;
    }

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

    #cancelarEdicion {
        width: 98%;
        clear: both;
    }

  </style>

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
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <script type="text/javascript" src="../js/economico.action.js"></script>
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
          <a class="brand" href="TIMSA.php"><img height="35" width="35" src="../img/logo.png"> </a>

          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="">
                <a href="operadores.php">Operadores <i class="icon-user icon-white"></i> </a>
              </li>
              <li class="active">
                <a href="#">Economicos <i class="icon-road icon-white"> </i> </a>
              </li>
              <li class="">
                <a href="./clientes.php">Clientes <i class="icon-list icon-white"> </i> </a>
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
  </div>


  <div id="MuestraEconomicos">
    <div class= "container">
      <form action="../includes/cerrar.sesion.php" id="form1"></form>
        <div class="page-header">
          <h1>Economicos <button class="btn btn-mini btn-primary" id="nuevoEconomico"> Crear Nuevo Economico</button></h1>

        </div>
    </div>
    <?php
      if(isset($_GET['resultado']) && !empty($_GET)){
        echo '<h2 id= "mensajeCreacion">';
              if($_GET['resultado'] == "correcto"){
                  echo ' Economico agregado correctamente';
                }
                else{
                  echo ' El economico no se ha podido agregar';
                }
        echo '</h2>';
              }

      try {
          $PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = 'select distinct Socio.idSocio, Socio.Nombre nombreSocio, Economico.Economico economico, Economico.Placas placas, Economico.statusA status
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
              if( strlen($nombreSocio) > 0 ){
                echo '</ul>';
                echo '</div>';
              }

              $nombreSocio = $fila['nombreSocio'];
              echo '<div class="container">';
              echo '<h4> '. $fila['nombreSocio'] .' </h4>
                    <ul class="inline">';
            }

            echo '<li class="span2">
                    <span title="'.$fila['idSocio'].'">
                        <a href="#" class="camiones"><img title="'.$fila['economico'].'" src="../img/camion.jpg" class="img-rounded"></a>
                         <span class="'. $statusTipo[$fila['status']] .'">'. $fila['economico'] .'</span> <h6 >'.$fila['placas'].' </h6> 
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
</div>

  <div id ="economicoDetalle" class="container">
    
  </div>

  <div id="formEconomico" class="container containerForm">
    <br>
    <h1>  Nuevo Economico </h1>
    <br>
    <form method="POST" action="../includes/crearEconomico.php" enctype="multipart/form-data" id="formEco">
      <label> <b>Numero de Economico</b> </label> <input required id="number" type="number" min="1" name="numero" placeholder="Numero de Economico"> <br>
      <div class="statusClave"><span id="statusClaveModificada" value="false" class="label label-important">Coloca una clave</span> </div>
      <label> <b>Placas</b> </label> <input  type="text" name="Placas" placeholder="Numero de Placas"> <br>
      <?php
        echo '<label><b> Socio  </b> </label> <select name="socio">';
        $sql = 'select Socio.Nombre nombreSocio, Socio.idSocio
          from  Socio where statusA <> "deprecated" order by Nombre asc';

          $stmt = $PDOmysql->query($sql);
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($rows as $fila) {
            echo '<option value="'. $fila['idSocio'].'">'.$fila['nombreSocio'].' </option>';
          }

        echo '</select>';
        echo '<br>';
        echo '<label> <b> Operador </b></label>      <select name="operador">';

        $sql = 'select Operador.Nombre nombre, Operador.ApellidoP apellido, Operador.ApellidoM apellidom, Operador.Eco economico
          from  Operador where statusA <> "deprecated" Order by Nombre asc';

          $stmt = $PDOmysql->query($sql);
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

           foreach ($rows as $fila) {
            echo '<option value="'. $fila['economico'].'">'.$fila['nombre']. ' '. $fila['apellido'] .' '. $fila['apellidom'] .  ' </option><br>';
          }
          echo '</select>';
      ?><br>

      <label> <b>Serie</b> </label> <input type="text" required name="numeroSerie" placeholder="Numero de Serie"> <br>
      <label> <b>Modelo</b> </label> <select name="modelo" id="Modelo"> <?php echo consultaAnio() ?> </select> <br>
      <label> <b>Transponder</b> </label> <input type="text" name="transponder" placeholder="Numero de Transponder"> <br>
      <label> <b> Marca </b> </label> 
      <select name="marca">
        <?php

          $sql = 'SELECT distinct Nombre, idMarca from Marca';

            $stmt = $PDOmysql->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
              echo '<option value="'. $fila['idMarca'].'">'.$fila['Nombre'].' </option>';
            }
        ?>
       </select>
      <label><b> Tipo de Vehiculo </b> </label> 
      <select name="tipoVehiculo">
        <?php
            $sql = 'SELECT distinct Nombre, idTipoVehiculo from TipoVehiculo';

            $stmt = $PDOmysql->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
              echo '<option value="'. $fila['idTipoVehiculo'].'">'.$fila['Nombre'].' </option>';
            }
        ?>
      </select>
      
      <br>
      <br>
      <input type="submit" name="submit" class="btn btn-primary" name="boton"  id="submit" value="Subir"/> 
      <br>
      <button class="btn" type="reset" id="botonCancelar"> Cancelar</button>
    </form>
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