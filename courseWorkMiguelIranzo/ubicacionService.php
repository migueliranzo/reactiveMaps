<?php

$lat = $_POST['lat'];
$lon = $_POST['long'];
$dist = $_POST['rango'];
$option = $_POST['option'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ubicaciones";

// Creamos conexion
$con = new mysqli($servername, $username, $password, $dbname);
// Verificamos conexion
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

  $sql = "SELECT latitud, longitud, nombre, tipo, ( 6371 * acos( cos( radians(" . $lat .") ) * cos( radians( latitud ) ) * cos( radians( longitud ) - 
  radians(" . $lon .") ) + sin( radians(" . $lat .") ) * sin(radians(latitud)) ) ) 
  AS distancia FROM puntos_interes";

  if($option != "empty"){
    $sql .= " where tipo = " . $option ;
  }

  $sql .= " HAVING distancia < " . $dist ." ORDER BY distancia;";

    $result = $con->query($sql);
    $array = array();

    if ($result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
           $array[] = $row;
        }
      } else {
        echo "0";
      }
      
      echo json_encode($array);

?>