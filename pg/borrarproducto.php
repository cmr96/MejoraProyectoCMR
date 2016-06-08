<?php
session_start();
if(isset($_SESSION['permisos']) && $_SESSION['permisos']['productos'][2]){
?>
<?php
 include_once("./db_configuration.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
  </head>
  <body>


<?php
$connection = new mysqli($db_host, $db_user, $db_password, $db_name);
$link=$_GET["id_producto"];
$link2=$_GET["precio_unit"];

$delete1="DELETE FROM producto WHERE id_producto='$link'";
$delete2="UPDATE pedido SET precio=(precio-$link2),observaciones='Un producto que contenia ha sido eliminado' WHERE id_pedido IN (SELECT id_pedido FROM entrada_pedido WHERE id_producto='$link')";
$delete3="DELETE FROM entrada_pedido WHERE id_producto='$link'";

$connection->query( $delete2 );
$connection->query( $delete3 );
$connection->query( $delete1 );


header("refresh:0; url=producto.php");
?>

</body>
</html>

<?php
}
else{
  header("Location:home.php");
}
  ?>
