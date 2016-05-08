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

    if ($result = $connection->query("SELECT SUM(ep.cantidad) AS Cantidad, p.categoria AS Categoria FROM producto p, entrada_pedido ep WHERE p.id_producto = ep.id_producto GROUP BY p.categoria LIMIT 10;")) {
    while($obj = $result->fetch_object()) {
        if($contenido != ""){
          $contenido .= ', ';
        }

             $contenido.= '["'.$obj->Categoria.'", '.(($obj->Cantidad*100)/$total).']';
    }
}


//Free the result. Avoid High Memory Usages
$result->close();
unset($obj);
unset($connection);

} //END OF THE IF CHECKING IF THE QUERY WAS RIGHT

?>
<html>
  <head>
    <!--
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      -->
    <script type="text/javascript">

      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Categoria', 'Cantidad'],
        <?php
          echo $contenido;
        ?>
        ]);

        var options = {
          title: 'Ventas por Categoría',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart_3d" style="margin-top:40px;"></div>
  </body>
</html>
