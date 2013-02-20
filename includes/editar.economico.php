<?php

$resultado = "";

include('../includes/generic.connection.php');

if(isset($_POST) && !empty($_POST)){
	$economico = $_POST['economico'];

	$resultado .= '<select name="operador">';
        $sql = 'select Operador.Nombre nombre, Operador.ApellidoP apellido, Operador.ApellidoM apellidom, Operador.Eco economico
          from  Operador where statusA <> "deprecated" Order by Nombre asc';

          $stmt = $PDOmysql->query($sql);
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

           foreach ($rows as $fila) {
            $resultado .= '<option value="'. $fila['economico'].'">'.$fila['nombre']. ' '. $fila['apellido'] .' '. $fila['apellidom'] .  ' </option><br>';
          }    
}

?>