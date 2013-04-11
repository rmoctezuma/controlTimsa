<?php
require("../includes/Paginacion.php");
include('../includes/generic.connection.php');

$PDOmysql = consulta();

$sql = 'SELECT COUNT(*) FROM Flete';

$stmt = $PDOmysql->query($sql);

if($stmt){
  $elementos = $stmt->fetchColumn();
}
else{
  $elementos = 0;
}

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
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
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

  <div id="results">

<?php
  $pages = new Paginator;
  $pages->items_total = $elementos;
  $pages->mid_range = 9;
  $pages->paginate();
  echo $pages->display_pages();

  $sql =  "SELECT idFlete FROM Flete ORDER BY idFlete ASC $pages->limit";

 $newstmt = $PDOmysql->prepare($sql);
 $newstmt->execute();

 $rows = $newstmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $fila){
      echo '<h2> ID: '. $fila['idFlete'] .'</h2>';
    }

?>
</div>

</body>

</html>