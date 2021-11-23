<?php

$lat = $_POST['lat'];
$lon = $_POST['long'];
$dist = $_POST['rango'];
$option = $_POST['option'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ubicaciones";

//echo $option;

// Creamos conexion
$con = new mysqli($servername, $username, $password, $dbname);
// Verificamos conexion
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

/* SQL
  SELECT nombre, ( 6371 * acos( cos( radians(41.58463401188338) ) * cos( radians( latitud ) ) * cos( radians( longitud ) - 
  radians(-0.789642333984375) ) + sin( radians(41.58463401188338) ) * sin(radians(latitud)) ) ) 
  AS distance FROM puntos_interes WHERE tipo = 1
  HAVING distance < 25 ORDER BY distance LIMIT 0 , 20;
 */

  $sql = "SELECT latitud, longitud, nombre, tipo, ( 6371 * acos( cos( radians(" . $lat .") ) * cos( radians( latitud ) ) * cos( radians( longitud ) - 
  radians(" . $lon .") ) + sin( radians(" . $lat .") ) * sin(radians(latitud)) ) ) 
  AS distancia FROM puntos_interes";

  if($option != "empty"){
    $sql .= " where tipo = " . $option ;
  }

  $sql .= " HAVING distancia < " . $dist ." ORDER BY distancia LIMIT 0 , 20;";

  //echo $sql;

    $result = $con->query($sql);
    $array = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
         // echo "Nombre: " . $row["nombre"]. " a " . $row["distance"] . "km de distancia " . $row["latitud"] . " LAT "  . $row["longitud"] . " LONG ";
         $array[] = $row;
        }
      } else {
        echo "0";
      }
      
      echo json_encode($array);

?>