<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="LTR">
<head>
<title>Mostrando los datos</title>
</head>
<body>

<?php

// conectamos a la base de datos
$conn = new mysqli("localhost", "root", "","pasantia2022-23");

if ($conn->connect_error) {
    die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
  } 

  //echo 'Conectado a la base de datos.<br>';

  $result = $conn->query("SELECT id, nombre FROM usuarios");
  $rows= array();
  while ($row=$result -> fetch_array()){
    $rows[]=$row;
  }

  $qryResult = array();
  $qryResult['logs']=$rows;
  echo json_encode($qryResult);
  //echo "Numero de resultados: $result->num_rows"."<br>";


  //while ($fila = mysqli_fetch_array($result)) {
    //echo json_encode($fila);
    //echo "<br>";
    //}
//$result->close();
  $conn->close();
?>
</div>

</body>
<html>