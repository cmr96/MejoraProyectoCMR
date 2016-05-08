<?php
include_once('db_configuration.php');
  $contenido = "";
  $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno) {
      printf("Connection failed: %s\n", $mysqli->connect_error);
      exit();
  }
  if ($result = $connection->query("SELECT SUM(ep.cantidad) AS Total FROM producto p, entrada_pedido ep WHERE p.id_producto = ep.id_producto")) {
  $contenido = "";
  $total = 0;

    while($obj = $result->fetch_object()){
        $total += $obj->Total;
    }
    $result->close();
    unset($obj);
    if ($result = $connection->query("SELECT SUM(ep.cantidad) AS Cantidad, p.nombre AS Producto FROM producto p, entrada_pedido ep WHERE p.id_producto = ep.id_producto GROUP BY p.nombre ORDER BY SUM(ep.cantidad) DESC LIMIT 4;")) {

    while($obj = $result->fetch_object()) {
             $contenido.= '<div class="elementografico"><b>Producto:</b> '.substr($obj->Producto, 0, 26).'...</br><b>Cantidad:</b> '.$obj->Cantidad.'</div></br>';

    }

}

$result->close();
unset($obj);
unset($connection);

} //END OF THE IF CHECKING IF THE QUERY WAS RIGHT

?>
<html>
  <head>
  </head>
  <body>
    <div>
      <h4 class="htitu">Productos más Vendidos</h4>
      <?php
      echo $contenido;
      ?>
    </div>
  </body>
</html>
