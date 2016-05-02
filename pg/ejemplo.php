<?php

  $connection = new mysqli($db_host, $db_user, $db_password, $db_name);


  if ($connection->connect_errno) {
      printf("Connection failed: %s\n", $mysqli->connect_error);
      exit();
  }


  if ($result = $connection->query("SELECT * FROM producto;")) {


  ?>


CONSULTAS:

BARRAS: PEDIDOS POR CLIENTE
CIRCULO: VENTAS POR CATEGORIA
LINEAS 1: PEDIDOS MAS CAROS
LINEAS 2: ARTICULOS MAS VENDIDOS



<?php
  foreach(){
    echo '['.$producto.', '.$cantidad.']';
  }
?>
